<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'admin_menu', 'apb_add_admin_menu' );
add_action( 'admin_init', 'apb_settings_init' );

// create TOC when requested
global $wpdb;
global $apb_text_table_name;
global $apb_TOC_table_name;
if ( $_GET['create_TOC'] === 'true' ) {
    $wpdb->query("TRUNCATE $apb_TOC_table_name;");
    $wpdb->query( $wpdb->prepare( "INSERT INTO $apb_TOC_table_name (`language`, `book_id`, `localized_book_name`, `chapter_count`) (SELECT `language`, `book_id`, `localized_book_name`, MAX(`chapter_num`) FROM $apb_text_table_name GROUP BY `language`, `localized_book_name` ORDER BY `book_id`);"
    ) );
}

function apb_add_admin_menu() {
    $my_options_page = add_options_page( 'Aletheia Project', 'Aletheia Project', 'manage_options', 'aletheia_project', 'apb_options_page' );
    add_action( 'admin_print_scripts-' . $my_options_page, 'apb_load_chosen' );
}

function apb_load_chosen() {
    wp_enqueue_script( 'chosen' );
    wp_enqueue_style( 'chosen' );
    echo "<script type=\"text/javascript\">(function(){var cTimer = setInterval(function(){if(window.jQuery){jQuery(document).ready(function(){jQuery('select.chosen').chosen();});clearInterval(cTimer);}},100);})();</script>";
}

function apb_settings_init() {

    register_setting( 'pluginPage', 'apb_settings' );

    add_settings_section(
        'apb_pluginPage_section',
        __( 'Bible Data', 'apb' ),
        '',
        'pluginPage'
    );

    add_settings_field(
        'apb_language',
        __( 'Default Language:', 'apb' ),
        'apb_language_render',
        'pluginPage',
        'apb_pluginPage_section'
    );

    add_settings_field(
        'apb_database',
        __( 'Database Information:', 'apb' ),
        'apb_database_render',
        'pluginPage',
        'apb_pluginPage_section'
    );

    wp_register_script( 'chosen', plugins_url( '/chosen/chosen.jquery.min.js', __FILE__ ) );
    wp_register_style( 'chosen', plugins_url( '/chosen/chosen.min.css', __FILE__ ) );
}

function apb_language_render() {

    $options = get_option( 'apb_settings' );
    $installation_language = implode( $options );
    require_once( 'language-codes.php' );

    echo '<select class="chosen" name="apb_settings[\'apb_default_language\']">';
    foreach ( $language_codes as $key => $value ) {
        echo '<option value="' . $key . '"';
        if ( $installation_language == $key ) { echo ' selected="selected"'; }
        echo '>' . $value . ' [' . $key . ']</option>';
    }
    echo '</select>';
}

function apb_database_render() {
    global $apb_text_table_name;
    global $apb_TOC_table_name;
    global $apb_chapter_headers_table_name;

    echo '<p>Database to use: <code>'. DB_NAME . '</code></p>';
    echo '<p>Table for main text: <code>'. $apb_text_table_name . '</code></p>';
    echo '<p>Table for book names: <code>'. $apb_TOC_table_name . '</code></p>';
    echo '<p>Table for optional chapter summaries: <code>'. $apb_chapter_headers_table_name . '</code></p>';
}

function apb_options_page() {
    ?>
    <form action="options.php" method="post">

        <h2>Aletheia Project</h2>

        <h3>Instructions</h3>
            <p>For full instructions, <a href="https://github.com/macbookandrew/Aletheia-Project-Bible-plugin/blob/master/README.md">read this page</a>.</p>
            <ol>
            <li><a target="_blank" href="<?php echo plugin_dir_url( __FILE__ ); ?>starter.zip">Download starter and sample CSV files</a>.</li>
            <li>In the <code>language</code> column of the file to import, enter the language code listed in [square brackets] below, or find it in <a href="https://github.com/macbookandrew/Aletheia-Project-Bible-plugin/blob/master/README.md#language-codes" target="_blank">this list</a>. Make sure the file is saved with UTF-8 encoding (look in the &ldquo;Save As&hellip;&rdquo; options when saving from Excel or Numbers).</li>
            <li>To import the CSV file, use the webhost&rsquo;s phpMyAdmin (or another MySQL tool), making sure that the CSV column headers match the database column names.</li>
            <li>Come back to this page and press the &ldquo;Create Table of Contens&rdquo; button below.</li>
            <li>Use the <code>[apb_display]</code> shortcode on any page to display the navigation menu and content. To use a different language, specify it in the shortcode with the &ldquo;language&rdquo; attribute (example: <code>[apb_display language="en-US"]</code>).</li>
        </ol>

        <?php
        settings_fields( 'pluginPage' );
        do_settings_sections( 'pluginPage' );
        submit_button();
        ?>

    </form>

    <h3>Table of Contents</h3>
    <p>After uploading the CSV file, come back to this page and press the button below to create the Table of Contents.</p>
    <a class="button button-primary" href="options-general.php?page=aletheia_project&create_TOC=true">Create Table of Contents</a>
    <?php
    if ( $_GET['create_TOC'] === 'true' ) {
        global $wpdb;
        global $apb_TOC_table_name;
        echo '<table>';
        echo '<thead><td>id</td><td>language</td><td>book_id</td><td>localized_book_name</td></thead>';
        $TOC_query = $wpdb->get_results("SELECT * FROM $apb_TOC_table_name;");

        foreach ( $TOC_query as $TOC_element ) {
            echo '<tr>';
            echo '<td>' . $TOC_element->id . '</td>';
            echo '<td>' . $TOC_element->language . '</td>';
            echo '<td>' . $TOC_element->book_id . '</td>';
            echo '<td>' . $TOC_element->localized_book_name . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
}
