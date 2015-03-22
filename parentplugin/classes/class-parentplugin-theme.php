<?php
! defined( 'ABSPATH' ) and exit;

if ( !class_exists('ParentPlugin_Theme') ) {

    class ParentPlugin_Theme {

    	public function __construct( $theme_id ) {
            if ( empty($theme_id) ) {
                return false;
            } else {
                $this->theme_id = $theme_id;
            }

            // CHANGE THIS TO YOUR PLUGIN SPECIFIC STRINGS
            $this->plugin_slug        = 'parentplugin';
            $this->post_types         = array( 'movie' );
            $this->taxonomy_post_type = 'movie';
            $this->version            = PARENTPLUGIN_VERSION;
            // END CHANGE THIS

            $this->require_file_once( 'functions.php' );

            add_filter( "single_template",      array( &$this, "get_single_template" ) );
            add_filter( "archive_template",     array( &$this, "get_archive_template" ) );
            add_filter( "taxonomy_template",    array( &$this, "get_taxonomy_template" ) );

			add_action( "wp_enqueue_scripts",   array( &$this, "add_scripts_styles" ), 100 );
    	}

        public function available_themes() {
            return apply_filters( $this->plugin_slug . '_available_themes', array() );
        }

        public function available_taxonomies() {
            return apply_filters( $this->plugin_slug . '_theme_available_taxonomies', array() );
        }

        public function get_theme( $theme_id ) {
            $themes = $this->available_themes();
            return $themes[ $theme_id ];
        }

        public function require_file_once( $name ) {
            $paths = $this->get_theme_paths();
            foreach ($paths as $path) {
                $file = $path . $name;
                if ( file_exists( $file ) ) {
                    require_once( $file );
                }
            }
        }

        public function locate_file( $name ) {
            $paths = $this->get_theme_paths();
            foreach ($paths as $path) {
                $file = $path . $name;
                if ( file_exists( $file ) ) {
                    return $file;
                }
            }
        }

        public function get_single_template( $single_template ) {
            if ( is_singular( $this->post_types ) ) {
                global $wp_query;
                $single_template = $this->locate_file( 'single-' . $wp_query->get('post_type') . '.php' );
            }
            return $single_template;
        }

        public function get_archive_template( $archive_template ) {
            if ( is_archive( $this->post_types ) ) {
                global $wp_query;
                $archive_template = $this->locate_file( 'archive-' . $wp_query->get('post_type') . '.php' );
            }
            return $archive_template;
        }

        public function get_taxonomy_template( $taxonomy_template ) {
            if ( is_tax( $this->available_taxonomies() ) ) {
                $taxonomy_template = $this->locate_file( 'archive-' . $this->taxonomy_post_type . '.php' );
            }
            return $taxonomy_template;
        }

        public function add_scripts_styles() {
            $active_plugin_theme = $this->get_theme( $this->theme_id );

            $parent = array();
            // Built-in CSS from parent plugin theme directory
            if ( $active_plugin_theme['parent_id'] ) {
                $parent_theme = $this->get_theme( $active_plugin_theme['parent_id'] );
                $parent = array( $this->plugin_slug . '-parent' );
                if ( file_exists( $parent_theme['path'] . 'css/' . $this->plugin_slug . '.css' ) ) {
                    wp_enqueue_style( $this->plugin_slug . '-parent', $parent_theme['url'] . 'css/' . $this->plugin_slug . '.css', array(), $this->version, 'all' );
                }
            }

            // Custom CSS from WP theme directory
            if ( $active_plugin_theme['use_theme_dir'] ) {
                if ( file_exists( get_stylesheet_directory() . '/' . $this->plugin_slug . '/css/' . $this->plugin_slug . '.css' ) ) {
                    if ( $active_plugin_theme['parent_id'] ) {
                        $deps = array( $this->plugin_slug . '-parent' );
                    } else {
                        $deps = array( $this->plugin_slug );
                    }
                    wp_enqueue_style( $this->plugin_slug . '-custom', get_stylesheet_directory_uri() . '/' . $this->plugin_slug . '/css/' . $this->plugin_slug . '.css', $deps, $this->version, 'all' );
                }
            }

            // Built-in CSS from plugin theme directory
            if ( file_exists( $active_plugin_theme['path'] . 'css/' . $this->plugin_slug . '.css' ) ) {
                wp_enqueue_style( $this->plugin_slug, $active_plugin_theme['url'] . 'css/' . $this->plugin_slug . '.css', $parent, $this->version, 'all' );
            }
        }

        public function get_theme_paths() {
            $theme_paths = array();
            $active_plugin_theme = $this->get_theme( $this->theme_id );

            array_push( $theme_paths, $active_plugin_theme['path'] );

            if ( $active_plugin_theme['use_theme_dir'] ) {
                $theme_mods_path = get_stylesheet_directory() . '/' . $this->plugin_slug . '/';
                if ( is_dir( $theme_mods_path ) ) {
                    array_unshift( $theme_paths, $theme_mods_path );
                }
            }

            if ( $active_plugin_theme['parent_id'] ) {
                $parent_theme = $this->get_theme( $active_plugin_theme['parent_id'] );
                array_push( $theme_paths, $parent_theme['path'] );
            }

            return $theme_paths;
        }

    }
}

function parentplugin_get_template_part( $slug, $name = '' ) {
    global $parentplugin_theme;
    $template_parts = array();
    $theme_paths = $parentplugin_theme->get_theme_paths();

    if ( !empty( $name ) ) {
        foreach ( $theme_paths as $path ) {
            $template = $path . $slug . '-' . $name . '.php';
            array_push( $template_parts, $template );
        }
    }
    foreach ( $theme_paths as $path ) {
        $template = $path . $slug . '.php';
        array_push( $template_parts, $template );
    }
    foreach ( $template_parts as $template_part ) {
        if ( file_exists( $template_part ) ) {
            load_template( $template_part, false );
            return;
        }
    }
    printf( 'Template part not found! slug: %s, name: %s', $slug, $name );
}

?>
