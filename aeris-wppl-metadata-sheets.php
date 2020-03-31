<?php 
/**
* Plugin Name: Aeris Metadata Sheets
* Plugin URI : https://github.com/aeris-data/aeris-wppl-metadata-sheets
* Text Domain: aeris-wppl-metadata-sheets
* Domain Path: /languages
* Description: Manage AERIS metadatas sheets
* Author: Pierre VERT
* Version: 1.1.1
* GitHub Plugin URI: aeris-data/aeris-wppl-metadata-sheets
* GitHub Branch:     master
*/

// ====================================================================================
/** 
* REGISTER Custom Post Type (cpt)
*/
function aeris_wppl_metadata_sheets_cpt() {
    register_post_type( 
        'aeris-metadata-sheet', 							
        array(
            'label' => __('Metadata sheet', 'aeris-wppl-metadata-sheets'),			
            'labels' => array(    			
                'name' => __('Metadata sheets', 'aeris-wppl-metadata-sheets'),
                'singular-name' => __('Metadata sheet', 'aeris-wppl-metadata-sheets'),
                'all_items' => __('All metadata', 'aeris-wppl-metadata-sheets'),
                'add_new_item' => __('Add new metadata', 'aeris-wppl-metadata-sheets'),
                'edit_item' => __('Edit metadata', 'aeris-wppl-metadata-sheets'),
                'new_item' => __('New metadata', 'aeris-wppl-metadata-sheets'),
                'view_item' => __('View metadata', 'aeris-wppl-metadata-sheets'),
                'search_item' => __('Search metadata', 'aeris-wppl-metadata-sheets'),
                'not_found' => __('No metadata found', 'aeris-wppl-metadata-sheets'),
                'not_found_in_trash' => __('No metadata found in trash', 'aeris-wppl-metadata-sheets')
            ),
            'public' => true, 				
            'show_in_rest' => true,         
            'capability_type' => 'post',
            // rewrite URL 
            'rewrite' => array( 'slug' => 'metadata'),
            'supports' => array(			
                'title',
            ),
            'has_archive' => true, 
            // Url vers une icone ou identifiant à choisir parmi celles de WP : https://developer.wordpress.org/resource/dashicons/.
            'menu_icon'   => 'dashicons-media-document'
        ) 
    );
}
add_action('init', 'aeris_wppl_metadata_sheets_cpt');

// ====================================================================================
/*
* PLUGIN ACTIVATION / DESACTIVATION
* WARNING !! Flush rewrite rules function is an expensive operation ! use only on activation/desactivation plugin 
* source : https://codex.wordpress.org/Function_Reference/flush_rewrite_rules
*/

function aeris_wppl_metadata_sheets_flush_rewrites() {
    // call your CPT registration function here (it should also be hooked into 'init')
    aeris_wppl_metadata_sheets_cpt();
    // clear the permalinks after the post type has been registered
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'aeris_wppl_metadata_sheets_flush_rewrites' );

function aeris_wppl_metadata_sheets_deactivation() {
    // unregister the post type, so the rules are no longer in memory
    unregister_post_type( 'aeris-metadata-sheet' );
    // clear the permalinks to remove our post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'aeris_wppl_metadata_sheets_deactivation' );

// ====================================================================================
/* 
* LOAD TEXT DOMAIN FOR TEXT TRANSLATIONS
*/

function aeris_wppl_metadata_sheets_load_plugin_textdomain() {
    $domain = 'aeris-wppl-metadata-sheets';
    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
    // wp-content/languages/plugin-name/plugin-name-fr_FR.mo
    load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
    // wp-content/plugins/plugin-name/languages/plugin-name-fr_FR.mo
    load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'aeris_wppl_metadata_sheets_load_plugin_textdomain' );

// ====================================================================================
/*
* REGISTER TPL SINGLE
*/
add_filter ( 'single_template', 'aeris_wppl_metadata_sheets_single' );
function aeris_wppl_metadata_sheets_single($single_template) {
    global $post;
    
    if ($post->post_type == 'aeris-metadata-sheet') {
        $single_template = plugin_dir_path ( __FILE__ ) . 'single-aeris-metadata-sheets.php';
    }
    return $single_template;
}

/*
* REGISTER TPL ARCHIVE
*/

add_filter( 'archive_template', 'aeris_wppl_metadata_sheets_archive' ) ;
function aeris_wppl_metadata_sheets_archive( $archive_template ) {
    global $post;

    if ( is_post_type_archive ( 'aeris-metadata-sheet' ) ) {
         $archive_template = dirname( __FILE__ ) . '/archive-aeris-metadata-sheets.php';
    }
    return $archive_template;
}


// ====================================================================================
/*
* HIDE CPT FOT ADMIN MENU
*/
function aeris_wppl_metadata_sheets_remove_menu_items() {
    if( !current_user_can( 'administrator' ) ):
        remove_menu_page( 'edit.php?post_type=aeris-metadata-sheet' );
    endif;
}
add_action( 'admin_menu', 'aeris_wppl_metadata_sheets_remove_menu_items' );

?>