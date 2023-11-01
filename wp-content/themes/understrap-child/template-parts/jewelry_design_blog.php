<?php
$posts = get_acf_field( 'jdb_posts' );
?>

<?php if ( ! empty( $posts ) ) { ?>
  <section class="jewelry-design-blog">
    <div class="container">
      <div class="row">
        <div class="heading-wrapper">
          <h4 class="suptitle"><?php the_acf_field( 'jdb_suptitle' ); ?></h4>
          <h2 class="title"><?php the_acf_field( 'jdb_title' ); ?></h2>
          <p class="description"><?php the_acf_field( 'jdb_description' ); ?></p>
        </div>
      </div>
      <div class="row">
        <div class="carousel-wrapper">
          <div class="swiper jewelry-design-blog-carousel">
            <div class="swiper-wrapper">
              <?php foreach ( $posts as $post_item ) { ?>
                <div class="swiper-slide">
                  <div class="post-wrapper">
                    <div class="post-image-wrapper">
                      <?php echo get_the_post_thumbnail($post_item->ID); ?>
                      <div class="post-date">
                        <span class="post-day"><?php echo get_post_datetime($post_item->ID)->format('j'); ?></span>
                        <span class="post-month"><?php echo get_post_datetime($post_item->ID)->format('M'); ?></span>
                      </div>
                      <?php $post_term = get_term(wp_get_post_categories($post_item->ID)[0]); ?>
                      <a href="<?php echo get_term_link($post_term->term_id); ?>" class="post-category"><?php echo $post_term->name; ?></a>
                    </div>
                    <div class="post-content-wrapper">
                      <h4 class="post-tile"><?php echo get_the_title($post_item->ID); ?></h4>
                      <div class="post-author-box">
                        <span class="posted-by">Posted by</span>
                        <a href="<?php echo get_the_author_meta('user_url', $post_item->post_author)?>" class="author-picture"><?php echo get_avatar($post_item->post_author , 32); ?></a>
                        <a href="<?php echo get_the_author_meta('user_url', $post_item->post_author)?>" class="author-name"><?php echo get_the_author_meta('display_name', $post_item->post_author); ?></a>
                      </div>
                      <div class="description"><?php echo wp_trim_words(get_the_content(null, false, $post_item->ID), 19); ?></div>
                      <a href="<?php echo get_permalink($post_item->ID); ?>" class="continue-reading">Continue Reading</a>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
            <div class="swiper-button-next swiper-button-next-slide"></div>
            <div class="swiper-button-prev swiper-button-prev-slide"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Initialize Swiper -->
  <script>
      var swiper = new Swiper('.jewelry-design-blog-carousel', {
          slidesPerView: 3,
          spaceBetween: 20,
          loop: true,
          navigation: {
              nextEl: '.swiper-button-next-slide',
              prevEl: '.swiper-button-prev-slide',
          },
      });
  </script>
<?php } ?>