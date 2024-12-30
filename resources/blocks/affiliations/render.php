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
         <?php
		 // Get all taxonomies associated with this post type
		$authors = get_the_terms(get_the_ID(), 'author');
		if ($authors && !is_wp_error($authors)) {

			echo '<ul class="jove-affiliations-block__authors">';
			foreach ($authors as $author) {
				echo '<li><a href="' . esc_url( get_term_link($author->slug, 'author') ) . '" rel="author">';
				echo esc_html($author->name );
				echo '</a></li>';
			}
			echo '</ul>';
		}
		$institutions = get_the_terms(get_the_ID(), 'institution');
		if ($institutions && !is_wp_error($institutions)) {
			echo '<ul class="jove-affiliations-block__institutions">';
			foreach ($institutions as $institution) {
				$name = ( isset($institution->description) && $institution->description ) ? $institution->description : $institution->name;
			//echo '<pre>'; print_r($institution); echo '</pre>';
				echo '<li><a href="' . esc_url( get_term_link($institution->slug, 'institution') ) . '" rel="institution">';
				echo esc_html( $name );
				echo '</a></li>';
			}
			echo '</ul>';
		}

		?>


         <InnerBlocks class="jove-affiliations-block__innerblocks" orientation="horizontal"
             template="<?php echo esc_attr( wp_json_encode( $inner_blocks_template ) ); ?>" />
     </div>

     <?php } ?>

     <?php if ( ! $is_preview ) { ?>
 </div>
 <?php } ?>