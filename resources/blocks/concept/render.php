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
$json_data 	= get_json_file_data();
$post_id 	= '95';
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
			if ( is_array( $json_data ) && array_key_exists($post_id, $json_data) ) {
				?>
             <div class="jove-concept-video-block__lists">
                 <?php foreach ($json_data[$post_id]['concept'] as $key => $value) {
					?>
                 <div class="jove-concept-video-block__list">
                     <figure class="jove-concept-video-block__image">
                         <img src="<?php echo esc_url( $value['image'] ); ?>">
                         <span class="jove-concept-video-block__image__overlay"><?php echo $value['length']; ?></span>
                     </figure>
                     <div class="jove-concept-video-block__content">
                         <h3 class="jove-concept-video-block__title">
                             <?php echo esc_html( $value['title'], 60 ); ?></h3>
                         <div class="jove-concept-video-block__views">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-eye">
                                 <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                 <circle cx="12" cy="12" r="3"></circle>
                             </svg>
                             <?php echo esc_html( $value['views'] ); ?>
                         </div>
                         <p class="jove-concept-video-block__date">
                             <?php echo esc_html( limit_string_by_characters( $value['description'], 60 ) ); ?></p>
                     </div>
                 </div>
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