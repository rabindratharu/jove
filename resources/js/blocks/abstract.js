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
