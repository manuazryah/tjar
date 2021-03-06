<?php

use yii\helpers\Html;
?>

<?php if ($type == 1) { ?>

        <?= Html::beginForm(['/product/product/product-search'], 'get', ['id' => 'serach-formm']) ?>
        <div class="col-md-12 col-sm-12 col-xs-12 search" id='header_search'>
                <div class="input-group">
                        <input type="text" class="form-control SearchBar search-keyword" placeholder="Enter your search keyword" style="padding: 20px 20px;" name="keyword" autocomplete="off" required="" >
                        <div class="search-keyword-dropdown"></div>
                        <span class="input-group-btn">
                                <?= Html::submitButton('<span class="SearchIcon" >Search Listing</i></span>', ['class' => 'btn btn-defaul SearchButton', 'name' => 'search_keyword-send', 'style' => 'color:white;background: #0d70bf;padding: 10px 15px;']) ?>

                        </span>
                </div>
        </div>
        <?= Html::endForm() ?>

<?php } else {
        ?>
        <?= Html::beginForm(['/products/product-search'], 'get', ['id' => 'serach-formm']) ?>
        <div class="col-md-8 col-sm-8 col-xs-8 search" id="header_search">
                <input type="search" name="keyword" placeholder="Search for Products, Brands & More" class="search-keyword" autocomplete="off"/>
                <div class="search-keyword-dropdown"></div>
                <button class="search-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
        </div>
        <?= Html::endForm() ?>
<?php } ?>












<script>
        $(document).ready(function () {

                /* * ********** Serach *************** */
                $('.search-keyword').on('keyup', function (e) {
                        var type = '<?= $type ?>';
                        if ($(this).val()[0] === " ") {

                        } else {
                                if (type == 1) {
                                        var urlval = 'product/product/search-keyword';
                                } else {
                                        var urlval = 'products/search-keyword';
                                }

                                if (e.keyCode != 40 && e.keyCode != 38 && e.keyCode != 27) {
                                        $.ajax({
                                                url: homeUrl + urlval,
                                                type: "POST",
                                                data: {keyword: $(this).val()},
                                                success: function (data) {
                                                        $('.search-keyword-dropdown').html(data);
                                                }
                                        });
                                }
                        }
                });

                /* * ******* selected li on mouseover ********* */
                $(document).on('mouseover', '.search-dropdown li', function () {
                        $(this).addClass('search-selected').siblings().removeClass('search-selected');
                });

                /* * ******************li navigation keys ************** */
                $('.search-keyword').on('keydown', function (e) {

                        if (e.keyCode == 40) { //down

                                var selected = $(".search-selected");
                                $('.search-dropdown li').removeClass('search-selected');
                                if (selected.next().length == 0) {
                                        selected.siblings().first().addClass('search-selected');
                                } else {
                                        // alert('else');
                                        selected.next().addClass('search-selected');
                                }
                        } else if (e.keyCode == 38) { //up

                                var selected = $(".search-selected");
                                $('.search-dropdown li').removeClass('search-selected');
                                if (selected.prev().length == 0) {
                                        selected.siblings().last().addClass('search-selected');
                                } else {
                                        selected.prev().addClass('search-selected');
                                }
                        } else if (e.keyCode == 27) { //escape

                                $('.search-dropdown').hide();
                                $('.search-keyword').val('');

                        } else if (e.keyCode == 13) { //enter
//
                                if ($('.select').hasClass('search-selected')) {
                                        e.preventDefault();
                                        window.location.replace($('.search-selected a').attr('href'));

                                } else {
                                        $('form#serach-formm').submit();
                                }

                        }

                        $(".search-dropdown").scrollTop(0); //set to top
                        $(".search-dropdown").scrollTop($('.search-selected:first').offset().top - $(".search-dropdown").height());

                });
        });
</script>


