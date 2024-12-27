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
$video = get_field('video');

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

// Which blocks do we want to allow to be nested in InnerBlocks.
$allowed_blocks = array(
	'core/columns',
	'core/column',
	'core/search',
	'core/heading',
);

/**
 * A template string of blocks.
 * Need help converting block HTML markup to an array?
 * 👉 https://happyprime.github.io/wphtml-converter/
 *
 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-templates/
 */
$inner_blocks_template = [
	[
		'core/columns',
		[
			'verticalAlignment' => 'top',
			'style' => [
				'spacing' => [
					'padding' => [
						'top'    => 'var:preset|spacing|0',
						'right'  => 'var:preset|spacing|large',
						'bottom' => 'var:preset|spacing|0',
						'left'   => 'var:preset|spacing|large',
					],
					'blockGap' => [
						'left' => 'var:preset|spacing|large',
					],
				],
			],
		],
		[
			[
				'core/column',
				[
					'verticalAlignment' => 'top',
					'width'             => '',
				],
				[
					[
						'core/search',
						[
							'placeholder' => '| Search from 37,123,123 articles in science research',
							'buttonText'  => 'Search',
						],
					],
					[
						'core/heading',
						[
							'className'       => 'jove-popup-video-btn',
							'content'         => '<a href="'.esc_url($video).'">What is JoVE Visualize?</a>',
						],
					],
				],
			],
		],
	],
];

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

     <div class="jove-search-block">
         <InnerBlocks class="jove-search-block__innerblocks" orientation="horizontal"
             allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
             template="<?php echo esc_attr( wp_json_encode( $inner_blocks_template ) ); ?>" />

     </div>
     <?php if ( ! $is_preview ) { ?>
 </div>
 <?php } ?>