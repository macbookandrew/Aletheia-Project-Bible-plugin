jQuery(document).ready(function() {

    // handle form via Ajax
    jQuery('body').on('submit', 'form.bible-navigation', function(event) {
        event.preventDefault();
        var book = jQuery(this).children('#book').val();
        var chapter = jQuery(this).children('#chapter').val();
        var language = jQuery(this).children('#language').val();
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
                jQuery('html, body').animate({
                    scrollTop: (jQuery('.bible-content').offset().top)
                },500);
                // TODO: add history.pushState and URL support
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
