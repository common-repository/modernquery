<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package ModernQuery
 * @since Twenty Twenty-One 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header();

$items = \ModernQuery\lib\results\ResultsData::getItems();
$total = \ModernQuery\lib\results\ResultsData::getTotalResultsCount();

//print_r($items);

if ( $items && is_array($items) && count($items) > 0 ) {
	?>
  
	<header class="page-header alignwide">
		<h1 class="page-title">
			<?php
			printf(
				/* translators: %s: Search term. */
				esc_html__( 'Results for "%s"', 'twentytwentyone' ),
				'<span class="page-description search-term">' . esc_html( \ModernQuery\lib\results\ResultsData::$search_string ) . '</span>'
			);
			?>
		</h1>
	</header><!-- .page-header -->

	<div class="search-result-count default-max-width">
		<?php
		printf(
			esc_html(
				/* translators: %d: The number of search results. */
				_n(
					'We found %d result for your search.',
					'We found %d results for your search.',
					(int) \ModernQuery\lib\results\ResultsData::getTotalResultsCount(),
					'twentytwentyone'
				)
			),
			(int) esc_html($total)
		);
		?>
	</div><!-- .search-result-count -->
	<?php
	// Start the Loop.
		foreach( $items as $item ):
  ?>
 		
    <div class="mq-search-result-container">
      <div class="mq-search-result">
        <h2 class="mq-search-result-title">
					<a href ="<?php print esc_attr($item['fields']['url']); ?>"><span><?php print esc_html($item['fields']['title']); ?><span></a></h2>
        <div class="mq-search-result-snippet">
					<?php 
						if (!empty($item['highlights']['content'])) {
          		print wp_kses($item['highlights']['content'], ['strong' => [], 'em' => []]);
						}
					?>
        </div>
      </div>
    </div>

	<?php
    endforeach;
   // End the loop.

	// Previous/next page navigation.
	echo wp_kses(\ModernQuery\lib\results\ResultsRenderer::getPagination(), 'post');

	// If no content, include the "No posts found" template.
} else {
?>
	<div class="mq-no-search-results-box">
		<?php echo esc_html(__('No search results found. Please try again with a different query.')); ?>
	</div>

<?php
}

get_footer();
