 <?php
/**
 * CTA block (parent).
 *
 * @param array  $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool   $is_preview True during backend preview render.
 * @param int    $post_id The post ID the block is rendering content against.
 *                     This is either the post ID currently being displayed inside a query loop,
 *                     or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

// acf data
$height = get_field('height');
$width 	= get_field('width');

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
$style = '';
if ( ! empty( $height ) ) {
	$style .= 'height:' . esc_attr(	$height ) . 'px;';
}
if ( ! empty( $width ) ) {
	$style .= 'width:' . esc_attr( $width ) . 'px;';
}
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
     <div class="jove-divider-block bg-black" style="<?php echo $style; ?>"></div>
     <?php if ( ! $is_preview ) { ?>
 </div>
 <?php } ?>