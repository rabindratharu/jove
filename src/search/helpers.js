/* eslint-disable prettier/prettier */
/**
 * Get Filters From URL.
 *
 * @param {Object} url URL object.
 * @param {Array} filterKeys Filter keys to extract.
 * @return {Object} Data containing filters and page number.
 */
export const getFiltersFromUrl = (url = {}, filterKeys = []) => {
  const data = {};

  if (!url || !filterKeys.length) {
    return data;
  }

  /**
   * Build filter's data.
   *
   * Loop through each filter key and if it exists in the URL,
   * add it to the filters data.
   */
  filterKeys.forEach((filterKey) => {
    const paramValue = url.searchParams.get(filterKey);

    // If the value does not exist, skip.
    if (!paramValue) {
      return;
    }

    // Handle page number.
    if (filterKey === "pageNo") {
      data.pageNo = parseInt(paramValue, 10) || 1; // Default to 1 if parsing fails.
      return;
    }

    // Parse filter values as integers.
    const filterValues = paramValue
      .split(",")
      .map((itemValue) => parseInt(itemValue, 10))
      .filter((value) => !isNaN(value)); // Remove invalid numbers.

    // Add filter key and values to filters object.
    data.filters = {
      ...data.filters,
      [filterKey]: filterValues,
    };
  });

  return data;
};

/**
 * Get URL by Adding Filters.
 *
 * @param {Object} filters Filters object.
 * @param {String} rootUrl Root URL.
 * @return {String} URL with added filters.
 */
export const getUrlWithFilters = (filters = {}, rootUrl = "") => {
  const url = new URL(rootUrl);

  // Add filter key-value pairs to search parameters.
  Object.entries(filters).forEach(([key, value]) => {
    if (Array.isArray(value)) {
      url.searchParams.set(key, value.join(",")); // Join array values with commas.
    } else {
      url.searchParams.set(key, value);
    }
  });

  return url.toString();
};

/**
 * Get Results Markup.
 *
 * @param {Array} posts List of posts.
 * @return {String} HTML markup for the posts.
 */
export const getResultMarkup = (posts = []) => {
  if (!Array.isArray(posts) || !posts.length) {
    return "";
  }

  return posts
    .map((post) => {
      const img = post.thumbnail
        ? `<img src="${post.thumbnail}" alt="${post.title}" />`
        : '<img src="https://via.placeholder.com/526x300" width="526" height="300" alt="Placeholder"/>';

      return `
      <section id="post-${
        post.id ?? 0
      }" class="col-lg-4 col-md-6 col-sm-12 pb-4">
        <header>
          <a href="${post.permalink ?? "#"}" class="block">
            <figure class="img-container">
              ${img}
            </figure>
          </a>
        </header>
        <div class="post-excerpt my-4">
          <a href="${post.permalink ?? "#"}" title="${post.title ?? ""}">
            <h3 class="post-card-title">${post.title ?? "Untitled"}</h3>
          </a>
          <div class="mb-4 truncate-4">
            ${post.content ?? ""}
          </div>
          <a href="${post.permalink ?? "#"}" class="btn btn-primary" title="${
            post.title ?? ""
          }">
            View More
          </a>
        </div>
      </section>
      `;
    })
    .join(""); // Join all the markup strings into a single string.
};

/**
 * Get Load More Markup.
 *
 * @param {Number} noOfPages Total number of pages.
 * @param {Number} currentPageNo Current page number.
 * @return {String} HTML markup for the "Load More" button.
 */
export const getLoadMoreMarkup = (noOfPages = 0, currentPageNo = 1) => {
  if (currentPageNo >= noOfPages) {
    return "";
  }

  return `
    <jove-load-more
      class="load-more-wrap"
      next-page-no="${currentPageNo + 1}"
    >
      <button class="btn btn-primary">Load More</button>
    </jove-load-more>
  `;
};
