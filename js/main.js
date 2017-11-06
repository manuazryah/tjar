$(document).ready(function () {
        $('.review-success').hide();
        $(document).on('submit', '#add-review-form', function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                        type: 'POST',
                        url: homeUrl + 'products/add-review',
                        data: data,
                        success: function (data) {
                                $('#addreview').css({'display': 'none'});
                                $('.review-success').show();
                                $('.review-success').delay(4000).fadeOut();
                        }
                });
        });


        $('.language-choose').on('click', function () {
                var language = $(this).attr('id');
                $.ajax({
                        type: 'POST',
                        url: homeUrl + 'ajax/language',
                        data: {language: language},
                        success: function (data) {
                                location.reload();
                        }
                });
        });

});