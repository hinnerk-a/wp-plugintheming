<?php
/*
Plugin Name: ParentPlugin Example Child Theme
Plugin URI: http://www.hinnerk-altenburg.de
Description: Child theme for ParentPlugin Example
Version: 1.0
Author: Hinnerk Altenburg
Author URI: http://www.hinnerk-altenburg.de
License: (c) 2015, Hinnerk Altenburg. GPLv2
*/

! defined( 'ABSPATH' ) and exit;

add_filter( 'parentplugin_available_themes', 'childplugin_add_theme' );
function childplugin_add_theme( $themes ) {
	$themes['child_theme'] = array(
	                            'name'          => 'ParentPlugin Bootstrap3 Child Theme',
	                            'parent_id'     => 'bootstrap3',
	                            'path'          => plugin_dir_path( __FILE__ ),
	                            'url'           => plugin_dir_url( __FILE__ ),
	                            'use_theme_dir' => true
	                        );
	return $themes;
}

register_activation_hook( __FILE__, "childplugin_activate" );
function childplugin_activate() {
	update_option( 'parentplugin_active_theme', 'child_theme' );
}
register_deactivation_hook( __FILE__, "childplugin_deactivate" );
function childplugin_deactivate() {
	update_option( 'parentplugin_active_theme', 'bootstrap3' );
}

 ?>