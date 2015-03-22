<?php

add_action( 'wp_enqueue_scripts', 'parentplugin_theme_bootstrap3_add_scripts_styles', 97 );
if ( !function_exists( 'parentplugin_theme_bootstrap3_add_scripts_styles' ) ) {
    function parentplugin_theme_bootstrap3_add_scripts_styles() {
        wp_enqueue_script( 'bootstrap3', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js' );
        wp_enqueue_style( 'bootstrap3', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css' );
    }
}

?>