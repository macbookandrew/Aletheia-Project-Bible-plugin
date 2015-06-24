jQuery(document).ready(function() {

    // handle form via Ajax
    jQuery('.bible-navigation').on('submit', function(event) {
        event.preventDefault();
        var book = jQuery('select#book').val();
        var chapter = jQuery('select#chapter').val();
        var language = jQuery('input#language').val();
        jQuery.ajax({
            type: 'post',
            dataType: 'html',
            url: apbAjax.ajaxurl,
            data: {
                action: 'bible_navigate',
                book: book,
                chapter: chapter,
                language: language,
            },
            success: function(response) {
                console.log('success!');
                jQuery('.bible-content').fadeOut(function(){jQuery('.bible-content').html(response).fadeIn()});
            },
            error: function(response) {
                console.log('error');
                console.log(response);
            },
        });
    });

    // update chapter menu on book menu change
    jQuery('select#book').on('change',function(){
        var thisBook=jQuery('select#book').val();
        var thisBookCount=chapterCount[(thisBook-1)];
        jQuery('select#chapter').empty();
        for(i=1; i<=thisBookCount; i++){
            jQuery('select#chapter').append('<option value="' + i + '">' + i + '</option>');
        }
    });
});
