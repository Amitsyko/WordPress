<?php
/*
 * Template Name: News
 */
?>


<?php get_header(); ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <input type="search" class="search-field" placeholder="Search..." value="<?php echo get_search_query(); ?>" name="s" id="s" autocomplete="off">
    <input type="submit">
    <div id="search-suggestions"></div>
</form>





<div class="main">
<div class="one">
<!--?php get_search_form();?-->	



<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
    'post_type' => 'News',
    'posts_per_page' => 3,
    'paged' => $paged, // Add pagination parameter
    'taxonomy' => 'subjects',	
);

$the_query = new WP_Query($args);
	
?>

<?php if ($the_query->have_posts()) : ?>
    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <h1><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h1>
        <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
       	<p>	<?php echo date(get_option('date_format')); ?> | <span class="lili"><?php
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
       	| <?php echo get_the_author(); ?></p>
        <p>
        	<?php the_excerpt(); ?><a href="<?php the_permalink(); ?>" class="button-read-more">Read More</a></p>
     
        
 
    <?php endwhile; ?>	
    
   <!-- Add pagination links -->
        <div class="pagination">
            <?php
            echo paginate_links(array(
                'total' => $the_query->max_num_pages,
            ));
            ?>
        </div>
 

<!-- ---------------------------Ajax Pagination--------------------- -->


    
   <!--  <div class="pagination">
        </*?php
        echo paginate_links(array(
            'total' => $the_query->max_num_pages,
        ));
        ?>
    </div>
 -->

    
<?php endif; ?>

</div>

<div class="two">
	
	<center><h3>Lataest News</h3></center>
	
	<?php dynamic_sidebar('After Content'); ?>

</div>



</div>
<?php get_footer(); ?>
