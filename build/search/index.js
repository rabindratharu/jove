/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/search/search.js":
/*!******************************!*\
  !*** ./src/search/search.js ***!
  \******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils */ "./src/utils/index.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
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
 * AquilaCheckboxAccordion Class.
 */
var AquilaCheckboxAccordion = /*#__PURE__*/function (_HTMLElement) {
  /**
   * Constructor.
   */
  function AquilaCheckboxAccordion() {
    var _this;
    _classCallCheck(this, AquilaCheckboxAccordion);
    _this = _callSuper(this, AquilaCheckboxAccordion);

    // Elements.
    _this.filterKey = _this.getAttribute("key");
    _this.content = _this.querySelector(".checkbox-accordion__content");
    _this.accordionHandle = _this.querySelector(".checkbox-accordion__handle");
    if (!_this.accordionHandle || !_this.content || !_this.filterKey) {
      return _possibleConstructorReturn(_this);
    }
    _this.accordionHandle.addEventListener("click", function (event) {
      return (0,_utils__WEBPACK_IMPORTED_MODULE_0__.toggleAccordionContent)(event, _this, _this.content);
    });
    return _this;
  }

  /**
   * Observe Attributes.
   *
   * @return {string[]} Attributes to be observed.
   */
  _inherits(AquilaCheckboxAccordion, _HTMLElement);
  return _createClass(AquilaCheckboxAccordion, [{
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
       * If the state of this checkbox filter is open, then set then
       * active state of this component to true, so it can be opened.
       */
      if ("active" === name) {
        this.content.style.height = "auto";
      } else {
        this.content.style.height = "0px";
      }
    }
  }], [{
    key: "observedAttributes",
    get: function get() {
      return ["active"];
    }
  }]);
}(HTMLElement);
/**
 * AquilaCheckboxAccordionChild Class.
 */
var AquilaCheckboxAccordionChild = /*#__PURE__*/function (_HTMLElement2) {
  /**
   * Constructor.
   */
  function AquilaCheckboxAccordionChild() {
    var _this2;
    _classCallCheck(this, AquilaCheckboxAccordionChild);
    _this2 = _callSuper(this, AquilaCheckboxAccordionChild);
    _this2.content = _this2.querySelector(".checkbox-accordion__child-content");
    _this2.accordionHandle = _this2.querySelector(".checkbox-accordion__child-handle-icon");
    _this2.inputEl = _this2.querySelector("input");

    // Subscribe to updates.
    //subscribe(this.update.bind(this));

    if (_this2.accordionHandle && _this2.content) {
      _this2.accordionHandle.addEventListener("click", function (event) {
        return (0,_utils__WEBPACK_IMPORTED_MODULE_0__.toggleAccordionContent)(event, _this2, _this2.content);
      });
    }
    if (_this2.inputEl) {
      _this2.inputEl.addEventListener("click", function (event) {
        return _this2.handleCheckboxInputClick(event);
      });
    }
    return _this2;
  }

  /**
   * Update the component.
   *
   * @param {Object} currentState Current state.
   */
  _inherits(AquilaCheckboxAccordionChild, _HTMLElement2);
  return _createClass(AquilaCheckboxAccordionChild, [{
    key: "update",
    value: function update() {
      var currentState = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      if (!this.inputEl) {
        return;
      }
      var filters = currentState.filters;
      this.inputKey = this.inputEl.getAttribute("data-key");
      this.inputValue = this.inputEl.getAttribute("value");
      this.selectedFiltersForCurrentkey = filters[this.inputKey] || [];
      this.parentEl = this.inputEl.closest(".checkbox-accordion") || {};
      this.parentContentEl = this.inputEl.closest(".checkbox-accordion__child-content") || {};

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
  }, {
    key: "handleCheckboxInputClick",
    value: function handleCheckboxInputClick(event) {
      var _getState = getState(),
        addFilter = _getState.addFilter,
        deleteFilter = _getState.deleteFilter;
      var targetEl = event.target;
      this.filterKey = targetEl.getAttribute("data-key");
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
 * Initialize.
 */
customElements.define("aquila-checkbox-accordion", AquilaCheckboxAccordion);
customElements.define("aquila-checkbox-accordion-child", AquilaCheckboxAccordionChild);

/***/ }),

/***/ "./src/utils/index.js":
/*!****************************!*\
  !*** ./src/utils/index.js ***!
  \****************************/
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

/***/ }),

/***/ "./src/search/index.css":
/*!******************************!*\
  !*** ./src/search/index.css ***!
  \******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


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
/*!*****************************!*\
  !*** ./src/search/index.js ***!
  \*****************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _index_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.css */ "./src/search/index.css");
/* harmony import */ var _search__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./search */ "./src/search/search.js");
// Styles


// Scripts
//import "./zustand";

}();
/******/ })()
;
//# sourceMappingURL=index.js.map