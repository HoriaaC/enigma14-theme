<?php get_header(); ?>
	
	<!-- Section -->
	<section>
	
		<h1><?php _e( 'Archives', 'enigma14' ); ?></h1>
	
		<?php get_template_part('loop'); ?>
		
		<!-- Pagination -->
		<div id="pagination">
			<?php enigma14_pagination(); ?>
		</div>
		<!-- /Pagination -->
	
	</section>
	<!-- /Section -->
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>