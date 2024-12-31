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
     <div class="jove-authors-affiliations-block">
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
				// Get the total number of items in the array
				$total_items = count($authors);
				// Initialize a counter
				$current_index = 0;
				echo '<ul class="jove-authors-affiliations-block__author-list">';
					foreach ( $authors as $key => $value ) { $current_index++;
						echo '<li>' . implode('<sub>'.$key.'</sub>, ', $value) . '<sub>'.$key.'</sub>';
						// Perform actions for all items except the last one
						if ($current_index !== $total_items) {
							echo '<span class="jove-separator">,</span>';
						}
						echo '</li>';
					}
				echo '</ul>';
			}
			$affiliation = wp_list_pluck( $data, 'affiliation' );
			if ( ! empty( $affiliation ) ) {
				// Get the total number of items in the array
				$total_items = count($affiliation);
				// Initialize a counter
				$current_index = 0;
				echo '<ul class="jove-authors-affiliations-block__affiliation-list">';
					foreach ( $affiliation as $key => $value ) { $current_index++;
						echo '<li><sub>'.$key.'</sub>' . $value;
						// Perform actions for all items except the last one
						if ($current_index !== $total_items) {
							echo '<span class="jove-separator">,</span>';
						}
						echo '</li>';
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