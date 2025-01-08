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
	const containers = document.querySelectorAll(
		".jove-abstract-block__share__link-copy",
	);
	if (!containers.length) {
		return;
	}
	containers.forEach((element) => {
		element.addEventListener("click", () => {
			const cloneLink = element
				.closest(".jove-abstract-block__share__link")
				.querySelector(
					".jove-abstract-block__share__link-url",
				).innerText; // Correctly selects the child
			console.log(cloneLink);
		});
	});
});
