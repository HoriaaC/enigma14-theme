<?php get_header(); ?>
	
	<!-- Section -->
	<section>
	
		<h1><?php echo sprintf( __( '%s Search Results for ', 'enigma14' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>
		
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