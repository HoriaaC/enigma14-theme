<?php if (have_posts()): while (have_posts()) : the_post(); ?>
	
	<!-- Article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
		<!-- Post Thumbnail -->
		<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail(array(120,120)); // Declare pixel size you need inside the array ?>
			</a>
		<?php endif; ?>
		<!-- /Post Thumbnail -->
		
		<!-- Post Title -->
		<h2>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h2>
		<!-- /Post Title -->
		
		<!-- Post Details -->
		<span class="date"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>
		<span class="author"><?php _e( 'Published by', 'enigma14' ); ?> <?php the_author_posts_link(); ?></span>
		<span class="comments"><?php comments_popup_link( __( 'Leave your thoughts', 'enigma14' ), __( '1 Comment', 'enigma14' ), __( '% Comments', 'enigma14' )); ?></span>
		<!-- /Post Details -->
		
		<?php enigma14_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>
		
		<br class="clear">
		
		<?php edit_post_link(); ?>
		
	</article>
	<!-- /Article -->
	
<?php endwhile; ?>

<?php else: ?>

	<!-- Article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'enigma14' ); ?></h2>
	</article>
	<!-- /Article -->

<?php endif; ?>