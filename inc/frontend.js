(function($){
    $(document).ready(function() {

        // handle form via Ajax
        $('body').on('submit', 'form.bible-navigation', function(event) {
            event.preventDefault();

            var book = $(this).children('#book').val(),
                chapter = $(this).children('#chapter').val(),
                language = $(this).children('#language').val();

            $.ajax({
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
                    $('.bible-content').fadeOut(function(){$('.bible-content').html(response).fadeIn()});
                    // TODO: fade out before submission and fade in after content comes back
                    $('html, body').animate({
                        scrollTop: ($('.bible-content').offset().top)
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
        $('select#book').on('change',function(){
            var thisBook=$('select#book').val(),
                thisBookCount=chapterCount[(thisBook-1)];

            $('select#chapter').empty();

            for(i=1; i<=thisBookCount; i++){
                $('select#chapter').append('<option value="' + i + '">' + i + '</option>');
            }
        });
    });
})(jQuery);
