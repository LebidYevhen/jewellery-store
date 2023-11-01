<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">

					<div class="site-info">

              <div class="row">
                <div class="col-md-3">
	                <?php if ( is_active_sidebar( 'contact-info-widget-area' ) ) : ?>
                      <div id="contact-info-widget-area" class="contact-info-widget-area">
		                    <?php dynamic_sidebar( 'contact-info-widget-area' ); ?>
                      </div>
	                <?php endif; ?>
                </div>

                <div class="col-md-3">
	                <?php if ( is_active_sidebar( 'recent-posts-widget-area' ) ) : ?>
                      <div id="recent-posts-widget-area" class="recent-posts-widget-area">
			                  <?php dynamic_sidebar( 'recent-posts-widget-area' ); ?>
                      </div>
	                <?php endif; ?>
                </div>

                <div class="col-md-3">
	                <?php if ( is_active_sidebar( 'our-stories-widget-area' ) ) : ?>
                      <div id="our-stories-widget-area" class="our-stories-widget-area">
                        <?php dynamic_sidebar( 'our-stories-widget-area' ); ?>
                      </div>
	                <?php endif; ?>
                </div>

                <div class="col-md-3">
	                <?php if ( is_active_sidebar( 'useful-links-widget-area' ) ) : ?>
                      <div id="useful-links-widget-area" class="useful-links-widget-area">
			                  <?php dynamic_sidebar( 'useful-links-widget-area' ); ?>
                      </div>
	                <?php endif; ?>
                </div>
              </div>

					</div><!-- .site-info -->

				</footer><!-- #colophon -->

			</div><!-- col -->

		</div><!-- .row -->

	</div><!-- .container(-fluid) -->

</div><!-- #wrapper-footer -->

<?php // Closing div#page from header.php. ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>

