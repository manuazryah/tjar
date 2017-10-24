<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\AdminPost;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminUsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<style>
    .search .search-dropdown {
        list-style: none;
        padding: 0px;
        position: absolute;
        width: 100%;
        height: auto;
        margin: 0 auto;
        background: white;
        top: 35px;
        z-index: 10;
        border: 1px solid #dfdfdf;
        border-top: 0px;
        max-height: 250px;
        overflow-y: auto;
    }
</style>
<div style="text-align: center;padding-top: 50px;">
    <h2>What do you want to list?</h2>
    <?= Html::beginForm(['/product/index'], 'get', ['id' => 'serach-formm', 'style' => '']) ?>
    <div class="col-md-12 hidden-sm hidden-xs left">
        <div class="col-md-12 col-sm-12 col-xs-12 search">
            <div class="input-group">
                <input type="text" class="form-control SearchBar search-keyword" placeholder="Enter your search keyword" style="padding: 20px 20px;" name="keyword" autocomplete="off" required="" value="<?php
                if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
                    echo $_GET['keyword'];
                }
                ?>">
                <div class="search-keyword-dropdown"></div>
                <span class="input-group-btn">
                    <?= Html::submitButton('<span class="SearchIcon" >Search Listing</i></span>', ['class' => 'btn btn-defaul SearchButton', 'name' => 'search_keyword-send', 'style' => 'color:white;background: #0d70bf;padding: 10px 15px;']) ?>

                </span>
            </div>
        </div>
    </div>
    <?= Html::endForm() ?>
</div>
<script>
    $(document).ready(function () {
        /************ Serach ****************/
        $('.search-keyword').on('keyup', function (e) {
            if ($(this).val()[0] === " ") {


            } else {

                if (e.keyCode != 40 && e.keyCode != 38 && e.keyCode != 27) {
                    $.ajax({
                        url: homeUrl + '/site/search-keyword',
                        type: "POST",
                        data: {keyword: $(this).val()},
                        success: function (data) {
                            $('.search-keyword-dropdown').html(data);
                        }
                    });
                }
            }
        });

        /********* selected li value to textbox **********/
        $(document).on('click', '.search-dropdown li', function () {
            $('.search-dropdown').hide();
            $('.search-keyword').val($(this).attr('id'));
            $('form#serach-formm').submit();
        });

        /********************li navigation keys ***************/
        $('.search-keyword').on('keydown', function (e) {

            if (e.keyCode == 40) { //down

                var selected = $(".search-selected");
                $('.search-dropdown li').removeClass('search-selected');
                if (selected.next().length == 0) {
                    selected.siblings().first().addClass('search-selected');
                } else {
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

                var value = $('.search-selected').attr('id');
                $('.search-dropdown').hide();
                $('.search-keyword').val(value);
                $('form#serach-formm').submit();
                e.preventDefault();
            }

            $(".search-dropdown").scrollTop(0);//set to top
            $(".search-dropdown").scrollTop($('.search-selected:first').offset().top - $(".search-dropdown").height())

        });
    });
</script>