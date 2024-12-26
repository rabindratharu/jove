"use strict";

import magnificPopup from "magnific-popup";

(function ($) {
	$(function () {
		$(".jove-cta-video-btn a[href]").magnificPopup({
			type: "iframe",
			iframe: {
				markup:
					'<div class="mfp-iframe-scaler">' +
					'<div class="mfp-close"></div>' +
					'<iframe class="mfp-iframe" frameborder="0" allowfullscreen allow="autoplay *; fullscreen *"></iframe>' +
					"</div>",
				patterns: {
					youtube: {
						index: "youtube.com/",
						id: function (url) {
							var m = url.match(/[\\?\\&]v=([^\\?\\&]+)/);
							if (!m || !m[1]) return null;
							return m[1];
						},
						src: "//www.youtube.com/embed/%id%?autoplay=1&iframe=true",
					},
					vimeo: {
						index: "vimeo.com/",
						id: function (url) {
							var m = url.match(
								/(https?:\/\/)?(www.)?(player.)?vimeo.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/,
							);
							if (!m || !m[5]) return null;
							return m[5];
						},
						src: "//player.vimeo.com/video/%id%?autoplay=1",
					},
				},
			},
		});
	});
})(jQuery);
