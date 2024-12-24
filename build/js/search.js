/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/search-filter/constants.js":
/*!*************************************************!*\
  !*** ./resources/js/search-filter/constants.js ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   STORE_NAME: () => (/* binding */ STORE_NAME)
/* harmony export */ });
/**
 * Constants.
 */

const STORE_NAME = "jove_search";

/***/ }),

/***/ "./resources/js/search-filter/data.js":
/*!********************************************!*\
  !*** ./resources/js/search-filter/data.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   DEFAULT_STATE: () => (/* binding */ DEFAULT_STATE),
/* harmony export */   store: () => (/* binding */ store)
/* harmony export */ });
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./constants */ "./resources/js/search-filter/constants.js");
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./helpers */ "./resources/js/search-filter/helpers.js");
/**
 * External dependencies.
 */
const {
  persist,
  createStore,
  stores
} = window.zustand;

/**
 * Internal dependencies.
 */



/**
 * Constants.
 */
const DEFAULT_STATE = {
  restApiUrl: "",
  rootUrl: "",
  url: "",
  filterKeys: ["categories", "tags"],
  filters: {},
  filterIds: [],
  pageNo: 1,
  resultCount: null,
  noOfPages: 0,
  resultMarkup: "",
  loading: false,
  searchQuery: "" // New property for search query
};
const PERSISTENT_STATE_KEYS = [];

/**
 * Initialize.
 *
 * @param {Object} settings settings.
 */
const initialize = (settings = {}) => {
  var _settings$root_url;
  const stateFromUrl = getStateFromUrl((_settings$root_url = settings?.root_url) !== null && _settings$root_url !== void 0 ? _settings$root_url : {});
  setStateFromUrl(settings || {}, stateFromUrl || {});
  getResult();
};

/**
 * Set State From Url.
 *
 * @param {Object} settings Initial Settings.
 * @param {Object} stateFromUrl State From Url.
 */
const setStateFromUrl = (settings = {}, stateFromUrl = {}) => {
  var _settings$root_url2, _settings$rest_api_ur, _settings$filter_ids;
  // Set data to state.
  setState({
    rootUrl: (_settings$root_url2 = settings?.root_url) !== null && _settings$root_url2 !== void 0 ? _settings$root_url2 : "",
    restApiUrl: (_settings$rest_api_ur = settings?.rest_api_url) !== null && _settings$rest_api_ur !== void 0 ? _settings$rest_api_ur : "",
    filterIds: (_settings$filter_ids = settings?.filter_ids) !== null && _settings$filter_ids !== void 0 ? _settings$filter_ids : {},
    loading: true,
    ...stateFromUrl
  });

  // Action: Get result with data from state.
  getResult();
};

/**
 * Get State From Url.
 *
 * @param {String} rootUrl Root Url.
 *
 * @return {Object} data Data containing filters, page no, and url.
 */
const getStateFromUrl = (rootUrl = "") => {
  var _data$filters;
  const {
    filterKeys
  } = getState();
  const url = new URL(window.location.href);
  let data = {};

  // Build data from URL.
  // Add filters and page no to data.
  data = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getFiltersFromUrl)(url, filterKeys);

  // Add search query from the URL
  if (url.searchParams.has("s")) {
    data.searchQuery = url.searchParams.get("s");
  }

  // Get url with filter selection.
  data.url = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getUrlWithFilters)((_data$filters = data?.filters) !== null && _data$filters !== void 0 ? _data$filters : {}, rootUrl);
  return data;
};

/**
 * Get Result.
 */
