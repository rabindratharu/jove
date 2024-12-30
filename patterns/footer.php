<?php
/**
 * Title: Footer
 * Slug: jove/footer
 * Description:
 * Categories: footer
 * Keywords:
 * Viewport Width: 1440
 * Block Types: core/template-part/footer
 * Post Types: wp_template
 * Inserter: true
 */
?>

<!-- wp:group {"tagName":"footer","align":"full","className":"jove-footer","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"spacing":{"padding":{"top":"64px","bottom":"48px"},"blockGap":"48px"}},"backgroundColor":"secondary","textColor":"base","layout":{"inherit":true,"type":"constrained"}} -->
<footer
    class="wp-block-group alignfull jove-footer has-base-color has-secondary-background-color has-text-color has-background has-link-color"
    style="padding-top:64px;padding-bottom:48px">
    <!-- wp:group {"className":"jove-top-footer","style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
    <div class="wp-block-group jove-top-footer has-small-font-size">
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

        <!-- wp:social-links {"iconColor":"base","iconColorValue":"#fff","size":"has-normal-icon-size","className":"is-style-outline-border","style":{"layout":{"selfStretch":"fit","flexSize":null}},"layout":{"type":"flex","justifyContent":"center"}} -->
        <ul class="wp-block-social-links has-normal-icon-size has-icon-color is-style-outline-border">
            <!-- wp:social-link {"url":"#","service":"twitter"} /-->

            <!-- wp:social-link {"url":"#","service":"instagram"} /-->

            <!-- wp:social-link {"url":"#","service":"linkedin"} /-->

            <!-- wp:social-link {"url":"#","service":"facebook"} /-->
        </ul>
        <!-- /wp:social-links -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"jove-footer-widgets","layout":{"type":"constrained"}} -->
    <div class="wp-block-group jove-footer-widgets">
        <!-- wp:columns {"isStackedOnMobile":false,"align":"wide"} -->
        <div class="wp-block-columns alignwide is-not-stacked-on-mobile">
            <!-- wp:column {"width":"60%","layout":{"type":"default"}} -->
            <div class="wp-block-column" style="flex-basis:60%">
                <!-- wp:columns -->
                <div class="wp-block-columns">
                    <!-- wp:column {"layout":{"type":"constrained"}} -->
                    <div class="wp-block-column">
                        <!-- wp:group {"style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"constrained"}} -->
                        <div class="wp-block-group">
                            <!-- wp:heading {"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"base"} -->
                            <h2 class="wp-block-heading has-base-font-size" style="font-style:normal;font-weight:700">
                                ABOUT JoVE</h2>
                            <!-- /wp:heading -->

                            <!-- wp:list {"className":"is-style-list-none"} -->
                            <ul class="wp-block-list is-style-list-none">
                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/about">Overview</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/about/leadership/">Leadership</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://blog.jove.com/">Blog</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="http://myjove.zendesk.com/">JoVE Help Center</a></li>
                                <!-- /wp:list-item -->
                            </ul>
                            <!-- /wp:list -->
                        </div>
                        <!-- /wp:group -->
                    </div>
                    <!-- /wp:column -->

                    <!-- wp:column {"layout":{"type":"constrained"}} -->
                    <div class="wp-block-column">
                        <!-- wp:group {"style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"constrained"}} -->
                        <div class="wp-block-group">
                            <!-- wp:heading {"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"base"} -->
                            <h2 class="wp-block-heading has-base-font-size" style="font-style:normal;font-weight:700">
                                AUTHORS</h2>
                            <!-- /wp:heading -->

                            <!-- wp:list {"className":"is-style-list-none"} -->
                            <ul class="wp-block-list is-style-list-none">
                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/authors/publication">Publishing Process</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/authors/editorial-board">Editorial Board</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/authors/editorial-policies">Scope &amp; Policies</a>
                                </li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/authors/peer-review">Peer Review</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/authors/faq">FAQ</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/authors/submit">Submit</a></li>
                                <!-- /wp:list-item -->
                            </ul>
                            <!-- /wp:list -->
                        </div>
                        <!-- /wp:group -->
                    </div>
                    <!-- /wp:column -->

                    <!-- wp:column {"layout":{"type":"constrained"}} -->
                    <div class="wp-block-column">
                        <!-- wp:group {"style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"constrained"}} -->
                        <div class="wp-block-group">
                            <!-- wp:heading {"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"base"} -->
                            <h2 class="wp-block-heading has-base-font-size" style="font-style:normal;font-weight:700">
                                LIBRARIANS</h2>
                            <!-- /wp:heading -->

                            <!-- wp:list {"className":"is-style-list-none"} -->
                            <ul class="wp-block-list is-style-list-none">
                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/librarians/testimonials">Testimonials</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/librarians/subscriptions">Subscriptions</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/access">Access</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/librarians/resources">Resources</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/librarians/advisory-board">Library Advisory Board</a>
                                </li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/librarians/faq">FAQ</a></li>
                                <!-- /wp:list-item -->
                            </ul>
                            <!-- /wp:list -->
                        </div>
                        <!-- /wp:group -->
                    </div>
                    <!-- /wp:column -->
                </div>
                <!-- /wp:columns -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column {"width":"40%","layout":{"type":"default"}} -->
            <div class="wp-block-column" style="flex-basis:40%">
                <!-- wp:columns -->
                <div class="wp-block-columns">
                    <!-- wp:column {"layout":{"type":"constrained"}} -->
                    <div class="wp-block-column">
                        <!-- wp:group {"style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"constrained"}} -->
                        <div class="wp-block-group">
                            <!-- wp:heading {"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"base"} -->
                            <h2 class="wp-block-heading has-base-font-size" style="font-style:normal;font-weight:700">
                                RESEARCH</h2>
                            <!-- /wp:heading -->

                            <!-- wp:list {"className":"is-style-list-none"} -->
                            <ul class="wp-block-list is-style-list-none">
                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/journal">JoVE Journal</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/methods-collections">Methods Collections</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/encyclopedia-of-experiments">JoVE Encyclopedia of
                                        Experiments</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/encyclopedia-of-experiments">JoVE Encyclopedia of
                                        Experiments</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/archive">Archive</a></li>
                                <!-- /wp:list-item -->
                            </ul>
                            <!-- /wp:list -->
                        </div>
                        <!-- /wp:group -->
                    </div>
                    <!-- /wp:column -->

                    <!-- wp:column {"layout":{"type":"constrained"}} -->
                    <div class="wp-block-column">
                        <!-- wp:group {"style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"constrained"}} -->

                        <div class="wp-block-group">
                            <!-- wp:heading {"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"base"} -->
                            <h2 class="wp-block-heading has-base-font-size" style="font-style:normal;font-weight:700">
                                EDUCATION</h2>
                            <!-- /wp:heading -->

                            <!-- wp:list {"className":"is-style-list-none"} -->
                            <ul class="wp-block-list is-style-list-none">
                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/education/core">JoVE Core</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/business">JoVE Business</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/science-education-library">JoVE Science Education</a>
                                </li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/education/lab-manual">JoVE Lab Manual</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/facultyresources">Faculty Resource Center</a></li>
                                <!-- /wp:list-item -->

                                <!-- wp:list-item -->
                                <li><a href="https://www.jove.com/course-solutions">Faculty Site</a></li>
                                <!-- /wp:list-item -->
                            </ul>
                            <!-- /wp:list -->
                        </div>
                        <!-- /wp:group -->
                    </div>
                    <!-- /wp:column -->
                </div>
                <!-- /wp:columns -->
            </div>
            <!-- /wp:column -->
        </div>
        <!-- /wp:columns -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"jove-footer-menu","style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
    <div class="wp-block-group jove-footer-menu">
        <!-- wp:list {"className":"is-style-list-inline-sept"} -->
        <ul class="wp-block-list is-style-list-inline-sept">
            <!-- wp:list-item -->
            <li><a href="https://app.jove.com/about/policies#step-2">Terms &amp; Conditions of Use</a></li>
            <!-- /wp:list-item -->

            <!-- wp:list-item -->
            <li><a href="https://app.jove.com/about/policies">Privacy Policy</a></li>
            <!-- /wp:list-item -->

            <!-- wp:list-item -->
            <li><a href="https://app.jove.com/about/policies">Policies</a></li>
            <!-- /wp:list-item -->
        </ul>
        <!-- /wp:list -->
    </div>
    <!-- /wp:group
 -->
</footer>

<!-- /wp:group -->