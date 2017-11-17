$(window).on('load', function () {
    var NoLi = $('.listOfassignment li').length;
    console.log(NoLi);
    no = 0;

    showNoLi = 12;
    
    delay = 5;

    start = 0;

    end = showNoLi;

    var deviedLi = NoLi / showNoLi;

    var arounVal = Math.ceil(deviedLi);

    var counter;

    for (counter = 1; counter <= arounVal; counter++) {

        $('<li><a href="javascript:void(0)"></a></li>').appendTo('.pagenation')
    }

    $('.pagenation li').eq(0).addClass('active');

    $('.listOfassignment li').slice(start, end).addClass('active');

    $('.prv').prop('disabled', true);

    function myfunction(selectedShow) {

        return function () {

            if (selectedShow === 'nextShow') {

                no++;

                $('.pagenation li').removeClass('active');

                $('.pagenation li').eq(no).addClass('active');


                $('.listOfassignment li').removeClass('active');

                start = showNoLi * no;

                end = showNoLi * no + showNoLi;

                $('.listOfassignment li').slice(start, end).addClass('active');

                $('.prv').prop('disabled', false);

                if (no * showNoLi + showNoLi >= NoLi) {

                    $('.next').prop('disabled', true);

                }
            }
            if (selectedShow === 'pinterclick') {

                $('.pagenation li').removeClass('active');

                var thisnumber = $(this).addClass('active').index();

                no = thisnumber;

                start = showNoLi * no;

                end = showNoLi * no + showNoLi;

                $('.listOfassignment li').removeClass('active');

                $('.listOfassignment li').slice(start, end).addClass('active');

                if (no > 0) {

                    $('.prv').prop('disabled', false);
                } else {
                    $('.prv').prop('disabled', true);
                }

                if (no * showNoLi + showNoLi >= NoLi) {

                    $('.next').prop('disabled', true);

                } else {
                    $('.next').prop('disabled', false);
                }

            } else if (selectedShow === 'prevSelecte') {

                no--;

                $('.pagenation li').removeClass('active');

                $('.pagenation li').eq(no).addClass('active');

                $('.listOfassignment li').removeClass('active');

                start = showNoLi * no;

                end = showNoLi * no + showNoLi;

                $('.listOfassignment li').slice(start, end).addClass('active');

                $('.next').prop('disabled', false);

                if (no === 0) {
                    $('.prv').prop('disabled', true);
                }
            }
        }
    }

    $('.next').on('click', myfunction('nextShow'));

    $('.prv').on('click', myfunction('prevSelecte'));

    $('.pagenation').on('click', 'li', myfunction('pinterclick'));

});