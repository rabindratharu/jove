/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/search-filter/constants.js":
/*!*************************************************!*\
  !*** ./resources/js/search-filter/constants.js ***!
  \*************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   STORE_NAME: function() { return /* binding */ STORE_NAME; }
/* harmony export */ });
/**
 * Constants.
 */

var STORE_NAME = "jove_search";

/***/ }),

/***/ "./resources/js/search-filter/data.js":
/*!********************************************!*\
  !*** ./resources/js/search-filter/data.js ***!
  \********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   DEFAULT_STATE: function() { return /* binding */ DEFAULT_STATE; },
/* harmony export */   store: function() { return /* binding */ store; }
/* harmony export */ });
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./constants */ "./resources/js/search-filter/constants.js");
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./helpers */ "./resources/js/search-filter/helpers.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
/**
 * External dependencies.
 */
var _window$zustand = window.zustand,
  persist = _window$zustand.persist,
  createStore = _window$zustand.createStore,
  stores = _window$zustand.stores;

/**
 * Internal dependencies.
 */



/**
 * Constants.
 */
var DEFAULT_STATE = {
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
var PERSISTENT_STATE_KEYS = [];

/**
 * Initialize.
 *
 * @param {Object} settings settings.
 */
var initialize = function initialize() {
  var _settings$root_url;
  var settings = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var stateFromUrl = getStateFromUrl((_settings$root_url = settings === null || settings === void 0 ? void 0 : settings.root_url) !== null && _settings$root_url !== void 0 ? _settings$root_url : {});
  setStateFromUrl(settings || {}, stateFromUrl || {});
  getResult();
};

/**
 * Set State From Url.
 *
 * @param {Object} settings Initial Settings.
 * @param {Object} stateFromUrl State From Url.
 */
var setStateFromUrl = function setStateFromUrl() {
  var _settings$root_url2, _settings$rest_api_ur, _settings$filter_ids;
  var settings = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var stateFromUrl = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
  // Set data to state.
  setState(_objectSpread({
    rootUrl: (_settings$root_url2 = settings === null || settings === void 0 ? void 0 : settings.root_url) !== null && _settings$root_url2 !== void 0 ? _settings$root_url2 : "",
    restApiUrl: (_settings$rest_api_ur = settings === null || settings === void 0 ? void 0 : settings.rest_api_url) !== null && _settings$rest_api_ur !== void 0 ? _settings$rest_api_ur : "",
    filterIds: (_settings$filter_ids = settings === null || settings === void 0 ? void 0 : settings.filter_ids) !== null && _settings$filter_ids !== void 0 ? _settings$filter_ids : {},
    loading: true
  }, stateFromUrl));

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
var getStateFromUrl = function getStateFromUrl() {
  var _data$filters, _data;
  var rootUrl = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
  var _getState = getState(),
    filterKeys = _getState.filterKeys;
  var url = new URL(window.location.href);
  var data = {};

  // Build data from URL.
  // Add filters and page no to data.
  data = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getFiltersFromUrl)(url, filterKeys);

  // Add search query from the URL
  if (url.searchParams.has("s")) {
    data.searchQuery = url.searchParams.get("s");
  }

  // Get url with filter selection.
  data.url = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getUrlWithFilters)((_data$filters = (_data = data) === null || _data === void 0 ? void 0 : _data.filters) !== null && _data$filters !== void 0 ? _data$filters : {}, rootUrl);
  return data;
};

/**
 * Get Result.
 */
