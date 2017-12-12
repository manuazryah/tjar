<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\User;
use common\models\Products;
use common\models\ProductVendor;

/* @var $this yii\web\View */

$this->title = 'Order Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .tab-content{
        background: #f9f9f9 !important;
    }
    .nav.nav-tabs>li>a {
        background-color: #f9f9f9;
    }
    .nav.nav-tabs>li {
        background: #f9f9f9;
    }
    .nav.nav-tabs>li.active>a {
        background-color: #f9f9f9 !important;
    }
    .nav.nav-tabs.nav-tabs-justified, .nav-tabs-justified .nav.nav-tabs {
        background: #f9f9f9;
    }
    .nav.nav-tabs>li>a:hover {
        background-color: #f9f9f9;
    }
    .nav-tabs {
        border-bottom: 1px solid #f9f9f9 !important;
    }
    .hidden-xs{
        padding-left: 5px;
    }
    /*    .color{
            color: #373e4a;
        }*/
</style>
<div class="products-index">
    <?php
    yii\bootstrap\Modal::begin([
        'headerOptions' => ['id' => 'modalHeader'],
        'id' => 'modal',
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
    ]);
    ?>
    <div id='modalContent'></div>;
    <?php yii\bootstrap\Modal::end(); ?>

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <div class="" style="border: none">

                        <div class="row">

                            <div class="col-md-12">
                                <?php yii\widgets\Pjax::begin(['id' => 'order-manage']); ?>

                                <?php
                                $filter = ['0' => 'Pending', '1' => 'Placed', '2' => 'Dispatched', '3' => 'Delivered'];
//
                                ?>
                                <div class="tab-content">
                                    <button class="btn btn-white" id="search-option" style="float: right;">
                                        <i class="linecons-search"></i>
                                        <span>Search</span>
                                    </button>
                                    <div class="tab-pane active" id="">
                                        <?=
                                        ListView::widget([
                                            'dataProvider' => $dataProvider,
                                            'options' => [
                                                'tag' => 'div',
                                                'class' => 'list-wrapper',
                                                'id' => 'list-wrapper',
                                            ],
                                            'itemView' => function ($data) {
                                                return $this->render('_list_item', ['data' => $data]);

                                                // or just do some echo
                                                // return $model->title . ' posted by ' . $model->author;
                                            },
                                        ]);
                                        ?>



                                    </div>

                                </div>
                                <?php yii\widgets\Pjax::end(); ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-1">
    <div class="modal-dialog">
        <div class="modal-content" style="padding: 25px 30px;">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <textarea rows="3" cols="70" placeholder="Add Your Comment" class="comment_box"></textarea>
            </div>
            <span class="error"></span>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info comment_submit">Add Comment</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
        $(document).on('change', '.admin_status_field', function (e) {
            var change_id = $(this).attr('id').match(/\d+/);
            var order_status = $(this).val();
            $.ajax({
                url: homeUrl + 'orders/order/change-order-status',
                type: "post",
                data: {status: order_status, ids: change_id},
                success: function (data) {
                    alert('Status Changed Sucessfully');
                    $.pjax.reload({container: '#order-manage'});
                }, error: function () {
                }
            });
        });
        $('body').on('click', '.order_comment', function () {
            $('.comment_box').val('');
            $('.error').html('');
            var id = $(this).attr('id');
            $('#modal-1').modal('show');
            $('.comment_box').attr("id", id);
        });
        $('body').on('click', '.comment_submit', function () {
            $('.error').html('');
            var comment = $('.comment_box').val();
            var id = $('.comment_box').attr('id');
            if (comment !== '') {
                $.ajax({
                    url: homeUrl + 'orders/order/order-history-comment',
                    type: "post",
                    data: {comment: comment, id: id},
                    success: function (data) {
                        var $data = JSON.parse(data);
                        if ($data.msg === "success") {
                            alert('Comment Successfully Added');
                            $('#modal-1').modal('hide');
//
                        } else {
                            alert('Sorry, Internal error');
//                            $('#prdct_main_category').submit();
                        }
                    }, error: function () {

                    }
                });

            } else {
                $('.error').html('Cannot be Null');
            }
        });
    });
</script>

