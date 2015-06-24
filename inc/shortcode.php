<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// get parameters from query string
global $query_book;
global $query_chapter;
$query_book = esc_html( $_GET['book'] );
$query_chapter = esc_html( $_GET['chapter'] );

function apb_shortcode( $attributes ) {
    // get setting from database
	$options = get_option( 'apb_settings' );
    $installation_language = implode( $options );

    $language = shortcode_atts( array(
        'language' => $installation_language,
    ), $attributes);

    display_selection_form( $language['language'] );
    display_content();
}
add_shortcode( 'apb_display', 'apb_shortcode' );

function display_selection_form( $language ) {
    global $wpdb;
    global $apb_TOC_table_name;
    global $query_book;
    global $query_chapter;

    // get book names and chapter counts
    $apb_books = $wpdb->get_results( "SELECT `book_id`, `localized_book_name`, `chapter_count` FROM $apb_TOC_table_name WHERE `language` LIKE '$language';" );

    // start form
    echo '<form name="bible-navigation" class="bible-navigation">';

    // print JS with number of chapters
    echo '<script type="text/javascript">';
    echo 'var chapterCount = new Array(';
    foreach ( $apb_books as $apb_book ) {
        echo $apb_book->chapter_count;
        if ( $apb_book->book_id !== '66' ) {
            echo ', ';
        }
    }
    echo ');' . "\n";
    echo '(function(){var cTimer=setInterval(function(){if(window.jQuery){jQuery(document).ready(function(){jQuery("select#book").on("change",function(){var thisBook=jQuery("select#book").val();var thisBookCount=chapterCount[(thisBook-1)];jQuery("select#chapter").empty();for(i=1;i<=thisBookCount;i++){jQuery("select#chapter").append("<option value=\""+i+"\">"+i+"</option>");}});});clearInterval(cTimer);}},100);})();';
    echo '</script>';

    // print menus of books and chapters
    echo '<select id="book" name="book">';
    foreach ( $apb_books as $apb_book ) {
        echo '<option value="' . $apb_book->book_id . '">' . $apb_book->localized_book_name . '</option>' . "\n";
    }
    echo '</select>';

    echo '<select id="chapter" name="chapter">';
    for ( $i = 1; $i <= 50; $i++ ) {
        echo '<option value="' . $i . '">' . $i . '</option>' . "\n";
    }
    echo '</select>';

    // print submit button and close form
    echo '<input type="submit" class="button button-primary" value="&rarr;">';
    echo '</form>';
}

function display_content() {
    global $wpdb;
    global $apb_text_table_name;
    global $query_book;
    global $query_chapter;

    // query database
    $content = $wpdb->get_results( $wpdb->prepare(
        "SELECT * FROM $apb_text_table_name WHERE book_id = %d AND chapter_num = %d",
        $query_book,
        $query_chapter
    ) );

    // print content
    if ( $content ) {
        echo '<section class="bible-content"><ol>';
        foreach ( $content as $verse ) {
            echo '<li>' . $verse->verse_text . '</li>';
        }
        echo '</ol></section>';
    }
}
