<?php
	$bg_image = get_acf_field('hh_background_image');
  $links = get_acf_field('hh_links');
?>

<section class="hero-homepage" style="background-image: url(<?php echo $bg_image['url']; ?>)">
	<div class="container">
		<div class="row">
			<div class="hero-homepage-content">
        <h4 class="suptitle"><?php the_acf_field('hh_suptitle'); ?></h4>
        <h1 class="title"><?php the_acf_field('hh_title'); ?></h1>
        <p class="description"><?php the_acf_field('hh_description'); ?></p>
		    <?php echo get_links_output($links); ?>
      </div>
		</div>
	</div>
</section>