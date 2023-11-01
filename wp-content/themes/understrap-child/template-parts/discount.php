<?php
$title    = get_acf_field( 'dc_title' );
$discount = get_acf_field( 'dc_discount' );
if ( ! empty( $discount ) ) {
	$title .= '&nbsp;' . sprintf( '<span class="discount">%s</span>', $discount );
}
$list  = get_acf_field( 'dc_list' );
$links = get_acf_field( 'hh_links' );
?>

<section class="discount">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="title"><?php echo $title; ?></h2>
        <h3 class="subtitle"><?php the_acf_field( 'dc_subtitle' ); ?></h3>
        <p class="description"><?php the_acf_field( 'dc_description' ); ?></p>
		  <?php if ( ! empty( $list ) ) { ?>
            <ul class="list">
				<?php foreach ( $list as $item ) { ?>
                  <li>
                    <img src="<?php echo $item['icon']['url']; ?>" alt="Icon">
                    <span><?php echo $item['text']; ?></span>
                  </li>
				<?php } ?>
            </ul>
		  <?php } ?>
		  <?php echo get_links_output($links); ?>
      </div>
      <div class="col-md-6">
        <img src="<?php echo get_acf_field( 'dc_image' )['url']; ?>"
             alt="<?php echo get_acf_field( 'dc_image' )['alt']; ?>">
      </div>
    </div>
  </div>
</section>