<?php
function my_enqueue_scripts()
{
    wp_enqueue_script('my-slideshow', plugin_dir_url(__FILE__) . 'includes/js/my-slideshow.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

// //To show slideshow when short code is used
// function my_plugin_enqueue_styles() {
//     wp_enqueue_style( 'plugin-custom-style', plugins_url( 'includes/css/slideshow-custom-style.css', __FILE__ ) );
// }
// add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_styles' );

// function my_enqueue_scripts() {
//     wp_enqueue_script( 'my-slideshow', plugin_dir_url( __FILE__ ) . 'includes/js/slideshow-custom-script.js', array( 'jquery' ), '1.0', true );
// }
// add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );


