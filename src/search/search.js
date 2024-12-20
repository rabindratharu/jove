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
   *
   * This method is called when the component is created.
   * It initializes the component by setting the elements,
   * adding event listeners and initializing the state.
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
   *
   * This method is called when the component is created.
   * It sets up the component by setting the elements and
   * adding an event listener to the handle.
   */
  constructor() {
    super();

    // Elements.
    const filterKey = this.getAttribute("key");
    const content = this.querySelector(".checkbox-accordion__content");
    const accordionHandle = this.querySelector(".checkbox-accordion__handle");

    if (!accordionHandle || !content || !filterKey) {
      return;
    }

    // Add an event listener to the handle.
    accordionHandle.addEventListener("click", (event) => {
      // Toggle the content.
      toggleAccordionContent(event, this, content);
    });
  }

  /**
   * Observe Attributes.
   *
   * This property is part of the Web Components API and is
   * used to observe attributes changes on the component.
   *
   * @return {string[]} Attributes to be observed.
   */
  static get observedAttributes() {
    /**
     * The only attribute we care about is the "active" attribute.
     * This attribute is used to determine the state of the component.
     * If the attribute is set to "true", then the component is active
     * and the content is visible. If the attribute is set to "false",
     * then the component is not active and the content is hidden.
     */
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
     * If the state of this checkbox filter is open, then set the
     * active state of this component to true, so it can be opened.
     * This is done by setting the height of the content element to
     * "auto", so it can expand to its natural height.
     */
    if ("active" === name) {
      this.content.style.height = newValue ? "auto" : "0px";
    }
  }
}
/**
 * JoveCheckboxAccordionChild Class.
 */
class JoveCheckboxAccordionChild extends HTMLElement {
  /**
   * Constructor for JoveCheckboxAccordionChild.
   *
   * Initializes the component, sets up event listeners, and subscribes to state updates.
   */
  constructor() {
    super();

    // Selects the content element within the accordion child.
    this.content = this.querySelector(".checkbox-accordion__child-content");

    // Selects the accordion handle icon element.
    this.accordionHandle = this.querySelector(
      ".checkbox-accordion__child-handle-icon"
    );

    // Selects the input element within the accordion child.
    this.inputEl = this.querySelector("input");

    // Subscribe to state updates.
    subscribe(this.update.bind(this));

    // Add click event listener to toggle accordion content if handle and content are present.
    if (this.accordionHandle && this.content) {
      this.accordionHandle.addEventListener("click", (event) =>
        toggleAccordionContent(event, this, this.content)
      );
    }

    // Add click event listener to handle checkbox input click if input element is present.
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
   *
   * @return {void}
   */
  update(currentState = {}) {
    if (!this.inputEl) {
      return;
    }

    const { filters } = currentState;
    const inputKey = this.inputEl.getAttribute("data-key");
    const inputValue = this.inputEl.getAttribute("value");
    const selectedFiltersForCurrentkey = filters[inputKey] || [];
    const parentEl = this.inputEl.closest(".checkbox-accordion") || {};
    const parentContentEl =
      this.inputEl.closest(".checkbox-accordion__child-content") || {};

    /**
     * If the current input value is amongst the selected filters, the check it.
     * and set the attributes and styles to open the accordion.
     *
     * @type {boolean}
     */
    const isChecked = selectedFiltersForCurrentkey.includes(
      parseInt(inputValue)
    );

    /**
     * Update the checkbox element.
     */
    this.inputEl.checked = isChecked;

    /**
     * Update the parent element.
     */
    if (isChecked) {
      parentEl.setAttribute("active", true);
      /**
       * Open the accordion.
       */
      if (parentContentEl.style) {
        parentContentEl.style.height = "auto";
      }
    } else {
      parentEl.removeAttribute("active");
    }
  }

  /**
   * Handle Checkbox input click.
   *
   * @param {Event} event Event triggered by the user clicking on the checkbox.
   */
  handleCheckboxInputClick(event) {
    const { addFilter, deleteFilter } = getState();
    const targetEl = event.target;
    /**
     * Get the key of the filter.
     * The key is the attribute 'data-key' of the checkbox element.
     *
     * @type {string}
     */
    this.filterKey = targetEl.getAttribute("data-key");
    /**
     * If the checkbox is checked, add the filter.
     * Else, delete the filter.
     */
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
   *
   * This method is called when an instance of the component is created. It sets up the component by
   * subscribing to updates.
   */
  constructor() {
    super();

    // Subscribe to updates.
    // This method listens for changes in the state and calls the `update` method when the state changes.
    subscribe(this.update.bind(this));
  }

  /**
   * Update the component.
   *
   * @param {Object} currentState Current state.
   */
  update(currentState = {}) {
    const { resultMarkup, loading } = currentState;

    this.innerHTML = resultMarkup || (loading ? "<p>Loading...</p>" : "");
  }
}

/**
 * JoveLoadMore Class.
 */
class JoveLoadMore extends HTMLElement {
  /**
   * Constructor.
   *
   * Initializes the component and subscribes to state updates.
   */
  constructor() {
    super();

    // Subscribe to updates.
    subscribe(this.update.bind(this));

    // Get the next page number from the attribute.
    this.nextPageNo = this.getAttribute("next-page-no");

    // Add event listener to the button.
    this.querySelector("button").addEventListener("click", () =>
      this.handleLoadMoreButtonClick()
    );
  }

  /**
   * Updates the component.
   *
   * Removes the "Load More" button if the next page number is not greater than the current page number.
   *
   * @param {Object} currentState Current state.
   */
  update(currentState = {}) {
    const { pageNo } = currentState;
    if (parseInt(this.nextPageNo) <= parseInt(pageNo)) {
      this.remove();
    }
  }

  /**
   * Handles the load more button click.
   *
   * Calls the `loadMorePosts` function with the next page number.
   */
  handleLoadMoreButtonClick() {
    const { loadMorePosts } = getState();
    loadMorePosts(this.nextPageNo);
  }
}

class JoveLoadingMore extends HTMLElement {
  /**
   * Constructor.
   *
   * Initializes the component and subscribes to state updates.
   */
  constructor() {
    super();

    // Subscribe to updates.
    // This method listens for changes in the state and calls the `update` method when the state changes.
    subscribe(this.update.bind(this));
  }

  /**
   * Update the component.
   *
   * @param {Object} currentState Current state.
   *
   * This method is called when the state changes. It updates the component text depending on whether
   * the component is loading more posts or not.
   */
  update(currentState = {}) {
    const { loadingMorePosts } = currentState;

    // If loading more posts, show a loading message.
    if (loadingMorePosts) {
      this.innerHTML = "Loading more posts...";
    } else {
      // If not loading more posts, clear the component text.
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
   *
   * This method is called when an instance of the component is created. It sets up the component by
   * subscribing to updates.
   */
  constructor() {
    super();

    // Subscribe to updates.
    // This method listens for updates in the state and calls the `update` method when the state changes.
    subscribe(this.update.bind(this));
  }

  /**
   * Update the component.
   *
   * @param {Object} currentState Current state.
   */
  update(currentState = {}) {
    const { resultCount } = currentState;

    // If the result count is available, update the component text.
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
   *
   * We subscribe to updates and listen for button clicks.
   */
  constructor() {
    super();

    const { clearAllFilters } = getState();
    const clearAllFiltersButton = this.querySelector("button");

    // Add event listener to clear all filters button.
    clearAllFiltersButton.addEventListener("click", () => {
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
