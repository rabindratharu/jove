"use strict";

import magnificPopup from "magnific-popup";

(function ($) {
	$(function () {
		// Initialize magnificPopup for elements with the "open-popup" class
		$(".open-popup").magnificPopup({
			type: "inline", // Inline type for popup content
			fixedContentPos: true, // Keep popup position fixed
			closeBtnInside: true, // Include the close button inside the popup
			preloader: false, // Disable the preloader
			removalDelay: 160, // Delay for the closing animation
			mainClass: "mfp-fade", // Add fade animation class
			callbacks: {
				open: function () {
					// Custom logic when the popup opens (if needed)
					console.log("Popup opened");
				},
				close: function () {
					// Custom logic when the popup closes (if needed)
					console.log("Popup closed");
				},
			},
		});

		// Add a custom close button dynamically
		$(document).on("click", ".mfp-close-custom", function () {
			$.magnificPopup.close(); // Close the popup programmatically
		});
	});
})(jQuery);

document.addEventListener("DOMContentLoaded", () => {
	const textarea = document.querySelector("#copytext");
	const button = document.querySelector("#copytextbtn");

	if (!textarea || !button) {
		console.error("Textarea or button element not found!");
		return;
	}

	button.addEventListener("click", async () => {
		try {
			const textToCopy = textarea.value;

			if (!textToCopy) {
				//alert("No text to copy!");
				return;
			}

			if (navigator.clipboard && navigator.clipboard.writeText) {
				// Modern Clipboard API
				await navigator.clipboard.writeText(textToCopy);
				//alert("Text copied to clipboard!");
			} else {
				// Fallback for older browsers
				textarea.select();
				document.execCommand("copy");
				//alert("Text copied to clipboard (fallback)!");
			}
		} catch (err) {
			console.error(
				"Error copying text to clipboard:",
				err.name,
				err.message,
			);
			//alert("Failed to copy text. Please try again.");
		}
	});
});
