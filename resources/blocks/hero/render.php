 <?php
/**
 * Author Info block (parent).
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
$class_name = 'jove-hero-search-block';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}

// Which blocks do we want to allow to be nested in InnerBlocks.
$allowed_blocks = array(
	'core/columns',
	'core/column',
	'core/heading',
	'core/paragraph',
	'core/search',
);

/**
 * A template string of blocks.
 * Need help converting block HTML markup to an array?
 * 👉 https://happyprime.github.io/wphtml-converter/
 *
 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-templates/
 */
$inner_blocks_template = array(
	array(
		'core/columns',
		array(
			'verticalAlignment' => 'center',
			'style'             => array(
				'spacing' => array(
					'padding' => array(
						'top'    => 'var:preset|spacing|30',
						'right'  => 'var:preset|spacing|30',
						'bottom' => 'var:preset|spacing|30',
						'left'   => 'var:preset|spacing|30',
					),
				),
			),
		),
		array(
			array(
				'core/column',
				array(
					'verticalAlignment' => 'center',
					'width'             => '',
				),
				array(
					array(
						'core/heading',
						array(
							'level' => 2,
							'content'  => 'Visualize the world of science',
						),
						array(),
					),
					array(
						'core/paragraph',
						array(
							'content'  => 'Discover video protocols for 37 million+ research papers',
						),
						array(),
					),
                    array(
						'core/search',
						array(
                            'buttonText' => 'Search',
                            'placeholder' => '| Search from 37,123,123 articles in science research'
						),
						array(),
					),
				),
			),
		),
	),
);

// acf data
$file = get_field('video');
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

     <?php if( $file ) { ?>
     <div class="jove-hero-search-block__video">
         <video autoplay muted>
             <source src="<?php echo $file['url']; ?>" type="video/mp4">
         </video>
     </div>
     <?php } ?>
     <InnerBlocks class="jove-hero-search-block__innerblocks" orientation="horizontal"
         allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
         template="<?php echo esc_attr( wp_json_encode( $inner_blocks_template ) ); ?>" />
     <?php if ( ! $is_preview ) { ?>
 </div>
 <?php } ?>