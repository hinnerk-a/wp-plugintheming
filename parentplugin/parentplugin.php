<?php
/*
 * Plugin Name: ParentPlugin Example
 * Plugin URI: http://www.hinnerk-altenburg.de
 * Description: Example parent plugin for demonstrating the concept of Child Plugins
 * Version: 1.0
 * Author: Hinnerk Altenburg
 * Author URI: http://www.hinnerk-altenburg.de
 * License: GPL2
 *
 * Copyright: © 2015 Hinnerk Altenburg (mail@hinnerk-altenburg.de)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

! defined( 'ABSPATH' ) and exit;

define('PARENTPLUGIN_VERSION',   '1.0');
define('PARENTPLUGIN_DIR_PATH',  plugin_dir_path( __FILE__ ));
define('PARENTPLUGIN_DIR_URL',   plugin_dir_url( __FILE__ ));

add_filter( 'parentplugin_available_themes', 'parentplugin_builtin_themes' );
function parentplugin_builtin_themes( $themes ) {
    $themes['bootstrap3'] = array(
                                'name'          => 'Bootstrap3',
                                'parent_id'     => false,
                                'path'          => PARENTPLUGIN_DIR_PATH . 'themes/bootstrap3/',
                                'url'           => PARENTPLUGIN_DIR_URL  . 'themes/bootstrap3/',
                                'use_theme_dir' => true
                            );
    return $themes;
}
require_once( 'classes/class-parentplugin-theme.php' );
$GLOBALS['parentplugin_theme'] = new ParentPlugin_Theme( get_option( 'parentplugin_active_theme', 'bootstrap3' ) );


if ( !class_exists('ParentPlugin') ) {

    class ParentPlugin {
        public function __construct() {
        	add_action( 'init', array( &$this, 'register_post_types' ), 0 );
			add_action( 'init', array( &$this, 'register_taxonomies' ), 0 );
        }

		public function register_post_types() {

			$labels = array(
				'name'                => _x( 'Movies', 'Post Type General Name', 'parentplugin' ),
				'singular_name'       => _x( 'Movie', 'Post Type Singular Name', 'parentplugin' ),
				'menu_name'           => __( 'Movies', 'parentplugin' ),
				'parent_item_colon'   => __( 'Parent Movie:', 'parentplugin' ),
				'all_items'           => __( 'All Movies', 'parentplugin' ),
				'view_item'           => __( 'View Movie', 'parentplugin' ),
				'add_new_item'        => __( 'Add New Movie', 'parentplugin' ),
				'add_new'             => __( 'Add New', 'parentplugin' ),
				'edit_item'           => __( 'Edit Movie', 'parentplugin' ),
				'update_item'         => __( 'Update Movie', 'parentplugin' ),
				'search_items'        => __( 'Search Movies', 'parentplugin' ),
				'not_found'           => __( 'Not found', 'parentplugin' ),
				'not_found_in_trash'  => __( 'Not found in Trash', 'parentplugin' ),
			);
			$args = array(
				'label'               => __( 'movie', 'parentplugin' ),
				'description'         => __( 'Cinema Movies', 'parentplugin' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'trackbacks', 'custom-fields', ),
				'taxonomies'          => array( 'genres' ),
				'hierarchical'        => false,
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
				'capability_type'     => 'page',
			);
			register_post_type( 'movie', $args );

		}

		function register_taxonomies() {

			$labels = array(
				'name'                       => _x( 'Genres', 'Taxonomy General Name', 'parentplugin' ),
				'singular_name'              => _x( 'Genre', 'Taxonomy Singular Name', 'parentplugin' ),
				'menu_name'                  => __( 'Genres', 'parentplugin' ),
				'all_items'                  => __( 'All Genres', 'parentplugin' ),
				'parent_item'                => __( 'Parent Genre', 'parentplugin' ),
				'parent_item_colon'          => __( 'Parent Genre:', 'parentplugin' ),
				'new_item_name'              => __( 'New Genre Name', 'parentplugin' ),
				'add_new_item'               => __( 'Add New Genre', 'parentplugin' ),
				'edit_item'                  => __( 'Edit Genre', 'parentplugin' ),
				'update_item'                => __( 'Update Genre', 'parentplugin' ),
				'separate_items_with_commas' => __( 'Separate genres with commas', 'parentplugin' ),
				'search_items'               => __( 'Search Genres', 'parentplugin' ),
				'add_or_remove_items'        => __( 'Add or remove genres', 'parentplugin' ),
				'choose_from_most_used'      => __( 'Choose from the most used genres', 'parentplugin' ),
				'not_found'                  => __( 'Not Found', 'parentplugin' ),
			);
			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => false,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_tagcloud'              => true,
			);
			register_taxonomy( 'genres', array( 'movie' ), $args );

		}

    }

    new ParentPlugin;
}