const getResult = () => {
  const {
    restApiUrl,
    filters,
    pageNo,
    searchQuery
  } = getState();
  if (!restApiUrl) {
    return;
  }

  // Add query-params to rest api url.
  const params = {
    s: [searchQuery],
    ...filters,
    page_no: pageNo
  };
  const fetchUrl = restApiUrl + "?" + new URLSearchParams(params).toString();
  fetch(fetchUrl).then(response => response.json()).then(responseData => {
    var _responseData$posts, _responseData$total_p, _responseData$no_of_p, _responseData$total_p2, _responseData$posts2, _responseData$no_of_p2;
    const resultMarkup = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getResultMarkup)((_responseData$posts = responseData?.posts) !== null && _responseData$posts !== void 0 ? _responseData$posts : [], (_responseData$total_p = responseData?.total_posts) !== null && _responseData$total_p !== void 0 ? _responseData$total_p : 0);
    const loadMoreMarkup = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getLoadMoreMarkup)((_responseData$no_of_p = responseData?.no_of_pages) !== null && _responseData$no_of_p !== void 0 ? _responseData$no_of_p : 0, pageNo);
    setState({
      loading: false,
      resultCount: (_responseData$total_p2 = responseData?.total_posts) !== null && _responseData$total_p2 !== void 0 ? _responseData$total_p2 : 0,
      resultPosts: (_responseData$posts2 = responseData?.posts) !== null && _responseData$posts2 !== void 0 ? _responseData$posts2 : [],
      resultMarkup: resultMarkup + loadMoreMarkup || "",
      noOfPages: (_responseData$no_of_p2 = responseData?.no_of_pages) !== null && _responseData$no_of_p2 !== void 0 ? _responseData$no_of_p2 : 0
    });
  });
};

/**
 * Add Filter.
 *
 * @param {Object} currentSelection currentSelection
 */
const addFilter = (currentSelection = {}) => {
  const {
    filters,
    rootUrl,
    searchQuery
  } = getState();
  const {
    key,
    value
  } = currentSelection || {};

  // Get new filter values.
  let newFilters = {
    ...filters
  };
  const filterValues = filters[key] ? [...filters[key], value] : [value];
  newFilters = {
    ...newFilters,
    [key]: [...new Set(filterValues)]
  };

  // Add filter selections to URL and update URL.
  const url = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getUrlWithFilters)(newFilters, rootUrl);
  updateUrl(url);

  /**
   * Update state with the new data.
   * We set loading to true, before getting results.
   */
  setState({
    url,
    currentSelection,
    filters: newFilters,
    pageNo: 1,
    loading: true
  });

  // Get Result.
  getResult();
};

/**
 * Delete Filter.
 *
 * @param currentSelection
 */
const deleteFilter = (currentSelection = {}) => {
  const {
    filters,
    rootUrl
  } = getState();
  const {
    key,
    value
  } = currentSelection || {};
  let newFilters = {
    ...filters
  };
  let filterValues = filters[key] || [];

  // Loop through previous filter values and delete the value in question.
  filterValues.forEach((prevFilterValue, index) => {
    // If a match is found delete it from the array.
    if (prevFilterValue === value) {
      filterValues.splice(index, 1);
    }
  });
  newFilters = {
    ...newFilters,
    [key]: filterValues
  };

  // Delete empty keys.
  Object.keys(newFilters).forEach(key => {
    if (!newFilters[key] || !newFilters[key].length) {
      delete newFilters[key];
    }
  });

  // Add filter selections to URL and update URL.
  const url = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getUrlWithFilters)(newFilters, rootUrl);
  updateUrl(url);
  setState({
    url,
    currentSelection,
    filters: newFilters,
    pageNo: 1,
    loading: true
  });
  getResult();
};

/**
 * Update Url.
 *
 * @param {string} url Url.
 *
 * @return {null} Null.
 */
