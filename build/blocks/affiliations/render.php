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
		$post_id = get_the_ID(); // Get the current post ID
        // Get block fields
		$authors 	= get_field('authors', $post_id);
        $video_url 	= get_field('video_url', $post_id);

		$authors_data = jove_get_authors_affiliations_posts([
			'post_type' => 'author',
			'post__id' => $authors
		]);

		if ( ! empty( $authors_data ) ) {
			foreach ( $authors_data as $key => $author ) {

			}
		}

        ?>
     <div class="jove-affiliations-block" style="background: red;">

         <?php if ( ! empty( $authors_data ) ) {
			$affiliations = '';
			$index = 1;
			echo '<ul class="jove-affiliations-block__authors">';
			foreach ( $authors_data as $key => $author ) {

				// Get the term link
				$term_id 	= array_key_first($author['institution']);
				$term_link 	= get_term_link((int) $term_id, 'institution');

				echo '<li><a href="' . esc_url( $author['url'] ) . '" rel="author">';
				echo esc_html($author['title']);
				echo '<sup>'.absint($index).'</sup></a></li>';

				if ( !empty( $author['affiliation'] ) ) {

					$affiliations .= '<li><a href="' . esc_url( $term_link ) . '"><sup>'.absint($index).'</sup>' . esc_html(implode(',',$author['affiliation'])) . '</a></li>';
				}

				$index++;
			}
			echo '</ul>';

			if ( $affiliations !== '') {
				echo '<ul class="jove-affiliations-block__affiliations">';
				echo $affiliations;
				echo '</ul>';
			}
		} ?>

         <InnerBlocks class="jove-affiliations-block__innerblocks" orientation="horizontal"
             template="<?php echo esc_attr( wp_json_encode( $inner_blocks_template ) ); ?>" />
     </div>

     <?php } ?>

     <?php if ( ! $is_preview ) { ?>
 </div>
 <?php } ?>