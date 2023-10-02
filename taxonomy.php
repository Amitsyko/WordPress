<?php
	 get_header();
?>

	<div class="aplha">
		<div class="def">
			<center><h3>Lataest News</h3></center>
	
	<?php dynamic_sidebar('After Content'); ?>

		</div>
		<div class="abc">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <!-- HTML and PHP code to display each post -->
    <h2><?php the_title(); ?></h2>
     <p> <?php echo date(get_option('date_format')); ?> | <span class="lili"><?php
                   $taxonomy = 'subjects'; // Replace 'subjects' with your taxonomy name
                   $terms = get_the_terms(get_the_ID(), $taxonomy);
                   if ($terms && !is_wp_error($terms)) {
                       $term_names = array();
                       foreach ($terms as $term) {
                           $term_names[] = '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
                       }
                       echo implode(', ', $term_names);
                   }
                   ?> </span>|
                    <?php
            $events_tag = get_the_terms(get_the_ID(), 'events_tag');
            if ($events_tag && !is_wp_error($events_tag)) {
               
                foreach ($events_tag as $events_tag) {
                    echo '<span class="xylo"><a href="' . esc_url(get_term_link($events_tag)) . '">' . esc_html($events_tag->name)  . " - " .'</a></span>';
                }
               
                    }
        ?>
        | <?php echo get_the_author(); ?>
    </p>
     <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_post_thumbnail('thumbnail'); ?>
    <div class="post-content">
        <p>
        	<?php the_excerpt(); ?><a href="<?php the_permalink(); ?>" class="button-read-more">Read More</a></p>
    </div>
<?php endwhile; else : ?>
    <!-- HTML and PHP code to display a message when no posts are found -->
    <p>No posts found.</p>
<?php endif; ?>
		</div>
		
	</div>

 <?php
	 get_footer();
?>	