const updateUrl = url => {
  if (!url) {
    return null;
  }
  if (window.history.pushState) {
    window.history.pushState({
      path: url
    }, "", url);
  } else {
    window.location.href = url;
  }
};
const loadMorePosts = (nextPageNo = 1) => {
  const {
    restApiUrl,
    resultMarkup,
    filters
  } = getState();
  // Update page no in the fetch url.
  const fetchUrl = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getUrlWithFilters)({
    ...filters,
    page_no: nextPageNo
  }, restApiUrl);

  // Set State.
  setState({
    loadingMorePosts: true,
    pageNo: nextPageNo
  });

  // Fetch load more results.
  fetch(fetchUrl).then(response => response.json()).then(responseData => {
    var _responseData$posts3, _responseData$no_of_p3, _responseData$posts4;
    const moreResultMarkup = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getResultMarkup)((_responseData$posts3 = responseData?.posts) !== null && _responseData$posts3 !== void 0 ? _responseData$posts3 : []);
    const loadMoreMarkup = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getLoadMoreMarkup)((_responseData$no_of_p3 = responseData?.no_of_pages) !== null && _responseData$no_of_p3 !== void 0 ? _responseData$no_of_p3 : 0, nextPageNo);
    setState({
      loadingMorePosts: false,
      resultPosts: (_responseData$posts4 = responseData?.posts) !== null && _responseData$posts4 !== void 0 ? _responseData$posts4 : [],
      resultMarkup: resultMarkup + moreResultMarkup + loadMoreMarkup
    });
  });
};
const clearAllFilters = () => {
  const {
    rootUrl
  } = getState();
  setState({
    loading: true,
    filters: {},
    filterIds: [],
    currentSelection: {},
    pageNo: 1
  });
  updateUrl(rootUrl);
  getResult();
};

/**
 * Create store.
 */
const store = createStore(persist(() => ({
  ...DEFAULT_STATE,
  initialize,
  addFilter,
  deleteFilter,
  loadMorePosts,
  clearAllFilters
}), {
  name: _constants__WEBPACK_IMPORTED_MODULE_0__.STORE_NAME,
  partialize: state => {
    const persistentState = {};
    PERSISTENT_STATE_KEYS.forEach(key => {
      persistentState[key] = state[key];
    });
    return persistentState;
  }
}));
const {
  getState,
  setState
} = store;

// Add store to window.
stores[_constants__WEBPACK_IMPORTED_MODULE_0__.STORE_NAME] = store;

/***/ }),

/***/ "./resources/js/search-filter/helpers.js":
/*!***********************************************!*\
  !*** ./resources/js/search-filter/helpers.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   getFiltersFromUrl: () => (/* binding */ getFiltersFromUrl),
/* harmony export */   getLoadMoreMarkup: () => (/* binding */ getLoadMoreMarkup),
/* harmony export */   getResultMarkup: () => (/* binding */ getResultMarkup),
/* harmony export */   getUrlWithFilters: () => (/* binding */ getUrlWithFilters)
/* harmony export */ });
/* eslint-disable prettier/prettier */
/**
 * Get Filters From Url.
 *
 * @param {Object} url URl.
 * @param {Array} filterKeys Filter keys.
 *
 * @return {Object} data Data containing filters and pageNo.
 */
const getFiltersFromUrl = (url = {}, filterKeys = []) => {
  const data = {};
  if (!url || !filterKeys.length) {
    return data;
  }

  /**
   * Build filter's data.
   *
   * Loop through each filter keys( constant ) and if
   * they exist in the url, push them to the filters data.
   */
  filterKeys.forEach(filterKey => {
    const paramValue = url.searchParams.get(filterKey);

    // If the value does not exits, return.
    if (!paramValue) {
      return;
    }

    // Set page no.
    if ("pageNo" === filterKey) {
      data.pageNo = parseInt(paramValue);
      return;
    }

    // Get filter values.
    const filterValues = paramValue.split(",").map(itemValue => parseInt(itemValue));

    // Add paramValue to filters.
    data.filters = {
      ...data.filters,
      [filterKey]: filterValues
    };
  });
  return data;
};

/**
 * Get Url by Adding Filters.
 *
 * @param {Object} filters Filters.
 * @param {String} rootUrl Root url.
 */
const getUrlWithFilters = (filters = {} = {}, rootUrl = "") => {
  // Build URL.
  let url = new URL(rootUrl);

  // 2.Add the given keys value pairs in search params.
  Object.keys(filters).forEach(key => {
    url.searchParams.set(key, filters[key]);
  });

  // Covert url to string.
  url = url.toString();
  return url;
};

/**
 * Get Results markup.
 *
 * @param posts
 * @return {string}
 */
