<?php
  $image = get_acf_field('iwtc_image');
  $links = get_acf_field('hh_links');
?>

<section class="image-with-text-centered">
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
      </div>
      <div class="col-md-5 column-centered">
        <h4 class="suptitle"><?php the_acf_field('iwtc_suptitle'); ?></h4>
        <h2 class="title"><?php the_acf_field('iwtc_title'); ?></h2>
        <h3 class="subtitle"><?php the_acf_field('iwtc_subtitle'); ?></h3>
        <p class="description"><?php the_acf_field('iwtc_description'); ?></p>
	      <?php echo get_links_output($links); ?>
      </div>
    </div>
  </div>
</section>