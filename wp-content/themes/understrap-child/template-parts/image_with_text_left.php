<?php
	$links = get_acf_field('hh_links');
	$video = get_acf_field('iwtl_video');
?>

<section class="image-with-text-left">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="background-element" style="background-image: url(<?php echo get_acf_field('iwtl_image')['url']; ?>)">
					<?php if (!empty($video)) { ?>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary video-btn" data-bs-toggle="modal" data-src="<?php echo $video; ?>" data-bs-target="#exampleModal">
              <img src="<?php echo get_stylesheet_directory_uri() . '/images/play.svg'; ?>">
          </button>
			    <?php get_template_part('template-parts/modal'); ?>
					<?php } ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="content-wrapper">
					<h4 class="suptitle"><?php the_acf_field('iwtl_suptitle'); ?></h4>
					<h2 class="title"><?php the_acf_field('iwtl_title'); ?></h2>
					<h3 class="subtitle"><?php the_acf_field('iwtl_subtitle'); ?></h3>
			    <?php echo get_links_output($links); ?>
				</div>
			</div>
		</div>
	</div>

</section>