var getResult = function getResult() {
  var _getState2 = getState(),
    restApiUrl = _getState2.restApiUrl,
    filters = _getState2.filters,
    pageNo = _getState2.pageNo,
    searchQuery = _getState2.searchQuery;
  if (!restApiUrl) {
    return;
  }

  // Add query-params to rest api url.
  var params = _objectSpread(_objectSpread({
    s: [searchQuery]
  }, filters), {}, {
    page_no: pageNo
  });
  var fetchUrl = restApiUrl + "?" + new URLSearchParams(params).toString();
  fetch(fetchUrl).then(function (response) {
    return response.json();
  }).then(function (responseData) {
    var _responseData$posts, _responseData$total_p, _responseData$no_of_p, _responseData$total_p2, _responseData$posts2, _responseData$no_of_p2;
    var resultMarkup = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getResultMarkup)((_responseData$posts = responseData === null || responseData === void 0 ? void 0 : responseData.posts) !== null && _responseData$posts !== void 0 ? _responseData$posts : [], (_responseData$total_p = responseData === null || responseData === void 0 ? void 0 : responseData.total_posts) !== null && _responseData$total_p !== void 0 ? _responseData$total_p : 0);
    var loadMoreMarkup = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getLoadMoreMarkup)((_responseData$no_of_p = responseData === null || responseData === void 0 ? void 0 : responseData.no_of_pages) !== null && _responseData$no_of_p !== void 0 ? _responseData$no_of_p : 0, pageNo);
    setState({
      loading: false,
      resultCount: (_responseData$total_p2 = responseData === null || responseData === void 0 ? void 0 : responseData.total_posts) !== null && _responseData$total_p2 !== void 0 ? _responseData$total_p2 : 0,
      resultPosts: (_responseData$posts2 = responseData === null || responseData === void 0 ? void 0 : responseData.posts) !== null && _responseData$posts2 !== void 0 ? _responseData$posts2 : [],
      resultMarkup: resultMarkup + loadMoreMarkup || "",
      noOfPages: (_responseData$no_of_p2 = responseData === null || responseData === void 0 ? void 0 : responseData.no_of_pages) !== null && _responseData$no_of_p2 !== void 0 ? _responseData$no_of_p2 : 0
    });
  });
};

/**
 * Add Filter.
 *
 * @param {Object} currentSelection currentSelection
 */
