<?php
/**
 * Plugin Name: Aletheia Project Bible
 * Plugin URI: https://github.com/macbookandrew/Aletheia-Project-Bible-plugin
 * Description: A plugin to import and display Bible text
 * Version: 1.0
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

global $wpdb;
global $apb_db_version;
$apb_db_version = '1.0';

global $apb_text_table_name;
global $apb_chapter_headers_table_name;
$apb_text_table_name = $wpdb->prefix . 'bible_text';
$apb_chapter_headers_table_name = $wpdb->prefix . 'bible_chapter_headers';

// include other sections of plugin
if ( is_admin() ) require_once( 'inc/admin.php' );
if (! is_admin() ) require_once( 'inc/shortcode.php' );

// add activation/deactivation hooks
function apb_install() {
    global $wpdb;

    global $apb_text_table_name;
    global $apb_chapter_headers_table_name;

    // set up databases
    $charset_collate = $wpdb->get_charset_collate();

    if( $wpdb->get_var( "SHOW TABLES LIKE '$apb_text_table_name'") != $apb_text_table_name ) {
        $apb_sql = "CREATE TABLE `$apb_text_table_name` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `language` varchar(20) DEFAULT NULL,
            `book_id_number` int(2) DEFAULT NULL,
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
        $apb_sql = "CREATE TABLE $apb_chapter_headers_table_name (
            `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
            `language` varchar(20) DEFAULT NULL,
            `book_id_number` int(2) NOT NULL DEFAULT '0',
            `chapter_num` int(3) NOT NULL DEFAULT '0',
            `chapter_summary` text NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $apb_sql );
    }
}
register_activation_hook( __FILE__, 'apb_install' );

function deactivation() {
}
register_deactivation_hook( __FILE__, 'deactivation' );
