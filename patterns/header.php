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
        <!-- wp:site-logo {"url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo.png","width":183,"shouldSyncIcon":true} /-->

        <!-- wp:buttons -->
        <div class="wp-block-buttons">
            <!-- wp:button -->
            <div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Contact Us</a></div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->
    </div>
    <!-- /wp:group -->
</header>
<!-- /wp:group -->