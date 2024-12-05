/**
 * External dependencies.
 */
import {
  getFiltersFromUrl,
  getLoadMoreMarkup,
  getResultMarkup,
  getUrlWithFilters,
} from "./helpers";

const { persist, create, stores } = window.zustand;

/**
 * Internal dependencies.
 */
import { STORE_NAME } from "./constants";

/**
 * Constants.
 */
export const DEFAULT_STATE = {
  restApiUrl: "",
  rootUrl: "",
  url: "",
  filterKeys: ["category", "post_tag"],
  filters: {},
  filterIds: [],
  pageNo: 1,
  resultCount: null,
  noOfPages: 0,
  resultMarkup: "",
  loading: false,
};
const PERSISTENT_STATE_KEYS = [];

/**
 * Initialize.
 *
 * @param {Object} settings Application settings.
 */
const initialize = (settings = {}) => {
  const stateFromUrl = getStateFromUrl(settings?.root_url ?? "");
  setStateFromUrl(settings, stateFromUrl);
};

/**
 * Get State From URL.
 *
 * @param {string} rootUrl Root URL.
 * @return {Object} State data extracted from URL.
 */
const getStateFromUrl = (rootUrl = "") => {
  const { filterKeys } = getState();
  const url = new URL(window.location.href);
  const filtersData = getFiltersFromUrl(url, filterKeys);

  return {
    ...filtersData,
    url: getUrlWithFilters(filtersData.filters || {}, rootUrl),
  };
};

/**
 * Set State From URL.
 *
 * @param {Object} settings Application settings.
 * @param {Object} stateFromUrl State data from URL.
 */
const setStateFromUrl = (settings = {}, stateFromUrl = {}) => {
  setState({
    rootUrl: settings?.root_url ?? "",
    restApiUrl: settings?.rest_api_url ?? "",
    filterIds: settings?.filter_ids ?? [],
    loading: true,
    ...stateFromUrl,
  });
  getResult();
};

/**
 * Get results from the server.
 */
const getResult = () => {
  const { restApiUrl, filters, pageNo } = getState();

  if (!restApiUrl) return;

  const params = { ...filters, page_no: pageNo };
  const fetchUrl = `${restApiUrl}?${new URLSearchParams(params)}`;

  fetch(fetchUrl)
    .then((response) => response.json())
    .then((responseData) => {
      const resultMarkup = getResultMarkup(
        responseData.posts || [],
        responseData.total_posts || 0
      );
      const loadMoreMarkup = getLoadMoreMarkup(
        responseData.no_of_pages || 0,
        pageNo
      );

      setState({
        loading: false,
        resultCount: responseData.total_posts || 0,
        resultPosts: responseData.posts || [],
        resultMarkup: resultMarkup + loadMoreMarkup,
        noOfPages: responseData.no_of_pages || 0,
      });
    });
};

/**
 * Add a filter.
 *
 * @param {Object} currentSelection The selected filter to add.
 */
const addFilter = (currentSelection = {}) => {
  const { filters, rootUrl } = getState();
  const { key, value } = currentSelection;

  if (!key || value === undefined) return;

  const updatedFilters = {
    ...filters,
    [key]: Array.from(new Set([...(filters[key] || []), value])),
  };

  const url = getUrlWithFilters(updatedFilters, rootUrl);
  updateUrl(url);

  setState({
    url,
    filters: updatedFilters,
    pageNo: 1,
    loading: true,
  });

  getResult();
};

/**
 * Delete a filter.
 *
 * @param {Object} currentSelection The selected filter to delete.
 */
const deleteFilter = (currentSelection = {}) => {
  const { filters, rootUrl } = getState();
  const { key, value } = currentSelection;

  if (!key || value === undefined) return;

  const updatedFilters = {
    ...filters,
    [key]: (filters[key] || []).filter((v) => v !== value),
  };

  Object.keys(updatedFilters).forEach((filterKey) => {
    if (!updatedFilters[filterKey].length) delete updatedFilters[filterKey];
  });

  const url = getUrlWithFilters(updatedFilters, rootUrl);
  updateUrl(url);

  setState({
    url,
    filters: updatedFilters,
    pageNo: 1,
    loading: true,
  });

  getResult();
};

/**
 * Update the browser's URL.
 *
 * @param {string} url The new URL to set.
 */
const updateUrl = (url) => {
  if (!url) return;

  if (window.history.pushState) {
    window.history.pushState({ path: url }, "", url);
  } else {
    window.location.href = url;
  }
};

/**
 * Load more posts.
 *
 * @param {number} nextPageNo The next page number to load.
 */
const loadMorePosts = (nextPageNo = 1) => {
  const { restApiUrl, resultMarkup, filters } = getState();
  const fetchUrl = getUrlWithFilters(
    { ...filters, page_no: nextPageNo },
    restApiUrl
  );

  setState({
    loadingMorePosts: true,
    pageNo: nextPageNo,
  });

  fetch(fetchUrl)
    .then((response) => response.json())
    .then((responseData) => {
      const moreResultMarkup = getResultMarkup(responseData.posts || []);
      const loadMoreMarkup = getLoadMoreMarkup(
        responseData.no_of_pages || 0,
        nextPageNo
      );

      setState({
        loadingMorePosts: false,
        resultMarkup: resultMarkup + moreResultMarkup + loadMoreMarkup,
      });
    });
};

/**
 * Clear all filters.
 */
const clearAllFilters = () => {
  const { rootUrl } = getState();

  setState({
    filters: {},
    filterIds: [],
    pageNo: 1,
    loading: true,
  });

  updateUrl(rootUrl);
  getResult();
};

/**
 * Create and export the store.
 */
export const store = create(
  persist(
    (set, get) => ({
      ...DEFAULT_STATE,
      initialize,
      addFilter,
      deleteFilter,
      loadMorePosts,
      clearAllFilters,
    }),
    {
      name: STORE_NAME,
      partialize: (state) => {
        return PERSISTENT_STATE_KEYS.reduce((acc, key) => {
          acc[key] = state[key];
          return acc;
        }, {});
      },
    }
  )
);

const { getState, setState } = store;

// Add the store to the global `stores` object.
stores[STORE_NAME] = store;
