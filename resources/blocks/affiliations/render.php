 <?php
/**
 * Affiliations block (parent).
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

     <?php if ( is_single() && 'video' === get_post_type()) {
		$post_id 	= get_the_ID(); // Get the current post ID
		$items 		= get_field('authors_affiliation', $post_id);
		$video		= get_field('video_url', $post_id);
        ?>
     <div class="jove-authors-affiliations-block" style="background: red;">
         <?php
		 $data = [];
		 if ( ! empty( $items ) ) {
			foreach ( $items as $key => $value ) { $key++;
				if ( $value['affiliation'] ) {
					$data[$key]['affiliation'] = $value['affiliation']->description ? $value['affiliation']->description : $value['affiliation']->name;
				}
				if ( $value['authors'] ) {
					$data[$key]['authors']	= array_map(function ($term) {
												return $term->name;
											}, $value['authors']);
				}

			}
		}

		if ( ! empty( $data ) ) {

			$authors = wp_list_pluck( $data, 'authors' );
			if ( ! empty( $authors ) ) {
				echo '<ul class="jove-authors-affiliations-block__author-list">';
					foreach ( $authors as $key => $value ) {
						echo '<li>' . implode('<sub>'.$key.'</sub>, ', $value) . '<sub>'.$key.'</sub></li>';
					}
				echo '</ul>';
			}
			$affiliation = wp_list_pluck( $data, 'affiliation' );
			if ( ! empty( $affiliation ) ) {
				echo '<ul class="jove-authors-affiliations-block__affiliation-list">';
					foreach ( $affiliation as $key => $value ) {
						echo '<li><sub>'.$key.'</sub>' . $value . '</li>';
					}
				echo '</ul>';
			}
		}

		?>
     </div>

     <?php } ?>

     <?php if ( ! $is_preview ) { ?>
 </div>
 <?php } ?>