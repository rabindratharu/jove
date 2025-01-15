 <?php
/**
 * Concept block (parent).
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
$rest_api 	= get_field('rest_api') ? get_field('rest_api') : 'https://api.jove.com/api/free/search/search_ai';
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

     <div class="jove-concept-video-block">
         <h2 class="jove-concept-video-block__heading"><?php echo esc_html( $heading ); ?></h2>
         <div class="jove-concept-video-block__container">
             <?php
			 // Example usage
			$data = Utils::fetch_api_data($rest_api, [
				'query' 			=> esc_html( get_the_title() ),
				'page' 				=> 1,
				'per_page' 			=> 6,
				'category_filter' 	=> ["encyclopedia_of_experiments","science_education"]
			]);
			if ( is_array( $data ) && array_key_exists('content', $data) && array_key_exists('result', $data['content']) ) {
				?>
             <div class="jove-concept-video-block__lists">
                 <?php foreach ($data['content']['result'] as $key => $value) {
					$url = 'https://app.jove.com/v/' . absint( $value['id'] ) . '/' . sanitize_title($value['title']);
					//$url = 'https://app.jove.com/search?content_type=journal_content&page=1&query=' . jove_encode_uri_component($value['title']);
					?>
                 <a class="jove-concept-video-block__list" href="<?php echo esc_url( $url ); ?>" rel="bookmark">
                     <figure class="jove-concept-video-block__image">
                         <img src="<?php echo esc_url( $value['header_image'] ); ?>">
                         <span
                             class="jove-concept-video-block__image__overlay"><?php echo esc_html($value['lengthMinutes']); ?></span>
                     </figure>
                     <div class="jove-concept-video-block__content">
                         <h3 class="jove-concept-video-block__title">
                             <?php echo wp_kses_post( limit_string_by_characters( $value['title'], 50 ) ); ?>
                         </h3>
                         <div class="jove-concept-video-block__views">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-eye">
                                 <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                 <circle cx="12" cy="12" r="3"></circle>
                             </svg>
                             <?php echo esc_html( $value['total_count_views'] ); ?>
                         </div>
                         <p class="jove-concept-video-block__date">
                             <?php echo wp_kses_post( limit_string_by_characters( $value['excerpt'], 60 ) ); ?></p>
                     </div>
                 </a>
                 <?php
				}?>
             </div>
             <?php
			}
			 ?>
         </div>
     </div>
     <?php if ( ! $is_preview ) { ?>
 </div>
 <?php } ?>