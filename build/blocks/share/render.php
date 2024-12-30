 <?php
/**
 * Social Share block (parent).
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
//$file = get_field('video');

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

/**
 * A template string of blocks.
 * Need help converting block HTML markup to an array?
 * 👉 https://happyprime.github.io/wphtml-converter/
 *
 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-templates/
 */
$inner_blocks_template = [
	[
		'core/paragraph',
		[
			'content'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nost.',
		]
	]
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

     <div class="jove-social-share-block" style="background:yellow;">
         Social share
         <ul>
             <li><a href="#popup-info" class="open-popup"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="feather feather-share-2">
                         <circle cx="18" cy="5" r="3"></circle>
                         <circle cx="6" cy="12" r="3"></circle>
                         <circle cx="18" cy="19" r="3"></circle>
                         <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                         <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                     </svg></a>
             </li>
             <li><a href="https://app.jove.com/auth/signin"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                         height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="feather feather-bookmark">
                         <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                     </svg></a>
             </li>
         </ul>
         <div id="popup-info" class="mfp-hide"
             style="text-align:center; background:white; padding:20px; width:300px; margin:auto;">
             <div class="popup-content">
                 <h2>Popup Title</h2>
                 <p>This is the content of the popup box.</p>
                 <button class="mfp-close-custom">Close</button>
             </div>
         </div>

     </div>


     <?php if ( ! $is_preview ) { ?>
 </div>

 <?php } ?>