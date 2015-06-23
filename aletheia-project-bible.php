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

global $apb_db_version;
$apb_db_version = '1.0';

$apb_text_table_name = $wpdb->prefix . 'bible_text';
$apb_chapter_headers_table_name = $wpdb->prefix . 'bible_chapter_headers';

// include other sections of plugin
if ( is_admin() ) require_once( 'inc/admin.php' );
if (! is_admin() ) require_once( 'inc/shortcode.php' );

// add activation/deactivation hooks
function apb_install( $apb_text_table_name, $apb_chapter_headers_table_name ) {
    global $wpdb;

    // set up databases
    $charset_collate = $wpdb->get_charset_collate();
    $apb_sql = "CREATE TABLE $apb_text_table_name IF NOT EXISTS (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        book_id_number int(2) NOT NULL DEFAULT '0',
        localized_book_name varchar(100) NOT NULL DEFAULT '',
        chapter_num int(3) NOT NULL DEFAULT '0',
        verse_num int(3) NOT NULL DEFAULT '0',
        verse_text text NOT NULL,
        PRIMARY KEY  id,
        FULLTEXT KEY  verse_content (verse_text)
    ) $charset_collate;
    CREATE TABLE $apb_chapter_headers_table_name IF NOT EXISTS (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        book_id_number int(2) NOT NULL DEFAULT '0',
        chapter_num int(3) NOT NULL DEFAULT '0',
        chapter_summary text NOT NULL
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includise/upgrade.php' );
    dbDelta( $apb_sql );
}
register_activation_hook( __FILE__, 'apb_install' );

// add sample data when requested
function apb_add_sample( $apb_text_table_name, $apb_chapter_headers_table_name ) {
    include('sample/import-sample.php');
}

function deactivation() {
    require_once( 'inc/deactivation.php' );
}
register_deactivation_hook( __FILE__, 'deactivation' );

