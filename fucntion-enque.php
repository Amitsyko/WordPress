Just use this file then first you can inlude in index.php (.....<??php wp_head();?>.....)


<?php 
function enqueue_parent_styles() {

        wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
        wp_enqueue_style('child-style' ,  get_stylesheet_directory_uri().  '/style.css');

        wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
        wp_enqueue_style('fontawesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');
        // wp_enqueue_style('w3-css', 'https://www.w3schools.com/w3css/4/w3.css');
        wp_enqueue_script('bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array(), '4.5.2');
        }
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
?>



