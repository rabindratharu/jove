/* eslint-disable prettier/prettier */
/**
 * Get Filters From Url.
 *
 * @param {Object} url URl.
 * @param {Array} filterKeys Filter keys.
 *
 * @return {Object} data Data containing filters and pageNo.
 */
export const getFiltersFromUrl = (url = {}, filterKeys = []) => {
	const data = {};

	if (!url || !filterKeys.length) {
		return data;
	}

	/**
	 * Build filter's data.
	 *
	 * Loop through each filter keys( constant ) and if
	 * they exist in the url, push them to the filters data.
	 */
	filterKeys.forEach((filterKey) => {
		const paramValue = url.searchParams.get(filterKey);

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
		const filterValues = paramValue
			.split(",")
			.map((itemValue) => parseInt(itemValue));

		// Add paramValue to filters.
		data.filters = {
			...data.filters,
			[filterKey]: filterValues,
		};
	});

	return data;
};

/**
 * Get Url by Adding Filters.
 *
 * @param {Object} filters Filters.
 * @param {String} rootUrl Root url.
 */
export const getUrlWithFilters = (filters = ({} = {}), rootUrl = "") => {
	// Build URL.
	let url = new URL(rootUrl);

	// 2.Add the given keys value pairs in search params.
	Object.keys(filters).forEach((key) => {
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
export const getResultMarkup = (posts = []) => {
	if (!Array.isArray(posts) || !posts.length) {
		return "";
	}

	let markup = ``;

	posts.forEach((post) => {
		console.log("🚀 ~ file: helpers.js:87 ~ posts.forEach ~ post:", post);

		markup += `
		<article id="video-${post?.id ?? 0}" class="jove-search-video">
			<h2 class="jove-search-video-title">
				<a href="${post?.permalink ?? ""}" title="${post?.title ?? ""}">
					${post?.title ?? ""}
				</a>
			</h2>
			<div class="jove-search-video-authors-affiliations">
				<div class="jove-search-video-authors">
					Alexander Karamyshev<sub>1</sub>, Andrey L. Karamyshev<sub>1</sub> , Ivan Topisirovic<sub>2</sub>, Kristina Sikström<sub>2</sub>, Tyson E Graber<sub>2</sub>
				</div>
				<div class="jove-search-video-affiliations">
					<sub>1</sub>Texas Tech University , <sub>2</sub>Texas Tech University Health Sciences Center
				</div>
			</div>
			<div class="jove-search-video-meta">
				<div class="jove-search-video-date"><span>Published on:</span>${
					post?.date ?? ""
				}</div>
				<div class="jove-search-video-journal"><span>Journal:</span>${
					post?.journal ?? ""
				}</div>
			</div>
		</article>
		`;
	});

	return markup;
};

export const getLoadMoreMarkup = (noOfPages = 0, currentPageNo = 1) => {
	if (parseInt(currentPageNo) >= parseInt(noOfPages)) {
		return "";
	}

	return `<jove-load-more
				class="load-more-wrap"
				next-page-no="${parseInt(currentPageNo) + 1}"
			>
				<button class="btn btn-primary">Load More</button>
			</jove-load-more>`;
};
