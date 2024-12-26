<?php
/**
 * Title: CTA
 * Slug: jove/cta
 * Description:
 * Categories: jove/card, jove/cta
 * Keywords: card, box, link, button, cta, call to action
 * Viewport Width: 1440
 * Block Types:
 * Post Types:
 * Inserter: true
 */
?>
<!-- wp:acf/cta {"align":"","name":"acf/cta","data":{"video":"https://www.youtube.com/watch?v=-g32OQG2Kdg","_video":"field_676b60770f71e"},"mode":"preview"} -->
<!-- wp:columns {"verticalAlignment":"top","style":{"spacing":{"padding":{"top":"var:preset|spacing|large","right":"var:preset|spacing|0","bottom":"var:preset|spacing|large","left":"var:preset|spacing|0"},"blockGap":{"left":"var:preset|spacing|large"}}}} -->
<div class="wp-block-columns are-vertically-aligned-top"
    style="padding-top:var(--wp--preset--spacing--large);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--large);padding-left:var(--wp--preset--spacing--0)">
    <!-- wp:column {"verticalAlignment":"top","width":""} -->
    <div class="wp-block-column is-vertically-aligned-top">
        <!-- wp:heading -->
        <h2 class="wp-block-heading">What is JoVE Visualize?</h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph -->
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
            magna aliqua. Ut enim ad minim veniam, quis nost.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"verticalAlignment":"top","width":""} -->
    <div class="wp-block-column is-vertically-aligned-top">
        <!-- wp:cover {"customOverlayColor":"#b8d9ff","isUserOverlayColor":true,"isDark":false,"style":{"border":{"radius":"8px"}},"layout":{"type":"constrained"}} -->
        <div class="wp-block-cover is-light" style="border-radius:8px"><span aria-hidden="true"
                class="wp-block-cover__background has-background-dim-100 has-background-dim"
                style="background-color:#b8d9ff"></span>
            <div class="wp-block-cover__inner-container">
                <!-- wp:image {"lightbox":{"enabled":false},"linkDestination":"custom","align":"center","className":"jove-cta-video-btn"} -->
                <figure class="wp-block-image aligncenter jove-cta-video-btn"><a
                        href="https://www.youtube.com/watch?v=-g32OQG2Kdg"><img
                            src="<?php echo esc_url( JOVE_BUILD_URI ); ?>/media/svg/play.svg" alt="" /></a>
                </figure>
                <!-- /wp:image -->
            </div>
        </div>
        <!-- /wp:cover -->
    </div>
    <!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- /wp:acf/cta -->