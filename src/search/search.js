/**
 * Global variables.
 */
import { toggleAccordionContent } from "../utils";

const { customElements, HTMLElement } = window;

/**
 * Initialize data store.
 */
import { store } from "./data";
const { getState, subscribe } = store;

/**
 * JoveSearch Class.
 */
class JoveSearch extends HTMLElement {
  /**
   * Constructor.
   */
  constructor() {
    super();

    // Initialize State.
    const state = getState();
    state.initialize(search_settings);
  }
}

/**
 * JoveCheckboxAccordion Class.
 */
class JoveCheckboxAccordion extends HTMLElement {
  /**
   * Constructor.
   */
  constructor() {
    super();

    // Elements.
    this.filterKey = this.getAttribute("key");
    this.content = this.querySelector(".checkbox-accordion__content");
    this.accordionHandle = this.querySelector(".checkbox-accordion__handle");

    if (!this.accordionHandle || !this.content || !this.filterKey) {
      return;
    }

    this.accordionHandle.addEventListener("click", (event) =>
      toggleAccordionContent(event, this, this.content)
    );
  }

  /**
   * Observe Attributes.
   *
   * @return {string[]} Attributes to be observed.
   */
  static get observedAttributes() {
    return ["active"];
  }

  /**
   * Attributes callback.
   *
   * Fired on attribute change.
   *
   * @param {string} name Attribute Name.
   * @param {string} oldValue Attribute's Old Value.
   * @param {string} newValue Attribute's New Value.
   */
  attributeChangedCallback(name, oldValue, newValue) {
    /**
     * If the state of this checkbox filter is open, then set then
     * active state of this component to true, so it can be opened.
     */
    if ("active" === name) {
      this.content.style.height = "auto";
    } else {
      this.content.style.height = "0px";
    }
  }
}
/**
 * JoveCheckboxAccordionChild Class.
 */
class JoveCheckboxAccordionChild extends HTMLElement {
  /**
   * Constructor.
   */
  constructor() {
    super();

    this.content = this.querySelector(".checkbox-accordion__child-content");
    this.accordionHandle = this.querySelector(
      ".checkbox-accordion__child-handle-icon"
    );
    this.inputEl = this.querySelector("input");

    // Subscribe to updates.
    subscribe(this.update.bind(this));

    if (this.accordionHandle && this.content) {
      this.accordionHandle.addEventListener("click", (event) =>
        toggleAccordionContent(event, this, this.content)
      );
    }
    if (this.inputEl) {
      this.inputEl.addEventListener("click", (event) =>
        this.handleCheckboxInputClick(event)
      );
    }
  }

  /**
   * Update the component.
   *
   * @param {Object} currentState Current state.
   */
  update(currentState = {}) {
    if (!this.inputEl) {
      return;
    }

    const { filters } = currentState;
    this.inputKey = this.inputEl.getAttribute("data-key");
    this.inputValue = this.inputEl.getAttribute("value");
    this.selectedFiltersForCurrentkey = filters[this.inputKey] || [];
    this.parentEl = this.inputEl.closest(".checkbox-accordion") || {};
    this.parentContentEl =
      this.inputEl.closest(".checkbox-accordion__child-content") || {};

    /**
     * If the current input value is amongst the selected filters, the check it.
     * and set the attributes and styles to open the accordion.
     */
    if (this.selectedFiltersForCurrentkey.includes(parseInt(this.inputValue))) {
      this.inputEl.checked = true;
      this.parentEl.setAttribute("active", true);
      if (this.parentContentEl.style) {
        this.parentContentEl.style.height = "auto";
      }
    } else {
      this.inputEl.checked = false;
      this.parentEl.removeAttribute("active");
    }
  }

  /**
   * Handle Checkbox input click.
   *
   * @param event
   */
  handleCheckboxInputClick(event) {
    const { addFilter, deleteFilter } = getState();
    const targetEl = event.target;
    this.filterKey = targetEl.getAttribute("data-key");

    if (targetEl.checked) {
      addFilter({
        key: this.filterKey,
        value: parseInt(targetEl.value),
      });
    } else {
      deleteFilter({
        key: this.filterKey,
        value: parseInt(targetEl.value),
      });
    }
  }
}
/**
 * JoveResults Class.
 */
class JoveResults extends HTMLElement {
  /**
   * Constructor.
   */
  constructor() {
    super();

    // Subscribe to updates.
    subscribe(this.update.bind(this));
  }

  /**
   * Update the component.
   *
   * @param {Object} currentState Current state.
   */
  update(currentState = {}) {
    const { resultMarkup, loading } = currentState;
    if (loading) {
      this.innerHTML = "<p>Loading...</p>";
    }
    if (resultMarkup && !loading) {
      this.innerHTML = resultMarkup;
    }
  }
}

/**
 * JoveLoadMore Class.
 */
class JoveLoadMore extends HTMLElement {
  /**
   * Constructor.
   */
  constructor() {
    super();

    // Subscribe to updates.
    subscribe(this.update.bind(this));

    this.querySelector("button").addEventListener("click", () =>
      this.handleLoadMoreButtonClick()
    );
    this.nextPageNo = this.getAttribute("next-page-no");
  }

  update(currentState = {}) {
    const { pageNo } = currentState;
    if (parseInt(this.nextPageNo) <= parseInt(pageNo)) {
      this.remove();
      return null;
    }
  }

  handleLoadMoreButtonClick() {
    const { loadMorePosts } = getState();
    loadMorePosts(this.nextPageNo);
  }
}

class JoveLoadingMore extends HTMLElement {
  constructor() {
    super();
    // Subscribe to updates.
    subscribe(this.update.bind(this));
  }

  update(currentState = {}) {
    const { loadingMorePosts } = currentState;
    if (loadingMorePosts) {
      this.innerHTML = "Loading more posts...";
    } else {
      this.innerHTML = "";
    }
  }
}

/**
 * JoveResults Class.
 */
class JoveResultsCount extends HTMLElement {
  /**
   * Constructor.
   */
  constructor() {
    super();

    // Subscribe to updates.
    subscribe(this.update.bind(this));
  }

  update(currentState = {}) {
    const { resultCount } = currentState;
    if (null !== resultCount) {
      this.innerHTML = `Results: ${resultCount} Posts`;
    }
  }
}

/**
 * Clear All Filters.
 */
class JoveClearAllFilters extends HTMLElement {
  /**
   * Constructor.
   */
  constructor() {
    super();

    const { clearAllFilters } = getState();
    this.clearAllFiltersButton = this.querySelector("button");

    this.clearAllFiltersButton.addEventListener("click", () => {
      clearAllFilters();
    });
  }
}

/**
 * Initialize.
 */
customElements.define("jove-checkbox-accordion", JoveCheckboxAccordion);
customElements.define(
  "jove-checkbox-accordion-child",
  JoveCheckboxAccordionChild
);
customElements.define("jove-search", JoveSearch);
customElements.define("jove-results", JoveResults);
customElements.define("jove-load-more", JoveLoadMore);
customElements.define("jove-loading-more", JoveLoadingMore);
customElements.define("jove-results-count", JoveResultsCount);
customElements.define("jove-clear-all-filters", JoveClearAllFilters);