var addFilter = function addFilter() {
  var currentSelection = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var _getState3 = getState(),
    filters = _getState3.filters,
    rootUrl = _getState3.rootUrl,
    searchQuery = _getState3.searchQuery;
  var _ref = currentSelection || {},
    key = _ref.key,
    value = _ref.value;

  // Get new filter values.
  var newFilters = _objectSpread({}, filters);
  var filterValues = filters[key] ? [].concat(_toConsumableArray(filters[key]), [value]) : [value];
  newFilters = _objectSpread(_objectSpread({}, newFilters), {}, _defineProperty({}, key, _toConsumableArray(new Set(filterValues))));

  // Add filter selections to URL and update URL.
  var url = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getUrlWithFilters)(newFilters, rootUrl);
  updateUrl(url);

  /**
   * Update state with the new data.
   * We set loading to true, before getting results.
   */
  setState({
    url: url,
    currentSelection: currentSelection,
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
var deleteFilter = function deleteFilter() {
  var currentSelection = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var _getState4 = getState(),
    filters = _getState4.filters,
    rootUrl = _getState4.rootUrl;
  var _ref2 = currentSelection || {},
    key = _ref2.key,
    value = _ref2.value;
  var newFilters = _objectSpread({}, filters);
  var filterValues = filters[key] || [];

  // Loop through previous filter values and delete the value in question.
  filterValues.forEach(function (prevFilterValue, index) {
    // If a match is found delete it from the array.
    if (prevFilterValue === value) {
      filterValues.splice(index, 1);
    }
  });
  newFilters = _objectSpread(_objectSpread({}, newFilters), {}, _defineProperty({}, key, filterValues));

  // Delete empty keys.
  Object.keys(newFilters).forEach(function (key) {
    if (!newFilters[key] || !newFilters[key].length) {
      delete newFilters[key];
    }
  });

  // Add filter selections to URL and update URL.
  var url = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getUrlWithFilters)(newFilters, rootUrl);
  updateUrl(url);
  setState({
    url: url,
    currentSelection: currentSelection,
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
var updateUrl = function updateUrl(url) {
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
var loadMorePosts = function loadMorePosts() {
  var nextPageNo = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
  var _getState5 = getState(),
    restApiUrl = _getState5.restApiUrl,
    resultMarkup = _getState5.resultMarkup,
    filters = _getState5.filters;
  // Update page no in the fetch url.
  var fetchUrl = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getUrlWithFilters)(_objectSpread(_objectSpread({}, filters), {}, {
    page_no: nextPageNo
  }), restApiUrl);

  // Set State.
  setState({
    loadingMorePosts: true,
    pageNo: nextPageNo
  });

  // Fetch load more results.
  fetch(fetchUrl).then(function (response) {
    return response.json();
  }).then(function (responseData) {
    var _responseData$posts3, _responseData$no_of_p3, _responseData$posts4;
    var moreResultMarkup = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getResultMarkup)((_responseData$posts3 = responseData === null || responseData === void 0 ? void 0 : responseData.posts) !== null && _responseData$posts3 !== void 0 ? _responseData$posts3 : []);
    var loadMoreMarkup = (0,_helpers__WEBPACK_IMPORTED_MODULE_1__.getLoadMoreMarkup)((_responseData$no_of_p3 = responseData === null || responseData === void 0 ? void 0 : responseData.no_of_pages) !== null && _responseData$no_of_p3 !== void 0 ? _responseData$no_of_p3 : 0, nextPageNo);
    setState({
      loadingMorePosts: false,
      resultPosts: (_responseData$posts4 = responseData === null || responseData === void 0 ? void 0 : responseData.posts) !== null && _responseData$posts4 !== void 0 ? _responseData$posts4 : [],
      resultMarkup: resultMarkup + moreResultMarkup + loadMoreMarkup
    });
  });
};
var clearAllFilters = function clearAllFilters() {
  var _getState6 = getState(),
    rootUrl = _getState6.rootUrl;
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
var store = createStore(persist(function () {
  return _objectSpread(_objectSpread({}, DEFAULT_STATE), {}, {
    initialize: initialize,
    addFilter: addFilter,
    deleteFilter: deleteFilter,
    loadMorePosts: loadMorePosts,
    clearAllFilters: clearAllFilters
  });
}, {
  name: _constants__WEBPACK_IMPORTED_MODULE_0__.STORE_NAME,
  partialize: function partialize(state) {
    var persistentState = {};
    PERSISTENT_STATE_KEYS.forEach(function (key) {
      persistentState[key] = state[key];
    });
    return persistentState;
  }
}));
var getState = store.getState,
  setState = store.setState;

// Add store to window.
stores[_constants__WEBPACK_IMPORTED_MODULE_0__.STORE_NAME] = store;

/***/ }),

/***/ "./resources/js/search-filter/helpers.js":
/*!***********************************************!*\
  !*** ./resources/js/search-filter/helpers.js ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   getFiltersFromUrl: function() { return /* binding */ getFiltersFromUrl; },
/* harmony export */   getLoadMoreMarkup: function() { return /* binding */ getLoadMoreMarkup; },
/* harmony export */   getResultMarkup: function() { return /* binding */ getResultMarkup; },
/* harmony export */   getUrlWithFilters: function() { return /* binding */ getUrlWithFilters; }
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _objectDestructuringEmpty(t) { if (null == t) throw new TypeError("Cannot destructure " + t); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
/* eslint-disable prettier/prettier */
/**
 * Get Filters From Url.
 *
 * @param {Object} url URl.
 * @param {Array} filterKeys Filter keys.
 *
 * @return {Object} data Data containing filters and pageNo.
 */
var getFiltersFromUrl = function getFiltersFromUrl() {
  var url = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var filterKeys = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];
  var data = {};
  if (!url || !filterKeys.length) {
    return data;
  }

  /**
   * Build filter's data.
   *
   * Loop through each filter keys( constant ) and if
   * they exist in the url, push them to the filters data.
   */
  filterKeys.forEach(function (filterKey) {
    var paramValue = url.searchParams.get(filterKey);

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
    var filterValues = paramValue.split(",").map(function (itemValue) {
      return parseInt(itemValue);
    });

    // Add paramValue to filters.
    data.filters = _objectSpread(_objectSpread({}, data.filters), {}, _defineProperty({}, filterKey, filterValues));
  });
  return data;
};

/**
 * Get Url by Adding Filters.
 *
 * @param {Object} filters Filters.
 * @param {String} rootUrl Root url.
 */
var getUrlWithFilters = function getUrlWithFilters() {
  var _ref;
  var filters = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : (_ref = {}, _objectDestructuringEmpty(_ref), _ref);
  var rootUrl = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "";
  // Build URL.
  var url = new URL(rootUrl);

  // 2.Add the given keys value pairs in search params.
  Object.keys(filters).forEach(function (key) {
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
var getResultMarkup = function getResultMarkup() {
  var posts = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
  if (!Array.isArray(posts) || !posts.length) {
    return "";
  }
  var markup = "";
  posts.forEach(function (post) {
    var _post$id, _post$permalink, _post$title, _post$title2, _post$date, _post$journal;
    console.log("🚀 ~ file: helpers.js:87 ~ posts.forEach ~ post:", post);
    markup += "\n\t\t<article id=\"video-".concat((_post$id = post === null || post === void 0 ? void 0 : post.id) !== null && _post$id !== void 0 ? _post$id : 0, "\" class=\"jove-search-video\">\n\t\t\t<h2 class=\"jove-search-video-title\">\n\t\t\t\t<a href=\"").concat((_post$permalink = post === null || post === void 0 ? void 0 : post.permalink) !== null && _post$permalink !== void 0 ? _post$permalink : "", "\" title=\"").concat((_post$title = post === null || post === void 0 ? void 0 : post.title) !== null && _post$title !== void 0 ? _post$title : "", "\">\n\t\t\t\t\t").concat((_post$title2 = post === null || post === void 0 ? void 0 : post.title) !== null && _post$title2 !== void 0 ? _post$title2 : "", "\n\t\t\t\t</a>\n\t\t\t</h2>\n\t\t\t<div class=\"jove-search-video-authors-affiliations\">\n\t\t\t\t<div class=\"jove-search-video-authors\">\n\t\t\t\t\tAlexander Karamyshev<sub>1</sub>, Andrey L. Karamyshev<sub>1</sub> , Ivan Topisirovic<sub>2</sub>, Kristina Sikstr\xF6m<sub>2</sub>, Tyson E Graber<sub>2</sub>\n\t\t\t\t</div>\n\t\t\t\t<div class=\"jove-search-video-affiliations\">\n\t\t\t\t\t<sub>1</sub>Texas Tech University , <sub>2</sub>Texas Tech University Health Sciences Center\n\t\t\t\t</div>\n\t\t\t</div>\n\t\t\t<div class=\"jove-search-video-meta\">\n\t\t\t\t<div class=\"jove-search-video-date\"><span>Published on:</span>").concat((_post$date = post === null || post === void 0 ? void 0 : post.date) !== null && _post$date !== void 0 ? _post$date : "", "</div>\n\t\t\t\t<div class=\"jove-search-video-journal\"><span>Journal:</span>").concat((_post$journal = post === null || post === void 0 ? void 0 : post.journal) !== null && _post$journal !== void 0 ? _post$journal : "", "</div>\n\t\t\t</div>\n\t\t</article>\n\t\t");
  });
  return markup;
};
var getLoadMoreMarkup = function getLoadMoreMarkup() {
  var noOfPages = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
  var currentPageNo = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
  if (parseInt(currentPageNo) >= parseInt(noOfPages)) {
    return "";
  }
  return "<jove-load-more\n\t\t\t\tclass=\"load-more-wrap\"\n\t\t\t\tnext-page-no=\"".concat(parseInt(currentPageNo) + 1, "\"\n\t\t\t>\n\t\t\t\t<button class=\"btn btn-primary\">Load More</button>\n\t\t\t</jove-load-more>");
};

/***/ }),

/***/ "./resources/js/search-filter/index.js":
/*!*********************************************!*\
  !*** ./resources/js/search-filter/index.js ***!
  \*********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils */ "./resources/js/utils/index.js");
/* harmony import */ var _data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./data */ "./resources/js/search-filter/data.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _callSuper(t, o, e) { return o = _getPrototypeOf(o), _possibleConstructorReturn(t, _isNativeReflectConstruct() ? Reflect.construct(o, e || [], _getPrototypeOf(t).constructor) : o.apply(t, e)); }
function _possibleConstructorReturn(t, e) { if (e && ("object" == _typeof(e) || "function" == typeof e)) return e; if (void 0 !== e) throw new TypeError("Derived constructors may only return object or undefined"); return _assertThisInitialized(t); }
function _assertThisInitialized(e) { if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); return e; }
function _isNativeReflectConstruct() { try { var t = !Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); } catch (t) {} return (_isNativeReflectConstruct = function _isNativeReflectConstruct() { return !!t; })(); }
function _getPrototypeOf(t) { return _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function (t) { return t.__proto__ || Object.getPrototypeOf(t); }, _getPrototypeOf(t); }
function _inherits(t, e) { if ("function" != typeof e && null !== e) throw new TypeError("Super expression must either be null or a function"); t.prototype = Object.create(e && e.prototype, { constructor: { value: t, writable: !0, configurable: !0 } }), Object.defineProperty(t, "prototype", { writable: !1 }), e && _setPrototypeOf(t, e); }
function _setPrototypeOf(t, e) { return _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function (t, e) { return t.__proto__ = e, t; }, _setPrototypeOf(t, e); }
/**
 * Global variables.
 */

