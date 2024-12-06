/**
 * External dependencies.
 */
const { persist, createStore, stores } = window.zustand;

/**
 * Internal dependencies.
 */
import { STORE_NAME } from "./constants";
import { getFiltersFromUrl, getUrlWithFilters } from "./helpers";

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
 * @param {Object} settings settings.
 */
const initialize = (settings = {}) => {
  const stateFromUrl = getStateFromUrl(settings?.root_url ?? {});
  setStateFromUrl(settings || {}, stateFromUrl || {});
  //getResult();
};

/**
 * Set State From Url.
 *
 * @param {Object} settings Initial Settings.
 * @param {Object} stateFromUrl State From Url.
 */
const setStateFromUrl = (settings = {}, stateFromUrl = {}) => {
  // Set data to state.
  setState({
    rootUrl: settings?.root_url ?? "",
    restApiUrl: settings?.rest_api_url ?? "",
    filterIds: settings?.filter_ids ?? {},
    loading: true,
    ...stateFromUrl,
  });

  // Action: Get result with data from state.
  //getResult();
};

/**
 * Get State From Url.
 *
 * @param {String} rootUrl Root Url.
 *
 * @return {Object} data Data containing filters, page no, and url.
 */
const getStateFromUrl = (rootUrl = "") => {
  const { filterKeys } = getState();
  const url = new URL(window.location.href);
  let data = {};

  // Build data from URL.
  // Add filters and page no to data.
  data = getFiltersFromUrl(url, filterKeys);

  // Get url with filter selection.
  data.url = getUrlWithFilters(data?.filters ?? {}, rootUrl);

  return data;
};

/**
 * Create store.
 */
export const store = createStore(
  persist(
    () => ({
      ...DEFAULT_STATE,
      initialize,
    }),
    {
      name: STORE_NAME,
      partialize: (state) => {
        const persistentState = {};
        PERSISTENT_STATE_KEYS.forEach((key) => {
          persistentState[key] = state[key];
        });
        return persistentState;
      },
    }
  )
);
const { getState, setState } = store;

// Add store to window.
stores[STORE_NAME] = store;
