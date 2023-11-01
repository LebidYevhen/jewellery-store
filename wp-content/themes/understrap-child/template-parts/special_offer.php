<?php
$category_id = get_acf_field( 'so_category' );
$category    = get_term( $category_id, 'product_cat' );
$bg_image    = get_acf_field( 'so_background_image' );
$links       = get_acf_field( 'hh_links' );

$featured_products_args  = array(
	'post_type'      => 'product',
	'posts_per_page' => 3,
	'tax_query'      => array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'id',
			'terms'    => $category_id,
		),
		array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => 'featured',
			'operator' => 'IN',
		),
	),
);
$featured_products_query = new WP_Query( $featured_products_args );

$new_products_args  = array(
	'post_type'      => 'product',
	'post_status'    => 'publish',
	'posts_per_page' => 3,
	'order'          => 'DESC',
	'tax_query'      => array(
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'id',
			'terms'    => $category_id,
		),
	),
);
$new_products_query = new WP_Query( $new_products_args );
?>

<section class="special-offer">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="banner-wrapper" style="background-image: url(<?php echo $bg_image['url']; ?>)">
          <div class="banner-inner">
            <h4 class="suptitle"><?php the_acf_field( 'so_suptitle' ); ?></h4>
            <h2 class="title"><?php echo $category->name; ?></h2>
            <p class="description"><?php echo $category->description; ?></p>
	          <?php echo get_links_output( $links ); ?>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-6">
            <div class="products-inner">
              <h4 class="column-name">FEATURED PRODUCTS</h4>
              <?php if ( $featured_products_query->have_posts() ) : ?>
                <div class="products-wrapper">
                  <?php while ( $featured_products_query->have_posts() ) : ?>
                    <?php
                    $featured_products_query->the_post();
                    $product = wc_get_product( get_the_ID() ); ?>
                    <div class="product-wrapper">
                      <?php echo $product->get_image(); ?>
                      <div class="product-info">
                        <a href="<?php echo $product->get_permalink(); ?>" class="product-name">
                            <?php echo $product->get_title(); ?>
                        </a>
                      <?php echo $product->get_price_html(); ?>
                      </div>
                    </div>
                  <?php endwhile; ?>
                  <?php wp_reset_postdata(); ?>
                </div>
              </div>
			      <?php endif; ?>
          </div>
          <div class="col-md-6">
            <div class="products-wrapper">
              <h4 class="column-name">NEW PRODUCTS</h4>
              <?php if ( $new_products_query->have_posts() ) : ?>
                <div class="products-inner">
                  <?php while ( $new_products_query->have_posts() ) : ?>
                    <?php
                    $new_products_query->the_post();
                    $product = wc_get_product( get_the_ID() ); ?>
                    <div class="product-wrapper">
                      <?php echo $product->get_image(); ?>
                        <div class="product-info">
                          <a href="<?php echo $product->get_permalink(); ?>" class="product-name">
                            <?php echo $product->get_title(); ?>
                          </a>
                          <?php echo $product->get_price_html(); ?>
                        </div>
                    </div>
                  <?php endwhile; ?>
                  <?php wp_reset_postdata(); ?>
                </div>
              </div>
	          <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