const getResultMarkup = (posts = []) => {
  if (!Array.isArray(posts) || !posts.length) {
    return "";
  }
  let img = "";
  let markup = ``;
  posts.forEach(post => {
    var _post$id, _post$permalink, _post$permalink2, _post$title, _post$title2, _post$content, _post$permalink3, _post$title3;
    img = post.thumbnail ? post.thumbnail : "https://via.placeholder.com/526x300";
    markup += `
		<section id="post-${(_post$id = post?.id) !== null && _post$id !== void 0 ? _post$id : 0}" class="col-lg-4 col-md-6 col-sm-12 pb-4">
			<header>
				<a href="${(_post$permalink = post?.permalink) !== null && _post$permalink !== void 0 ? _post$permalink : ""}" class="block">
				<figure class="img-container">
        <img src="${img}"/>
				</figure>
			</header>
			<div class="post-excerpt my-4">
				<a href="${(_post$permalink2 = post?.permalink) !== null && _post$permalink2 !== void 0 ? _post$permalink2 : ""}" title="${(_post$title = post?.title) !== null && _post$title !== void 0 ? _post$title : ""}">
					<h3 class="post-card-title">${(_post$title2 = post?.title) !== null && _post$title2 !== void 0 ? _post$title2 : ""}</h3>
				</a>
				<div class="mb-4 truncate-4">
					${(_post$content = post?.content) !== null && _post$content !== void 0 ? _post$content : ""}
				</div>
				<a href="${(_post$permalink3 = post?.permalink) !== null && _post$permalink3 !== void 0 ? _post$permalink3 : ""}"  class="btn btn-primary"  title="${(_post$title3 = post?.title) !== null && _post$title3 !== void 0 ? _post$title3 : ""}">
					View More
				</a>
			</div>
		</section>
		`;
  });
  return markup;
};
const getLoadMoreMarkup = (noOfPages = 0, currentPageNo = 1) => {
  if (parseInt(currentPageNo) >= parseInt(noOfPages)) {
    return "";
  }
  return `<jove-load-more
				class="load-more-wrap"
				next-page-no="${parseInt(currentPageNo) + 1}"
			>
				<button class="btn btn-primary">Load More</button>
			</jove-load-more>`;
};

/***/ }),

/***/ "./resources/js/search-filter/index.js":
/*!*********************************************!*\
  !*** ./resources/js/search-filter/index.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils */ "./resources/js/utils/index.js");
/* harmony import */ var _data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./data */ "./resources/js/search-filter/data.js");
/**
 * Global variables.
 */

const {
  customElements,
  HTMLElement
} = window;

/**
 * Initialize data store.
 */

