<?php
/**
 * Title: Header
 * Slug: jove/header
 * Description: Header with button
 * Categories: header
 * Keywords: header,button
 * Viewport Width: 1440
 * Block Types: core/template-part/header
 * Post Types: wp_template
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"header","metadata":{"name":"Header"},"align":"full","style":{"spacing":{"padding":{"top":"28px","bottom":"28px","right":"31px","left":"31px"}},"elements":{"link":{"color":{"text":"var:preset|color|main"}}}},"backgroundColor":"base","layout":{"inherit":true,"type":"constrained"}} -->
<header class="wp-block-group alignfull has-base-background-color has-background has-link-color"
    style="padding-top:28px;padding-right:31px;padding-bottom:28px;padding-left:31px">
    <!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between"}} -->
    <div class="wp-block-group alignwide">
        <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
        <div class="wp-block-group">
            <!-- wp:image {"lightbox":{"enabled":false},"id":298,"sizeSlug":"full","linkDestination":"custom"} -->
            <figure class="wp-block-image size-full"><a href="http://www.jove.com"><img
                        src="<?php echo esc_url( JOVE_BUILD_URI ); ?>/media/images/jove.png" alt=""
                        class="wp-image-298" /></a></figure>
            <!-- /wp:image -->

            <!-- wp:acf/divider {"name":"acf/divider","data":{"height":"40","_height":"field_676cdd011fe20","width":"1","_width":"field_676cdd271fe21"},"mode":"preview","style":{"layout":{"selfStretch":"fit","flexSize":null}}} /-->

            <!-- wp:heading {"level":1,"style":{"typography":{"textDecoration":"none","fontStyle":"normal","fontWeight":"500"}},"fontSize":"small"} -->
            <h1 class="wp-block-heading has-small-font-size"
                style="font-style:normal;font-weight:500;text-decoration:none"><a
                    href="http://www.jove.com/visualize">VISUALIZE</a></h1>
            <!-- /wp:heading -->
        </div>
        <!-- /wp:group -->

        <!-- wp:buttons -->
        <div class="wp-block-buttons">
            <!-- wp:button -->
            <div class="wp-block-button"><a class="wp-block-button__link wp-element-button"
                    href="https://www.jove.com/about/contact">Contact Us</a></div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->
    </div>
    <!-- /wp:group -->
    <?php if ( !is_home() ) { ?>
    <!-- wp:group {"align":"full","className":"jove-header-search","layout":{"type":"constrained"}} -->
    <div class="wp-block-group alignfull jove-header-search">
        <!-- wp:group {"layout":{"type":"constrained"}} -->
        <div class="wp-block-group">
            <!-- wp:search {"label":"Search","buttonText":"Search"} /-->

            <!-- wp:heading {"className":"jove-cta-video-btn"} -->
            <h2 class="wp-block-heading jove-cta-video-btn"><a href="https://www.youtube.com/watch?v=-g32OQG2Kdg">What
                    is JoVE Visualize?</a></h2>
            <!-- /wp:heading -->
        </div>
        <!-- /wp:group -->
    </div>
    <?php } ?>
    <!-- /wp:group -->
</header>
<!-- /wp:group -->