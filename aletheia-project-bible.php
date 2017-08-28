<?php
/**
 * Plugin Name: Aletheia Project Bible
 * Plugin URI: https://github.com/macbookandrew/Aletheia-Project-Bible-plugin
 * Description: A plugin to import and display Bible text
 * Version: 1.0.4
 * Author: AndrewRMinion Design
 * Author URI: http://andrewrminion.com/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

CONST TAP_PLUGIN_VERSION = '1.0.4';

global $wpdb;
global $apb_db_version;
$apb_db_version = '1.0';

global $apb_text_table_name;
global $apb_chapter_headers_table_name;
global $apb_TOC_table_name;
$apb_text_table_name = $wpdb->prefix . 'bible_text';
$apb_chapter_headers_table_name = $wpdb->prefix . 'bible_chapter_headers';
$apb_TOC_table_name = $wpdb->prefix . 'bible_TOC';

// include other sections of plugin
if ( ( is_admin() ) && ( ( ! defined( 'DOING_AJAX' ) ) || ( ! DOING_AJAX ) ) ) require_once( 'inc/admin.php' );
if ( ( ! is_admin() ) || ( defined( 'DOING_AJAX' ) || DOING_AJAX ) ) require_once( 'inc/shortcode.php' );

// add activation/deactivation hooks
function apb_install() {
    global $wpdb;

    global $apb_text_table_name;
    global $apb_chapter_headers_table_name;
    global $apb_TOC_table_name;

    // set up databases
    $charset_collate = $wpdb->get_charset_collate();

    if( $wpdb->get_var( "SHOW TABLES LIKE '$apb_text_table_name'") != $apb_text_table_name ) {
        $apb_sql = "CREATE TABLE `$apb_text_table_name` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `language` varchar(20) DEFAULT NULL,
            `book_id` int(2) DEFAULT NULL,
            `localized_book_name` varchar(100) DEFAULT NULL,
            `chapter_num` int(3) DEFAULT NULL,
            `verse_num` int(3) DEFAULT NULL,
            `verse_text` text,
            PRIMARY KEY (`id`),
            FULLTEXT KEY verse_content (`verse_text`)
        ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $apb_sql );
    }
    if( $wpdb->get_var( "SHOW TABLES LIKE '$apb_chapter_headers_table_name'") != $apb_chapter_headers_table_name ) {
        $apb_sql = "CREATE TABLE `$apb_chapter_headers_table_name` (
            `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
            `language` varchar(20) DEFAULT NULL,
            `book_id` int(2) NOT NULL DEFAULT '0',
            `chapter_num` int(3) NOT NULL DEFAULT '0',
            `chapter_summary` text NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $apb_sql );
    }
    if( $wpdb->get_var( "SHOW TABLES LIKE '$apb_TOC_table_name'") != $apb_TOC_table_name ) {
        $apb_sql = "CREATE TABLE `$apb_TOC_table_name` (
            `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
            `language` varchar(20) DEFAULT NULL,
            `book_id` int(2) NOT NULL DEFAULT '0',
            `localized_book_name` varchar(100) DEFAULT NULL,
            `chapter_count` int(3) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
        ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $apb_sql );
    }

    // set database version
    update_option( 'apb_database_version', 1.0 );
}
register_activation_hook( __FILE__, 'apb_install' );

function deactivation() {
    // TODO: ask if data and tables should be deleted upon deactivation
}
register_deactivation_hook( __FILE__, 'deactivation' );

// add assets
add_action( 'init', 'register_apb_assets' );
function register_apb_assets() {
    wp_register_script( 'apb-js', plugins_url( 'inc/frontend.min.js', __FILE__ ), array( 'jquery' ), TAP_PLUGIN_VERSION, true );
    wp_localize_script( 'apb-js', 'apbAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

    wp_register_style( 'bible-navigation', plugins_url( 'inc/frontend.css', __FILE__ ), array(), TAP_PLUGIN_VERSION );
    wp_register_style( 'tinos', 'https://fonts.googleapis.com/css?family=Tinos:700&subset=hebrew' );

    wp_register_script( 'chosen', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.jquery.min.js', array( 'jquery' ), '1.7.0', true );
    wp_register_style( 'chosen', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.min.css', array(), '1.7.0' );
}

// TODO: add widget for sidebar use
