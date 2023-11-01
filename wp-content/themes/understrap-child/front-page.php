<?php
/**
 * The template for displaying a front page.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

	<div class="wrapper py-0" id="page-wrapper">

		<div id="content" tabindex="-1">

			<div class="row">

				<main class="site-main" id="main">

				<?php get_flexible_content(); ?>

				</main>

			</div><!-- .row -->

		</div><!-- #content -->

	</div><!-- #page-wrapper -->

<?php
get_footer();
