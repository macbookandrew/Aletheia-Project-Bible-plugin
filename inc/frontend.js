jQuery(document).ready(function() {

    jQuery('.bible-navigation').on('submit', function(event) {
        event.preventDefault();
        var book = jQuery('select#book').val();
        var chapter = jQuery('select#chapter').val();
        jQuery.ajax({
            type: 'post',
            dataType: 'json',
            url: apbAjax.ajaxurl,
            data: {
                action: 'bible-navigate',
                book: book,
                chapter: chapter,
            },
            success: function(response) {
                jQuery('.bible-content').html(response);
            }
        });
    });
});