var _window = window,
  customElements = _window.customElements,
  HTMLElement = _window.HTMLElement;

/**
 * Initialize data store.
 */

var getState = _data__WEBPACK_IMPORTED_MODULE_1__.store.getState,
  subscribe = _data__WEBPACK_IMPORTED_MODULE_1__.store.subscribe;

/**
 * JoveSearch Class.
 */
var JoveSearch = /*#__PURE__*/function (_HTMLElement) {
  /**
   * Constructor.
   *
   * This method is called when the component is created.
   * It initializes the component by setting the elements,
   * adding event listeners and initializing the state.
   */
  function JoveSearch() {
    var _this;
    _classCallCheck(this, JoveSearch);
    _this = _callSuper(this, JoveSearch);

    // Initialize State.
    var state = getState();
    state.initialize(search_settings);
    return _this;
  }
  _inherits(JoveSearch, _HTMLElement);
  return _createClass(JoveSearch);
}(HTMLElement);
/**
 * JoveCheckboxAccordion Class.
 */
var JoveCheckboxAccordion = /*#__PURE__*/function (_HTMLElement2) {
  /**
   * Constructor.
   *
   * This method is called when the component is created.
   * It sets up the component by setting the elements and
   * adding an event listener to the handle.
   */
  function JoveCheckboxAccordion() {
    var _this2;
    _classCallCheck(this, JoveCheckboxAccordion);
    _this2 = _callSuper(this, JoveCheckboxAccordion);

    // Elements.
    var filterKey = _this2.getAttribute("key");
    var content = _this2.querySelector(".checkbox-accordion__content");
    var accordionHandle = _this2.querySelector(".checkbox-accordion__handle");
    if (!accordionHandle || !content || !filterKey) {
      return _possibleConstructorReturn(_this2);
    }

    // Add an event listener to the handle.
    accordionHandle.addEventListener("click", function (event) {
      // Toggle the content.
      (0,_utils__WEBPACK_IMPORTED_MODULE_0__.toggleAccordionContent)(event, _this2, content);
    });
    return _this2;
  }

  /**
   * Observe Attributes.
   *
   * This property is part of the Web Components API and is
   * used to observe attributes changes on the component.
   *
   * @return {string[]} Attributes to be observed.
   */
  _inherits(JoveCheckboxAccordion, _HTMLElement2);
  return _createClass(JoveCheckboxAccordion, [{
    key: "attributeChangedCallback",
    value:
    /**
     * Attributes callback.
     *
     * Fired on attribute change.
     *
     * @param {string} name Attribute Name.
     * @param {string} oldValue Attribute's Old Value.
     * @param {string} newValue Attribute's New Value.
     */
    function attributeChangedCallback(name, oldValue, newValue) {
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
  }], [{
    key: "observedAttributes",
    get: function get() {
      /**
       * The only attribute we care about is the "active" attribute.
       * This attribute is used to determine the state of the component.
       * If the attribute is set to "true", then the component is active
       * and the content is visible. If the attribute is set to "false",
       * then the component is not active and the content is hidden.
       */
      return ["active"];
    }
  }]);
}(HTMLElement);
/**
 * JoveCheckboxAccordionChild Class.
 */
var JoveCheckboxAccordionChild = /*#__PURE__*/function (_HTMLElement3) {
  /**
   * Constructor for JoveCheckboxAccordionChild.
   *
   * Initializes the component, sets up event listeners, and subscribes to state updates.
   */
  function JoveCheckboxAccordionChild() {
    var _this3;
    _classCallCheck(this, JoveCheckboxAccordionChild);
    _this3 = _callSuper(this, JoveCheckboxAccordionChild);

    // Selects the content element within the accordion child.
    _this3.content = _this3.querySelector(".checkbox-accordion__child-content");

    // Selects the accordion handle icon element.
    _this3.accordionHandle = _this3.querySelector(".checkbox-accordion__child-handle-icon");

    // Selects the input element within the accordion child.
    _this3.inputEl = _this3.querySelector("input");

    // Subscribe to state updates.
    subscribe(_this3.update.bind(_this3));

    // Add click event listener to toggle accordion content if handle and content are present.
    if (_this3.accordionHandle && _this3.content) {
      _this3.accordionHandle.addEventListener("click", function (event) {
        return (0,_utils__WEBPACK_IMPORTED_MODULE_0__.toggleAccordionContent)(event, _this3, _this3.content);
      });
    }

    // Add click event listener to handle checkbox input click if input element is present.
    if (_this3.inputEl) {
      _this3.inputEl.addEventListener("click", function (event) {
        return _this3.handleCheckboxInputClick(event);
      });
    }
    return _this3;
  }

  /**
   * Update the component.
   *
   * @param {Object} currentState Current state.
   *
   * @return {void}
   */
  _inherits(JoveCheckboxAccordionChild, _HTMLElement3);
  return _createClass(JoveCheckboxAccordionChild, [{
    key: "update",
    value: function update() {
      var currentState = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      if (!this.inputEl) {
        return;
      }
      var filters = currentState.filters;
      var inputKey = this.inputEl.getAttribute("data-key");
      var inputValue = this.inputEl.getAttribute("value");
      var selectedFiltersForCurrentkey = filters[inputKey] || [];
      var parentEl = this.inputEl.closest(".checkbox-accordion") || {};
      var parentContentEl = this.inputEl.closest(".checkbox-accordion__child-content") || {};

      /**
       * If the current input value is amongst the selected filters, the check it.
       * and set the attributes and styles to open the accordion.
       *
       * @type {boolean}
       */
      var isChecked = selectedFiltersForCurrentkey.includes(parseInt(inputValue));

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
  }, {
    key: "handleCheckboxInputClick",
    value: function handleCheckboxInputClick(event) {
      var _getState = getState(),
        addFilter = _getState.addFilter,
        deleteFilter = _getState.deleteFilter;
      var targetEl = event.target;
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
  }]);
}(HTMLElement);
/**
 * JoveResults Class.
 */
var JoveResults = /*#__PURE__*/function (_HTMLElement4) {
  /**
   * Constructor.
   *
   * This method is called when an instance of the component is created. It sets up the component by
   * subscribing to updates.
   */
  function JoveResults() {
    var _this4;
    _classCallCheck(this, JoveResults);
    _this4 = _callSuper(this, JoveResults);

    // Subscribe to updates.
    // This method listens for changes in the state and calls the `update` method when the state changes.
    subscribe(_this4.update.bind(_this4));
    return _this4;
  }

  /**
   * Update the component.
   *
   * @param {Object} currentState Current state.
   */
  _inherits(JoveResults, _HTMLElement4);
  return _createClass(JoveResults, [{
    key: "update",
    value: function update() {
      var currentState = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var resultMarkup = currentState.resultMarkup,
        loading = currentState.loading;
      this.innerHTML = resultMarkup || (loading ? "<p>Loading...</p>" : "");
    }
  }]);
}(HTMLElement);
/**
 * JoveLoadMore Class.
 */
var JoveLoadMore = /*#__PURE__*/function (_HTMLElement5) {
  /**
   * Constructor.
   *
   * Initializes the component and subscribes to state updates.
   */
  function JoveLoadMore() {
    var _this5;
    _classCallCheck(this, JoveLoadMore);
    _this5 = _callSuper(this, JoveLoadMore);

    // Subscribe to updates.
    subscribe(_this5.update.bind(_this5));

    // Get the next page number from the attribute.
    _this5.nextPageNo = _this5.getAttribute("next-page-no");

    // Add event listener to the button.
    _this5.querySelector("button").addEventListener("click", function () {
      return _this5.handleLoadMoreButtonClick();
    });
    return _this5;
  }

  /**
   * Updates the component.
   *
   * Removes the "Load More" button if the next page number is not greater than the current page number.
   *
   * @param {Object} currentState Current state.
   */
  _inherits(JoveLoadMore, _HTMLElement5);
  return _createClass(JoveLoadMore, [{
    key: "update",
    value: function update() {
      var currentState = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var pageNo = currentState.pageNo;
      if (parseInt(this.nextPageNo) <= parseInt(pageNo)) {
        this.remove();
      }
    }

    /**
     * Handles the load more button click.
     *
     * Calls the `loadMorePosts` function with the next page number.
     */
  }, {
    key: "handleLoadMoreButtonClick",
    value: function handleLoadMoreButtonClick() {
      var _getState2 = getState(),
        loadMorePosts = _getState2.loadMorePosts;
      loadMorePosts(this.nextPageNo);
    }
  }]);
}(HTMLElement);
var JoveLoadingMore = /*#__PURE__*/function (_HTMLElement6) {
  /**
   * Constructor.
   *
   * Initializes the component and subscribes to state updates.
   */
  function JoveLoadingMore() {
    var _this6;
    _classCallCheck(this, JoveLoadingMore);
    _this6 = _callSuper(this, JoveLoadingMore);

    // Subscribe to updates.
    // This method listens for changes in the state and calls the `update` method when the state changes.
    subscribe(_this6.update.bind(_this6));
    return _this6;
  }

  /**
   * Update the component.
   *
   * @param {Object} currentState Current state.
   *
   * This method is called when the state changes. It updates the component text depending on whether
   * the component is loading more posts or not.
   */
  _inherits(JoveLoadingMore, _HTMLElement6);
  return _createClass(JoveLoadingMore, [{
    key: "update",
    value: function update() {
      var currentState = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var loadingMorePosts = currentState.loadingMorePosts;

      // If loading more posts, show a loading message.
      if (loadingMorePosts) {
        this.innerHTML = "Loading more posts...";
      } else {
        // If not loading more posts, clear the component text.
        this.innerHTML = "";
      }
    }
  }]);
}(HTMLElement);
/**
 * JoveResults Class.
 */
var JoveResultsCount = /*#__PURE__*/function (_HTMLElement7) {
  /**
   * Constructor.
   *
   * This method is called when an instance of the component is created. It sets up the component by
   * subscribing to updates.
   */
  function JoveResultsCount() {
    var _this7;
    _classCallCheck(this, JoveResultsCount);
    _this7 = _callSuper(this, JoveResultsCount);

    // Subscribe to updates.
    // This method listens for updates in the state and calls the `update` method when the state changes.
    subscribe(_this7.update.bind(_this7));
    return _this7;
  }

  /**
   * Update the component.
   *
   * @param {Object} currentState Current state.
   */
  _inherits(JoveResultsCount, _HTMLElement7);
  return _createClass(JoveResultsCount, [{
    key: "update",
    value: function update() {
      var currentState = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var resultCount = currentState.resultCount;

      // If the result count is available, update the component text.
      if (null !== resultCount) {
        this.innerHTML = "Results: ".concat(resultCount, " Posts");
      }
    }
  }]);
}(HTMLElement);
/**
 * Clear All Filters.
 */
var JoveClearAllFilters = /*#__PURE__*/function (_HTMLElement8) {
  /**
   * Constructor.
   *
   * We subscribe to updates and listen for button clicks.
   */
  function JoveClearAllFilters() {
    var _this8;
    _classCallCheck(this, JoveClearAllFilters);
    _this8 = _callSuper(this, JoveClearAllFilters);
    var _getState3 = getState(),
      clearAllFilters = _getState3.clearAllFilters;
    var clearAllFiltersButton = _this8.querySelector("button");

    // Add event listener to clear all filters button.
    clearAllFiltersButton.addEventListener("click", function () {
      clearAllFilters();
    });
    return _this8;
  }
  _inherits(JoveClearAllFilters, _HTMLElement8);
  return _createClass(JoveClearAllFilters);
}(HTMLElement);
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
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   slideElementDown: function() { return /* binding */ slideElementDown; },
/* harmony export */   slideElementUp: function() { return /* binding */ slideElementUp; },
/* harmony export */   toggleAccordionContent: function() { return /* binding */ toggleAccordionContent; }
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
var toggleAccordionContent = function toggleAccordionContent(event, accordionEl, contentEl) {
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
var slideElementDown = function slideElementDown(element) {
  var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 300;
  var callback = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
  element.style.height = "".concat(element.scrollHeight, "px");
  setTimeout(function () {
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
var slideElementUp = function slideElementUp(element) {
  var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 300;
  var callback = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
  element.style.height = "".concat(element.scrollHeight, "px");
  element.offsetHeight; // eslint-disable-line
  element.style.height = "0px";
  setTimeout(function () {
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
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
!function() {
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

}();
/******/ })()
;
//# sourceMappingURL=search.js.map