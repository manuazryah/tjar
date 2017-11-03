$(document).ready(function () {

        $(document).on('submit', '#add-review-form', function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                        type: 'POST',
                        url: homeUrl + 'products/add-review',
                        data: data,
                        success: function (data) {
                                $('#addreview').css({'display': 'none'});
                        }
                });
        });

});