/**
 * Global variables.
 */
import { toggleAccordionContent } from "../utils";

const { customElements, HTMLElement } = window;

/**
 * AquilaCheckboxAccordion Class.
 */
class AquilaCheckboxAccordion extends HTMLElement {
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
 * Initialize.
 */
customElements.define("aquila-checkbox-accordion", AquilaCheckboxAccordion);
