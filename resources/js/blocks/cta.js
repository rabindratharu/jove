/**
 * // This will run on the front end only.
 */

document.addEventListener("DOMContentLoaded", () => {
	const containers = document.querySelectorAll(".jove-cta-block");

	if (!containers.length) {
		return;
	}

	containers.forEach((element) => {
		console.log(element);
	});
});
