 <?php
/**
 * Experiment block (parent).
 *
 * @param array  $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool   $is_preview True during backend preview render.
 * @param int    $post_id The post ID the block is rendering content against.
 *                     This is either the post ID currently being displayed inside a query loop,
 *                     or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

use Jove\Inc\Utils;

// Support custom id values.
$block_id = wp_unique_prefixed_id( 'jove-block-id-' );
if ( ! empty( $block['anchor'] ) ) {
	$block_id = esc_attr( $block['anchor'] );
}

// Create class attribute allowing for custom "className".
$class_name = '';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}

// acf data
$heading 	= get_field('heading');
$notice 	= get_field('notice') ? get_field('notice') : '<p>These videos have been matched automatically. <a href="https://www.jove.com/about/contact">Contact us</a> if they are not relevant.</p>';
$button 	= get_field('button_text') ? get_field('button_text') : 'See all related videos';
$rest_api 	= get_field('rest_api') ? get_field('rest_api') : 'https://api.jove.com/api/free/search/search_ai';
$btn_url = 'https://app.jove.com/search?content_type=journal_content&page=1&query=' . jove_encode_uri_component(get_the_title());

?>

 <?php if ( ! $is_preview ) { ?>
 <div <?php
		echo wp_kses_data(
			get_block_wrapper_attributes(
				array(
					'id'    => $block_id,
					'class' => esc_attr( $class_name ),
				)
			)
		);
		?>>
     <?php } ?>

     <div class="jove-experiment-video-block">
         <h2 class="jove-experiment-video-block__heading"><?php echo esc_html( $heading ); ?></h2>
         <div class="jove-experiment-video-block__container">
             <div class="jove-experiment-video-block__notice">
                 <div class="jove-notice__icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                         <path
                             d="M12 22C6.477 22 2 17.523 2 12C2 6.477 6.477 2 12 2C17.523 2 22 6.477 22 12C22 17.523 17.523 22 12 22ZM11 11V17H13V11H11ZM11 7V9H13V7H11Z"
                             fill="#2183ED"></path>
                     </svg>
                 </div>
                 <div class="jove-notice__text">
                     <?php echo wp_kses_post( $notice ); ?>
                 </div>
                 <div class="jove-notice__close"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="feather feather-x">
                         <line x1="18" y1="6" x2="6" y2="18"></line>
                         <line x1="6" y1="6" x2="18" y2="18"></line>
                     </svg></div>
             </div>
             <?php
			$data = Utils::fetch_api_data($rest_api, [
				'query' 			=> esc_html( get_the_title() ),
				'page' 				=> 1,
				'per_page' 			=> 3,
				'category_filter' 	=> ["journal","jove_core"]
			]);

			if ( is_array( $data ) && array_key_exists('content', $data) && array_key_exists('result', $data['content']) ) {
				?>
             <div class="jove-experiment-video-block__lists">
                 <?php foreach ($data['content']['result'] as $key => $value) {
					$url = 'https://app.jove.com/search?content_type=journal_content&page=1&query=' . jove_encode_uri_component($value['title']);
					?>
                 <div class="jove-experiment-video-block__list">
                     <figure class="jove-experiment-video-block__image">
                         <img src="<?php echo esc_url( $value['header_image'] ); ?>">
                         <span
                             class="jove-experiment-video-block__image__overlay"><?php echo esc_html($value['lengthMinutes']); ?></span>
                     </figure>
                     <div class="jove-experiment-video-block__content">
                         <h3 class="jove-experiment-video-block__title">
                             <a href="<?php echo esc_url( $url ); ?>" rel="bookmark">
                                 <?php echo wp_kses_post( limit_string_by_characters( $value['title'], 60 ) ); ?>
                             </a>
                         </h3>
                         <p class="jove-experiment-video-block__date">
                             <?php esc_html_e( 'Published on: ', 'jove' );?>
                             <?php echo esc_html( date('d-M-Y', strtotime($value['published_at']))); ?>
                         </p>
                         <div class="jove-experiment-video-block__views">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-eye">
                                 <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                 <circle cx="12" cy="12" r="3"></circle>
                             </svg>
                             <?php echo esc_html( $value['total_count_views'] ); ?>
                         </div>
                     </div>
                 </div>
                 <?php
				}?>
             </div>
             <?php
			}
			 ?>

             <div class="jove-experiment-video-block__button">
                 <a href="<?php echo esc_url( $btn_url ); ?>"
                     class="wp-block-button__link wp-element-button"><?php echo esc_html( $button ); ?></a>
             </div>
         </div>

     </div>
     <?php
if ( ! $is_preview ) { ?>
 </div>
 <?php } ?>
