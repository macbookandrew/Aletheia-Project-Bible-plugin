jQuery(document).ready(function() {

    jQuery('.bible-navigation').on('submit', function(event) {
        event.preventDefault();
        var book = jQuery('select#book').val();
        var chapter = jQuery('select#chapter').val();
        jQuery.ajax({
            type: 'post',
            dataType: 'html',
            url: apbAjax.ajaxurl,
            data: {
                action: 'bible_navigate',
                book: book,
                chapter: chapter,
            },
            success: function(response) {
                console.log('success!');
                jQuery('.bible-content').html(response);
            },
            error: function(response) {
                console.log('error');
                console.log(response);
            },
        });
    });
});
