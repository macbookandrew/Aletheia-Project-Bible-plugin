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

// add activation/deactivation hooks
function activation() {
    require_once( 'inc/activation.php' );
}
register_activation_hook( __FILE__, 'activation' );

function deactivation() {
    require_once( 'inc/deactivation.php' );
}
register_deactivation_hook( __FILE__, 'deactivation' );

// include other sections of plugin
if ( is_admin() ) require_once( 'inc/admin.php' );
if (! is_admin() ) require_once( 'inc/shortcode.php' );
