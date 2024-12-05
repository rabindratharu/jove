/**
 * External dependencies.
 */
import { createStore } from "zustand/vanilla";
import { persist } from "zustand/middleware";

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
 * Create store with persistence.
 */
export const store = createStore(
  persist(
    (set, get) => ({
      ...DEFAULT_STATE,
      initialize: (settings = {}) => {
        const stateFromUrl = getStateFromUrl(settings?.root_url ?? {});
        setStateFromUrl(settings, stateFromUrl);
        getResult();
      },
      addFilter: (currentSelection = {}) => {
        const { filters, rootUrl } = get();
        const { key, value } = currentSelection;

        let newFilters = { ...filters };
        const filterValues = filters[key] ? [...filters[key], value] : [value];
        newFilters = {
          ...newFilters,
          [key]: [...new Set(filterValues)],
        };

        const url = getUrlWithFilters(newFilters, rootUrl);
        updateUrl(url);

        set({
          url,
          currentSelection,
          filters: newFilters,
          pageNo: 1,
          loading: true,
        });

        getResult();
      },
      // Other functions (deleteFilter, loadMorePosts, clearAllFilters, etc.) can be added here.
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

// Add store to the global stores object.
window.stores = window.stores || {};
window.stores[STORE_NAME] = store;
