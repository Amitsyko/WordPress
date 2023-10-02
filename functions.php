<?php




// -----------------------Resgister menus in dashboard--------------------------------

if ( ! function_exists( 'mytheme_register_nav_menu' ) ) {

	function mytheme_register_nav_menu(){
		register_nav_menus( array(
	    	'primary_menu' => __( 'Primary Menu', 'text_domain' ),
	    	'footer_menu'  => __( 'Footer Menu', 'text_domain' ),
		) );
	}
	add_action( 'after_setup_theme', 'mytheme_register_nav_menu', 0 );
}	

// --------------------------Custom Post type in News---------------------------------

// 

/*	
* Creating a function to create our CPT
*/
  
function custom_post_type() {
  
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'News', 'Post Type General Name', 'twentytwentyone' ),
        'singular_name'       => _x( 'News', 'Post Type Singular Name', 'twentytwentyone' ),
        'menu_name'           => __( 'News', 'twentytwentyone' ),
        'parent_item_colon'   => __( 'Parent News', 'twentytwentyone' ),
        'all_items'           => __( 'All News', 'twentytwentyone' ),
        'view_item'           => __( 'View News', 'twentytwentyone' ),
        'add_new_item'        => __( 'Add New News', 'twentytwentyone' ),
        'add_new'             => __( 'Add New', 'twentytwentyone' ),
        'edit_item'           => __( 'Edit News', 'twentytwentyone' ),
        'update_item'         => __( 'Update News', 'twentytwentyone' ),
        'search_items'        => __( 'Search News', 'twentytwentyone' ),
        'not_found'           => __( 'Not Found', 'twentytwentyone' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwentyone' ),
    );
      
// Set other options for Custom Post Type
      
    $args = array(
        'label'               => __( 'news', 'twentytwentyone' ),
        'description'         => __( 'News news and reviews', 'twentytwentyone' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
    );
      
    // Registering your Custom Post Type
    register_post_type( 'news', $args );
  
}
  
add_action( 'init', 'custom_post_type', 0 );


function wpdocs_custom_excerpt_length( $length ) {
    return 10;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 100 );

//----------------------------Custom texonomy----------------------------------


//hook into the init action and call create_book_taxonomies when it fires
  
add_action( 'init', 'create_subjects_hierarchical_taxonomy', 0 );
  
//create a custom taxonomy name it subjects for your posts
  
function create_subjects_hierarchical_taxonomy() {
  
// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI
  
  $labels = array(
    'name' => _x( 'Subjects', 'taxonomy general name' ),
    'singular_name' => _x( 'Subject', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Subjects' ),
    'all_items' => __( 'All Subjects' ),
    'parent_item' => __( 'Parent Subject' ),
    'parent_item_colon' => __( 'Parent Subject:' ),
    'edit_item' => __( 'Edit Subject' ), 
    'update_item' => __( 'Update Subject' ),
    'add_new_item' => __( 'Add New Subject' ),
    'new_item_name' => __( 'New Subject Name' ),
    'menu_name' => __( 'Subjects' ),
  );    
  
// Now register the taxonomy
  register_taxonomy('subjects',array('news'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'subject' ),
  ));
  
}

// -------------------------------SideBar----------------------------------------------
function kinsta_register_widgets() {
 
 register_sidebar( array(
  'name' => __( 'After Content', 'kinsta' ),
  'id' => 'after-content',
  'description' => __( 'Widget area after the content', 'kinsta' ),
  'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
  'after_widget' => '</div>',
  'before_title' => '<h3 class="widget-title">',
  'after_title' => '</h3>',

 ) );

}

add_action( 'widgets_init', 'kinsta_register_widgets' );

// --------------------------Custom Tags--------------------------
register_taxonomy( 'events_tag',array('news'),  array(
        'hierarchical' => false, 
        'label' => 'Custom-Tag',
        'show_admin_column' => true, 
        'singular_label' => 'Your Post type Tag',
        'query_var'         => true,
        'rewrite' => array( 'slug' => 'events_tag' ),
        'show_in_rest'       => true,
        'rest_base'          => 'events_tag',
        'rest_controller_class' => 'WP_REST_Terms_Controller',  
        )
    );
