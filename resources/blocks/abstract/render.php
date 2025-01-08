 <?php
/**
 * Abstract block (parent).
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

$post_id = get_the_ID(); // Replace with a specific post ID if needed.
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

     <div class="jove-abstract-block">
         <div class="jove-abstract-block__entry-header">
             <h2 class="jove-abstract-block__heading"><?php the_title(); ?></h2>

             <?php
				$items 		= get_field('authors_affiliation', $post_id);
				$video		= get_field('video_url', $post_id);
				?>
             <div class="jove-abstract-block__authors-affiliations">
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
					$authors 		= wp_list_pluck( $data, 'authors' );
					$authorsData 	= [];
					if ( ! empty( $authors ) ) {
						// Get the total number of items in the array
						$total_items = count($authors);
						// Initialize a counter
						$current_index = 0;
						echo '<ul class="jove-abstract-block__authors">';
							foreach ( $authors as $key => $value ) {
								$authorsData[] = implode('<sub>'.$key.'</sub>, ', $value) . '<sub>'.$key.'</sub>';
							}
							echo '<li>'.implode(' , ', $authorsData).'</li>';
						echo '</ul>';
					}
					$affiliation 	 = wp_list_pluck( $data, 'affiliation' );
					$affiliationData = [];
					if ( ! empty( $affiliation ) ) {
						echo '<ul class="jove-abstract-block__affiliations">';
							foreach ( $affiliation as $key => $value ) {
								$affiliationData[] = '<sub>'.$key.'</sub>'.$value;
							}
							echo '<li>'.implode(' , ', $affiliationData).'</li>';
						echo '</ul>';
					}
				}

				?>
             </div>

             <div class="jove-abstract-block__journal">
                 <?php
				$custom_taxonomy_list = get_the_term_list( $post_id, 'journal', '', ', ', '' );
				if ( $custom_taxonomy_list ) {
					echo $custom_taxonomy_list;
				}
				?>
             </div>

             <div class="jove-abstract-block__date">
                 <p class="jove-abstract-block__date_lable">Published on:</p>
                 <div class="jove-abstract-block__date_line"><?php echo get_the_date(); ?></div>
             </div>


             <div class="jove-abstract-block__social-share">
                 <ul>
                     <li><a href="#popup-info" class="open-popup"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                 height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2">
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
                     style="text-align:center; background:white; padding:20px; margin:auto;">
                     <div class="popup-content">
                         <div class="jove-social-share-header">
                             <h3>Share</h3>
                             <button class="mfp-close-custom"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                     <line x1="18" y1="6" x2="6" y2="18"></line>
                                     <line x1="6" y1="6" x2="18" y2="18"></line>
                                 </svg></button>
                         </div>
                         <ul class="jove-social-share-list">
                             <?php
							$socials = [
								'facebook' => [
									'name' => 'Facebook',
									'link' => 'https://www.facebook.com/sharer/sharer.php?u={url}',
									'icon' => '<svg
										width="20px"
										height="20px"
										viewBox="0 0 20 20"
										aria-hidden="true">
											<path d="M20,10.1c0-5.5-4.5-10-10-10S0,4.5,0,10.1c0,5,3.7,9.1,8.4,9.9v-7H5.9v-2.9h2.5V7.9C8.4,5.4,9.9,4,12.2,4c1.1,0,2.2,0.2,2.2,0.2v2.5h-1.3c-1.2,0-1.6,0.8-1.6,1.6v1.9h2.8L13.9,13h-2.3v7C16.3,19.2,20,15.1,20,10.1z"/>
										</svg>'
								],
								'twitter' => [
									'name' => 'X (Twitter)',
									'link' => 'https://twitter.com/intent/tweet?url={url}&text={text}',
									'icon' => '
										<svg
										width="20px"
										height="20px"
										viewBox="0 0 20 20"
										aria-hidden="true">
											<path d="M2.9 0C1.3 0 0 1.3 0 2.9v14.3C0 18.7 1.3 20 2.9 20h14.3c1.6 0 2.9-1.3 2.9-2.9V2.9C20 1.3 18.7 0 17.1 0H2.9zm13.2 3.8L11.5 9l5.5 7.2h-4.3l-3.3-4.4-3.8 4.4H3.4l5-5.7-5.3-6.7h4.4l3 4 3.5-4h2.1zM14.4 15 6.8 5H5.6l7.7 10h1.1z"/>
										</svg>
									'
								],
								'whatsapp' => [
									'name' => 'WhatsApp',
									'link' => 'whatsapp://send?text={url}',
									'icon' => '
										<svg
										width="20px"
										height="20px"
										viewBox="0 0 20 20"
										aria-hidden="true">
											<path d="M10,0C4.5,0,0,4.5,0,10c0,1.9,0.5,3.6,1.4,5.1L0.1,20l5-1.3C6.5,19.5,8.2,20,10,20c5.5,0,10-4.5,10-10S15.5,0,10,0zM6.6,5.3c0.2,0,0.3,0,0.5,0c0.2,0,0.4,0,0.6,0.4c0.2,0.5,0.7,1.7,0.8,1.8c0.1,0.1,0.1,0.3,0,0.4C8.3,8.2,8.3,8.3,8.1,8.5C8,8.6,7.9,8.8,7.8,8.9C7.7,9,7.5,9.1,7.7,9.4c0.1,0.2,0.6,1.1,1.4,1.7c0.9,0.8,1.7,1.1,2,1.2c0.2,0.1,0.4,0.1,0.5-0.1c0.1-0.2,0.6-0.7,0.8-1c0.2-0.2,0.3-0.2,0.6-0.1c0.2,0.1,1.4,0.7,1.7,0.8s0.4,0.2,0.5,0.3c0.1,0.1,0.1,0.6-0.1,1.2c-0.2,0.6-1.2,1.1-1.7,1.2c-0.5,0-0.9,0.2-3-0.6c-2.5-1-4.1-3.6-4.2-3.7c-0.1-0.2-1-1.3-1-2.6c0-1.2,0.6-1.8,0.9-2.1C6.1,5.4,6.4,5.3,6.6,5.3z"/>
										</svg>
									'
								],
								'linkedin' => [
									'name' => 'LinkedIn',
									'link' => 'https://www.linkedin.com/shareArticle?url={url}&title={text}',
									'icon' => '
										<svg
										width="20px"
										height="20px"
										viewBox="0 0 20 20"
										aria-hidden="true">
											<path d="M18.6,0H1.4C0.6,0,0,0.6,0,1.4v17.1C0,19.4,0.6,20,1.4,20h17.1c0.8,0,1.4-0.6,1.4-1.4V1.4C20,0.6,19.4,0,18.6,0z M6,17.1h-3V7.6h3L6,17.1L6,17.1zM4.6,6.3c-1,0-1.7-0.8-1.7-1.7s0.8-1.7,1.7-1.7c0.9,0,1.7,0.8,1.7,1.7C6.3,5.5,5.5,6.3,4.6,6.3z M17.2,17.1h-3v-4.6c0-1.1,0-2.5-1.5-2.5c-1.5,0-1.8,1.2-1.8,2.5v4.7h-3V7.6h2.8v1.3h0c0.4-0.8,1.4-1.5,2.8-1.5c3,0,3.6,2,3.6,4.5V17.1z"/>
										</svg>
									'
								],
							];
							foreach ( $socials as $key => $value ) {

								$url = str_replace(
									'{url}',
									jove_encode_uri_component( get_the_permalink() ),
									str_replace(
										'{text}',
										jove_encode_uri_component( get_the_title() ),
										$value['link']
									)
								);
								echo '<li><a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer" title="' . esc_attr( $value['name'] ) . '">' . $value['icon'] . '</a></li>';
							}
							?>
                         </ul>
                         <div class="jove-abstract-block__share__link">
                             <p class="jove-abstract-block__share__link-url"><?php the_permalink(); ?></p>
                             <a href="javascript:void(0);" class="jove-abstract-block__share__link-copy">Copy link</a>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="jove-abstract-block__entry-content">
             <h2 class="jove-abstract-block__description__heading">
                 Abstract
             </h2>
             <div class="jove-abstract-block__description__text">
                 <?php the_content(); ?>
             </div>
             <div class="jove-abstract-block__keywords">
                 <?php
				$terms = get_the_terms( $post_id, 'keyword' );
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					echo '<span class="jove-abstract-block__keywords__label">Keywords:</span> ';
					foreach ( $terms as $term ) {
						//$custom_url = 'https://app.jove.com/search?content_type=journal_content&query='.sanitize_title($term->name).'&content_type=&page=1&originalQuery='.jove_encode_uri_component($term->name);
						$custom_url = 'https://app.jove.com/search?content_type=journal_content&originalQuery='.jove_encode_uri_component($term->name).'&page=1&query='.sanitize_title($term->name);
						// Create a clickable link for each term.
						echo '<a href="' . esc_url( $custom_url ) . '" rel="tag">' . esc_html( $term->name ) . '</a>';
					}
				}
				?>
             </div>
         </div>
     </div>
     <?php if ( ! $is_preview ) { ?>
 </div>
 <?php } ?>