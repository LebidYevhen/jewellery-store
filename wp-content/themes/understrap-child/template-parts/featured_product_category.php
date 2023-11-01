<?php
$category                         = $args['category'];
$category_block_title_color       = $args['category_block_title_color'];
$category_block_description_color = $args['category_block_description_color'];
$category_thumbnail_id            = get_term_meta( $category->term_id, 'thumbnail_id', true );
$category_thumbnail_url           = wp_get_attachment_image_url( $category_thumbnail_id, 'full' );
$products_ids                     = $args['products_ids'];
?>

<div class="row category-row">
  <div class="col-md-3">
    <div class="category-wrapper" style="background-image: url(<?php echo $category_thumbnail_url; ?>)">
      <h4 class="category-name"
          style="color: <?php echo $category_block_title_color; ?>"><?php echo $category->name; ?></h4>
      <p class="description"
         style="color: <?php echo $category_block_description_color; ?>"><?php echo $category->description; ?></p>
    </div>
  </div>
  <!-- Swiper -->
  <div class="col-md-9">
    <div class="featured-products-carousel-wrapper">
      <div class="swiper featured-products-carousel">
        <div class="swiper-wrapper">
			<?php
			foreach ( $products_ids as $id ) {
				$product = wc_get_product( $id );
				?>
              <div class="swiper-slide">
				  <?php echo $product->get_image(); ?>
                <h4 class="title">
                  <a href="<?php echo $product->get_permalink(); ?>">
					  <?php echo $product->get_title(); ?>
                  </a>
                </h4>
                <p class="description"><?php echo wc_get_product_tag_list( $product->get_id() ); ?></p>
                <span class="product-price"><?php echo $product->get_price_html(); ?></span>
              </div>

			<?php } ?>
        </div>
        <div class="swiper-button-next swiper-button-next-slide"></div>
        <div class="swiper-button-prev swiper-button-prev-slide"></div>
      </div>
    </div>
  </div>
</div>



