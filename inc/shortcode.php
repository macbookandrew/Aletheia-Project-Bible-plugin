<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// get parameters from query string
global $query_book;
global $query_chapter;
global $language;
if ( $_POST && count( $_POST ) > 0 ) {
    $query_book = esc_html( $_POST['book'] );
    $query_chapter = esc_html( $_POST['chapter'] );
    if ( ! $language ) {
        $language = esc_html( $_POST['language'] );
    }
}
// set default parameters
if ( ! $query_book ) { $query_book = 1; }
if ( ! $query_chapter ) { $query_chapter = 1; }

function apb_shortcode( $attributes ) {
    // get setting from database
    $options = get_option( 'apb_settings' );
    $installation_language = implode( $options );

    $shortcode_attributes = shortcode_atts( array(
        'language' => $installation_language,
    ), $attributes);

    global $language;
    $language = $shortcode_attributes['language'];

    $shortcode_content = '';

    // call form and content functions
    $shortcode_content .= display_selection_form( $language );
    $shortcode_content .= display_content( $language );

    // enqueue style and script
    wp_enqueue_script( 'apb-js' );
    wp_enqueue_style( 'bible-navigation' );
    wp_enqueue_style( 'tinos' );

    return $shortcode_content;
}
add_shortcode( 'apb_display', 'apb_shortcode' );

function display_selection_form() {
    global $wpdb;
    global $apb_TOC_table_name;
    global $query_book;
    global $query_chapter;
    global $language;

    // get book names and chapter counts
    $apb_books = $wpdb->get_results( "SELECT `book_id`, `localized_book_name`, `chapter_count` FROM $apb_TOC_table_name WHERE `language` LIKE '$language';" );

    ob_start();

    // start form
    echo '<form name="bible-navigation" class="bible-navigation" method="post">';

    // print JS with number of chapters
    $chapter_count = '
    var thisChapter = ' . $query_chapter . ',
        chapterCount = [';
    foreach ( $apb_books as $apb_book ) {
        $chapter_count .= $apb_book->chapter_count . ',';
    }
    $chapter_count = rtrim( $chapter_count, ',' ) . ']';
    wp_add_inline_script( 'apb-js', $chapter_count, 'before' );

    // print book menu
    echo '<select id="book" name="book">';
    foreach ( $apb_books as $apb_book ) {
        echo '<option value="' . $apb_book->book_id . '"';
        if ( $apb_book->book_id == $query_book ) { echo ' selected="selected"'; }
        echo '>' . $apb_book->localized_book_name . '</option>' . "\n";
    }
    echo '</select>';

    // print chapter menu
    echo '<select id="chapter" name="chapter">';
    for ( $i = 1; $i <= $apb_books[( $query_book - 1 )]->chapter_count; $i++ ) {
        echo '<option value="' . $i . '"';
        if ( $i == $query_chapter ) { echo ' selected="selected"'; }
        echo '>' . $i . '</option>' . "\n";
    }
    echo '</select>';

    // print hidden info and submit button
    echo '<input type="hidden" id="language" name="language" value="' . $language . '"/>';
    echo '<input type="submit" class="button button-primary" value="&rarr;">';
    echo '</form>';

    wp_enqueue_script( 'chosen' );
    wp_enqueue_style( 'chosen' );
    wp_add_inline_script( 'chosen', 'jQuery(".bible-navigation select").chosen();' );

    return ob_get_clean();
}

function display_content() {
    global $wpdb;
    global $apb_text_table_name;
    global $query_book;
    global $query_chapter;
    global $language;

    // query database
    $content = $wpdb->get_results( $wpdb->prepare(
        "SELECT * FROM $apb_text_table_name WHERE book_id = %d AND chapter_num = %d AND language LIKE %s",
        $query_book,
        $query_chapter,
        $language
    ) );

    // TODO: add chapter summary support

    ob_start();

    echo '<section class="bible-content">';

    // print content
    if ( $content ) {
        echo '<ol>';
        foreach ( $content as $verse ) {
            $text = $verse->verse_text;

            if ( $verse->verse_num === '0' ) {
                echo '<br/><span class="unnumbered">' . $text . '</span><br/>';
            } else {
                echo '<li>' . $verse->verse_text . '</li>';
            }
        }
        echo '</ol>';
        display_selection_form();

        if ( defined( 'DOING_AJAX' ) ) {
            die();
        }
    }

    echo '</section>';

    return ob_get_clean();
}

// handle ajax calls
add_action( "wp_ajax_bible_navigate", "display_content" );
add_action( "wp_ajax_nopriv_bible_navigate", "display_content" );
