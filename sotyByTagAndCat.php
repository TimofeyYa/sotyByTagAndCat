<?php
// Шорткод для вывода товаров по метке
function woo_products_by_tags_shortcode( $atts, $content = null ) {
	// Get attribuets
	extract(shortcode_atts(array(
	"tags" => '',
	"category" => ''
	), $atts));

	ob_start();

	// Define Query Arguments
	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 10,
		'product_tag' => $tags,
		'product_cat' => $category
	);

	// Create the new query
	$loop = new WP_Query( $args );

	// Get products number
	$product_count = $loop->post_count;

	if( $product_count > 0 ) :

		echo '<div class="tax-product_tag woocommerce-page"><div class="woocommerce"><ul class="products">';

		while ( $loop->have_posts() ) : $loop->the_post(); global $product;
			wc_get_template_part( 'content', 'product' );
		endwhile;

		echo '</ul></div></div>';
		
	else :

		_e('No product matching your criteria.');

	endif; // endif $product_count > 0

	return ob_get_clean();
}

add_shortcode("woo_products_by_tags", "woo_products_by_tags_shortcode");
echo do_shortcode('[woo_products_by_tags tags="Питер" category="Букет"]');