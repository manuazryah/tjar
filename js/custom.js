$(document).ready(function () {
        $('.language-choose').on('click', function (e) {
                var language = $(this).attr('id');
                $.ajax({
                        type: 'POST',
                        cache: false,
                        data: {language: language},
                        url: homeUrl + 'ajax/ss',
                        success: function (data) {
                                location.reload();
                        }
                });
        });
});