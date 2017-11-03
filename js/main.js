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

});