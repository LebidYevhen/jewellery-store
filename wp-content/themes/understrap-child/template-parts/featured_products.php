<?php $carousels = get_acf_field( 'fp_carousel' );

if ( ! empty( $carousels ) ) {

	foreach ( $carousels as $carousel ) {
		$category                         = get_term( $carousel['product_category'], 'product_cat' );
		$category_block_title_color       = $carousel['category_block_title_color'];
		$category_block_description_color = $carousel['category_block_description_color'];

		$args = array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => $carousel['number_of_products'],
			'order'          => 'DESC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'id',
					'terms'    => $carousel['product_category'],
				),
			),
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			$products_ids = array();
			while ( $query->have_posts() ) {
				$query->the_post();
				$products_ids[] = get_the_ID();
			}

			add_action(
				'render_featured_product_category',
				function () use ( $category, $category_block_title_color, $category_block_description_color, $products_ids ) {
					get_template_part(
						'template-parts/featured_product_category',
						null,
						array(
							'category'                   => $category,
							'category_block_title_color' => $category_block_title_color,
							'category_block_description_color' => $category_block_description_color,
							'products_ids'               => $products_ids,
						)
					);
				}
			);
		}
		wp_reset_postdata();
	}
	?>

  <section class="featured-products">
	<div class="container">
	  <div class="row text-center head-block">
		<h4 class="suptitle"><?php the_acf_field( 'fp_suptitle' ); ?></h4>
		<h2 class="title"><?php the_acf_field( 'fp_title' ); ?></h2>
		<h3 class="description"><?php the_acf_field( 'fp_description' ); ?></h3>
	  </div>
		<?php do_action( 'render_featured_product_category' ); ?>
	</div>
  </section>

  <!-- Initialize Swiper -->
  <script>
      var swiper = new Swiper('.featured-products-carousel', {
          slidesPerView: 3,
          spaceBetween: 15,
          loop: true,
          navigation: {
              nextEl: '.swiper-button-next-slide',
              prevEl: '.swiper-button-prev-slide',
          },
      });
  </script>

<?php } ?>
