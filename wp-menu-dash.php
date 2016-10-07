<?php
/*
Plugin Name: Menu Dash
Plugin URL: https://github.com/Andreas-Schoenefeldt/wp-menu-dash
Description: Allows to render a menu as a dashboard - good for overview pages
Version: 1.0
Author: Andreas Schönefeldt
Author URI: https://github.com/Andreas-Schoenefeldt
Contributors:
Text Domain: rc_wmd
Domain Path: languages
*/

class rc_wp_menu_dash {

    /*--------------------------------------------*
     * Constructor
     *--------------------------------------------*/

    /**
     * Initializes the plugin by setting localization, filters, and administration functions.
     */
    function __construct() {

        // load the plugin translation files
        add_action( 'init', array( $this, 'textdomain' ) );

        // add custom menu fields to menu
        add_filter( 'wp_setup_nav_menu_item', array( $this, 'rc_wmd_add_custom_nav_fields' ) );

        // save menu custom fields
        add_action( 'wp_update_nav_menu_item', array( $this, 'rc_wmd_update_custom_nav_fields'), 10, 3 );

        // edit menu walker
        add_filter( 'wp_edit_nav_menu_walker', array( $this, 'rc_wmd_edit_walker'), 10, 2 );

    } // end constructor


    /**
     * Load the plugin's text domain
     *
     * @since 1.0
     *
     * @return void
     */
    public function textdomain() {
        load_plugin_textdomain( 'rc_wmd', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    /**
     * Add custom fields to $item nav object
     * in order to be used in custom Walker
     *
     * @access      public
     * @since       1.0
     * @return      void
     */
    function rc_wmd_add_custom_nav_fields( $menu_item ) {

        $menu_item->wmd_subtitle = get_post_meta( $menu_item->ID, '_menu_item_wmd_subtitle', true );
        $menu_item->wmd_background = get_post_meta( $menu_item->ID, '_menu_item_wmd_background', true );
        return $menu_item;

    }

    /**
     * Save menu custom fields
     *
     * @access      public
     * @since       1.0
     * @return      void
     */
    function rc_wmd_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
        // Check if element is properly sent
        if ( is_array( $_REQUEST['menu-item-wmd_subtitle']) ) {
            $subtitle_value = $_REQUEST['menu-item-wmd_subtitle'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_wmd_subtitle', $subtitle_value );
        }

        if (!isset($_REQUEST['menu-item-wmd_background'][$menu_item_db_id])) {
            $_REQUEST['menu-item-wmd_background'][$menu_item_db_id] = '';
        }
        $wmd_background_value = $_REQUEST['menu-item-wmd_background'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, '_menu_item_wmd_background', $wmd_background_value );

    }

    /**
     * Define new Walker edit
     *
     * @access      public
     * @since       1.0
     * @param $walker
     * @param $menu_id
     * @return string
     */
    function rc_wmd_edit_walker($walker,$menu_id) {

        return 'WMD_Walker_Nav_Menu_Edit';

    }

}

// instantiate plugin's class
$GLOBALS['wp_menu_dash'] = new rc_wp_menu_dash();


include_once( 'edit_custom_walker.php' );
include_once( 'custom_walker.php' );

// UPLOAD ENGINE
function load_wp_media_files() {
    wp_enqueue_media();
}

add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );


// shortcodes
include_once('shortcodes/menu_dash.php');
add_shortcode( 'menu_dash', 'sc_wp_menu_dash');