//-----------------Ajax Search Box---------------------------------
function enqueue_custom_scripts() {
    wp_enqueue_script('custom-search', get_template_directory_uri() . '/custom-search.js', array('jquery'), null, true);

    wp_enqueue_script('custom-search', get_template_directory_uri() . '/ajaxPagination.js');
    
    // Pass AJAX URL to JavaScript
    wp_localize_script('custom-search', 'custom_search_vars', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
   
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

function get_search_suggestions() {
    $term = sanitize_text_field($_POST['term']);

    // Create an array to store suggestions
    $suggestions = array();

    // Search for posts and pages
    $post_args = array(
        's' => $term,
        'post_type' => array('page', 'news', 'subjects'), // Include your post types
        'posts_per_page' => 5, // Limit the number of post/page suggestions
    );

    $post_query = new WP_Query($post_args);

    if ($post_query->have_posts()) {
        while ($post_query->have_posts()) {
            $post_query->the_post();
            $suggestions[] = '<div class="suggestion"><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></div>';
        }
    }

    // Custom tag search
    $custom_tags = get_terms(array(
        'taxonomy' => 'events_tag', // Replace with your custom tag taxonomy name
        'name__like' => $term,
        'hide_empty' => false,
        'number' => 5, // Limit the number of custom tag suggestions
    ));

    if (!empty($custom_tags)) {
        foreach ($custom_tags as $tag) {
            $suggestions[] = '<div class="suggestion"><a href="' . get_term_link($tag) . '">' . esc_html($tag->name) . '</a></div>';
        }
    }

    // Check if there are any suggestions
    if (!empty($suggestions)) {
        echo implode('', $suggestions);
    } else {
        echo '<div class="no-suggestions">No suggestions found.</div>';
    }


     // Custom tag search
    $custom_tags = get_terms(array(
        'taxonomy' => 'subjects', // Replace with your custom tag taxonomy name
        'name__like' => $term,
        'hide_empty' => false,
        'number' => 5, // Limit the number of custom tag suggestions
    ));

    if (!empty($custom_tags)) {
        foreach ($custom_tags as $tag) {
            $suggestions[] = '<div class="suggestion"><a href="' . get_term_link($tag) . '">' . esc_html($tag->name) . '</a></div>';
        }
    }

    // Check if there are any suggestions
    if (!empty($suggestions)) {
        echo implode('', $suggestions);
    } else {
        echo '<div class="no-suggestions">No suggestions found.</div>';
    }
    // Reset the post data
    wp_reset_postdata();

    die(); // End the AJAX request
}

add_action('wp_ajax_get_search_suggestions', 'get_search_suggestions');
add_action('wp_ajax_nopriv_get_search_suggestions', 'get_search_suggestions');

//----------------Ajax Pagination----------------------------
    function enqueue_ajax_pagination_scripts() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('custom-ajax-pagination', get_template_directory_uri() . '/ajax-pagination.js', array('jquery'), '1.0', true);

        wp_localize_script('custom-ajax-pagination', 'ajaxpagination', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'query_vars' => json_encode($wp_query->query),
            'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
            'max_page' => $the_query->max_num_pages
        ));
    }

    add_action('wp_enqueue_scripts', 'enqueue_ajax_pagination_scripts');


    function ajax_pagination() {
        $query_vars = json_decode(stripslashes($_POST['query_vars']), true);
        $query_vars['paged'] = $_POST['news'];

        $the_query = new WP_Query($query_vars);

        if ($the_query->have_posts()) :
            while ($the_query->have_posts()) : $the_query->the_post();
                // Output your news post content here
            endwhile;
        endif;

        die();
    }

    add_action('wp_ajax_ajax_pagination', 'ajax_pagination');
    add_action('wp_ajax_nopriv_ajax_pagination', 'ajax_pagination');



?>