const {
  getState,
  subscribe
} = _data__WEBPACK_IMPORTED_MODULE_1__.store;

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
    accordionHandle.addEventListener("click", event => {
      // Toggle the content.
      (0,_utils__WEBPACK_IMPORTED_MODULE_0__.toggleAccordionContent)(event, this, content);
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
    this.accordionHandle = this.querySelector(".checkbox-accordion__child-handle-icon");

    // Selects the input element within the accordion child.
    this.inputEl = this.querySelector("input");

    // Subscribe to state updates.
    subscribe(this.update.bind(this));

    // Add click event listener to toggle accordion content if handle and content are present.
    if (this.accordionHandle && this.content) {
      this.accordionHandle.addEventListener("click", event => (0,_utils__WEBPACK_IMPORTED_MODULE_0__.toggleAccordionContent)(event, this, this.content));
    }

    // Add click event listener to handle checkbox input click if input element is present.
    if (this.inputEl) {
      this.inputEl.addEventListener("click", event => this.handleCheckboxInputClick(event));
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
    const {
      filters
    } = currentState;
    const inputKey = this.inputEl.getAttribute("data-key");
    const inputValue = this.inputEl.getAttribute("value");
    const selectedFiltersForCurrentkey = filters[inputKey] || [];
    const parentEl = this.inputEl.closest(".checkbox-accordion") || {};
    const parentContentEl = this.inputEl.closest(".checkbox-accordion__child-content") || {};

    /**
     * If the current input value is amongst the selected filters, the check it.
     * and set the attributes and styles to open the accordion.
     *
     * @type {boolean}
     */
    const isChecked = selectedFiltersForCurrentkey.includes(parseInt(inputValue));

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
    const {
      addFilter,
      deleteFilter
    } = getState();
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
        value: parseInt(targetEl.value)
      });
    } else {
      deleteFilter({
        key: this.filterKey,
        value: parseInt(targetEl.value)
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
    const {
      resultMarkup,
      loading
    } = currentState;
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
    this.querySelector("button").addEventListener("click", () => this.handleLoadMoreButtonClick());
  }

  /**
   * Updates the component.
   *
   * Removes the "Load More" button if the next page number is not greater than the current page number.
   *
   * @param {Object} currentState Current state.
   */
  update(currentState = {}) {
    const {
      pageNo
    } = currentState;
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
    const {
      loadMorePosts
    } = getState();
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
    const {
      loadingMorePosts
    } = currentState;

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
    const {
      resultCount
    } = currentState;

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
    const {
      clearAllFilters
    } = getState();
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
customElements.define("jove-checkbox-accordion-child", JoveCheckboxAccordionChild);
customElements.define("jove-search", JoveSearch);
customElements.define("jove-results", JoveResults);
customElements.define("jove-load-more", JoveLoadMore);
customElements.define("jove-loading-more", JoveLoadingMore);
customElements.define("jove-results-count", JoveResultsCount);
customElements.define("jove-clear-all-filters", JoveClearAllFilters);

/***/ }),

/***/ "./resources/js/utils/index.js":
/*!*************************************!*\
  !*** ./resources/js/utils/index.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   slideElementDown: () => (/* binding */ slideElementDown),
/* harmony export */   slideElementUp: () => (/* binding */ slideElementUp),
/* harmony export */   toggleAccordionContent: () => (/* binding */ toggleAccordionContent)
/* harmony export */ });
/**
 * Toggle Accordion Content.
 *
 * @param {Event} event Event.
 * @param {Object} accordionEl Accordion Element
 * @param {Object} contentEl Content Element.
 *
 * @return {null} null
 */
const toggleAccordionContent = (event, accordionEl, contentEl) => {
  event.preventDefault();
  event.stopPropagation();
  if (!accordionEl || !contentEl) {
    return null;
  }
  accordionEl.toggleAttribute("active");
  if (!accordionEl.hasAttribute("active")) {
    slideElementUp(contentEl, 600);
  } else {
    slideElementDown(contentEl, 600);
  }
};

/**
 * Slide element down.
 *
 * @param {Object} element Target element.
 * @param {number} duration Animation duration.
 * @param {Function} callback Callback function.
 */
const slideElementDown = (element, duration = 300, callback = null) => {
  element.style.height = `${element.scrollHeight}px`;
  setTimeout(() => {
    element.style.height = "auto";
    if (callback) {
      callback();
    }
  }, duration);
};

/**
 * Slide element up.
 *
 * @param {Object} element Target element.
 * @param {number} duration Animation duration.
 * @param {Function} callback Callback function.
 */
const slideElementUp = (element, duration = 300, callback = null) => {
  element.style.height = `${element.scrollHeight}px`;
  element.offsetHeight; // eslint-disable-line
  element.style.height = "0px";
  setTimeout(() => {
    element.style.height = null;
    if (callback) {
      callback();
    }
  }, duration);
};

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!********************************!*\
  !*** ./resources/js/search.js ***!
  \********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _search_filter__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./search-filter */ "./resources/js/search-filter/index.js");
/**
 * Primary editor script. Imports all of the various features so that they can
 * be bundled into a final file during the build process.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2023-2024, Justin Tadlock
 * @license   GPL-3.0-or-later
 */

// Import all the cool editor features from the theme.

})();

/******/ })()
;
//# sourceMappingURL=search.js.map