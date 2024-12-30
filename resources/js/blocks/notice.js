document.addEventListener("DOMContentLoaded", () => {
	const containers = document.querySelectorAll(".jove-notice-block__close");
	if (!containers.length) {
		return;
	}
	containers.forEach((element) => {
		element.addEventListener("click", () => {
			const parentDiv = element.closest(".jove-notice-block"); // Replace with the parent div's class
			if (parentDiv) {
				parentDiv.style.display = "none"; // Hide the parent div
			}
		});
	});
});
