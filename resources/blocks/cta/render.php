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
$class_name = '';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}

// Which blocks do we want to allow to be nested in InnerBlocks.
$allowed_blocks = array(
	'core/columns',
	'core/column',
	'core/heading',
	'core/paragraph',
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
						'top'    => 'var:preset|spacing|0',
						'right'  => 'var:preset|spacing|0',
						'bottom' => 'var:preset|spacing|0',
						'left'   => 'var:preset|spacing|0',
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
							'content'  => 'What is JoVE Visualize?',
						),
						array(),
					),
					array(
						'core/paragraph',
						array(
							'content'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost.',
						),
						array(),
					),
				),
			),
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
							'content'  => 'What is JoVE Visualize?',
						),
						array(),
					),
					array(
						'core/paragraph',
						array(
							'content'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost. Ut enim ad minim veniam, quis nost.',
						),
						array(),
					),
				),
			),
		),
	),
);

// acf data
// $file = get_field('video');
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

     <div class="jove-cta-block">
         <InnerBlocks class="jove-cta-block__innerblocks" orientation="horizontal"
             allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
             template="<?php echo esc_attr( wp_json_encode( $inner_blocks_template ) ); ?>" />

     </div>
     <?php if ( ! $is_preview ) { ?>
 </div>
 <?php } ?>