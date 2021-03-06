<?php

use yii\helpers\Html;
use yii\grid\GridView;
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
                                                                <ul class="nav nav-tabs">
                                                                        <li class="<?= $order_status == '' ? 'active' : '' ?>">
                                                                                <?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">All Orders</span>', ['index'], ['class' => '']) ?>
                                                                        </li>
                                                                        <li class="<?= $order_status == 1 ? 'active' : '' ?>">
                                                                                <?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">Awaiting Action</span>', ['index', 'order_status' => 1], ['class' => '']) ?>
                                                                        </li>
                                                                        <li class="<?= $order_status == 2 ? 'active' : '' ?>">
                                                                                <?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">Placed</span>', ['index', 'order_status' => 2], ['class' => '']) ?>
                                                                        </li>
                                                                        <li class="<?= $order_status == 3 ? 'active' : '' ?>">
                                                                                <?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">Dispatched</span>', ['index', 'order_status' => 3], ['class' => '']) ?>
                                                                        </li>
                                                                        <li class="<?= $order_status == 4 ? 'active' : '' ?>">
                                                                                <?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">Delivered</span>', ['index', 'order_status' => 4], ['class' => '']) ?>
                                                                        </li>
                                                                </ul>
                                                                <?php
                                                                $filter = ['0' => 'Pending', '1' => 'Placed', '2' => 'Dispatched', '3' => 'Delivered'];
//
                                                                ?>
                                                                <div class="tab-content">
                                                                        <button class="btn btn-white" id="search-option" style="float: right;">
                                                                                <i class="linecons-search"></i>
                                                                                <span>Search</span>
                                                                        </button>

                                                                        <?php
                                                                        if ($search_status == 1) {
                                                                                ?>
                                                                                <script>
                                                                                        Select();
                                                                                </script>
                                                                                <?php
                                                                        }
                                                                        ?>
                                                                        <div class="tab-pane active" id="">

                                                                                <?=
                                                                                GridView::widget([
                                                                                    'dataProvider' => $dataProvider,
                                                                                    'filterModel' => $searchModel,
                                                                                    'columns' => [
                                                                                            ['class' => 'yii\grid\SerialColumn'],
                                                                                        'order_id',
                                                                                            [
                                                                                            'attribute' => 'product_id',
                                                                                            'format' => 'raw',
                                                                                            'value' => function($data) {
                                                                                                    $prod_details = ProductVendor::findOne($data->product_id);
                                                                                                    $name = Products::findOne($prod_details->product_id)->product_name;
                                                                                                    return Html::tag('button', Html::encode(substr($name, 0, 29)), ['value' => Url::to(['/product/product/product-view', 'id' => $prod_details->product_id]), 'title' => $name, 'class' => 'username color modalButton edit-btn']);
//
                                                                                            },
                                                                                            'filter' => Html::activeDropDownList($searchModel, 'product_id', ArrayHelper::map(ProductVendor::find()->where(['vendor_id' => Yii::$app->user->identity->id, 'admin_status' => 2, 'full_fill' => 0])->all(), 'id', 'productname'), ['class' => 'form-control', 'id' => 'product_name', 'prompt' => '']),
                                                                                        ],
                                                                                        'quantity',
//
                                                                                        [
                                                                                            'attribute' => 'amount',
                                                                                            'value' => function($model) {
                                                                                                    return sprintf('%0.2f', $model->amount);
                                                                                            },
                                                                                        ],
//
                                                                                        [
                                                                                            'attribute' => 'status',
                                                                                            'format' => 'raw',
                                                                                            'filter' => $filter,
                                                                                            'value' => function ($data)use ($filter) {
                                                                                                    return \yii\helpers\Html::dropDownList('status', null, $filter, ['options' => [$data->status => ['Selected' => 'selected']], 'class' => 'form-control admin_status_field', 'id' => 'order_admin_status-' . $data->id,]);
                                                                                            },
                                                                                        ],
                                                                                        'delivered_date',
                                                                                            [
                                                                                            'class' => 'yii\grid\ActionColumn',
                                                                                            'header' => 'Actions',
                                                                                            'template' => '{print}{comment}{track}',
                                                                                            'buttons' => [
                                                                                                'print' => function ($url, $model) {
                                                                                                        return Html::a('<span><i class="fa fa-print" aria-hidden="true"></i></span>', $url, [
                                                                                                                    'title' => Yii::t('app', 'print'),
                                                                                                                    'class' => '',
                                                                                                                    'target' => '_blank',
                                                                                                        ]);
                                                                                                },
                                                                                                'comment' => function ($url, $model) {
                                                                                                        if ($model->status != '0' && $model->status != '3') {
                                                                                                                return Html::a('<span><i class="fa-file-text-o"></i></span>', '', [
                                                                                                                            'title' => 'Comment',
                                                                                                                            'class' => 'order_comment',
                                                                                                                            'id' => $model->id,
                                                                                                                ]);
                                                                                                        }
                                                                                                },
                                                                                                'track' => function ($url, $model) {

                                                                                                        return Html::button('<i class="fa fa-truck"></i>', ['value' => Url::to(['track', 'id' => $model->id]), 'class' => 'modalButton edit-btn']);
                                                                                                },
                                                                                            ],
                                                                                            'urlCreator' => function ($action, $model) {
                                                                                                    if ($action === 'print') {
                                                                                                            $url = Url::to(['print', 'id' => $model->order_id]);
                                                                                                            return $url;
                                                                                                    } else {
                                                                                                            $url = Url::to(['print', 'id' => $model->order_id]);
                                                                                                            return $url;
                                                                                                    }
                                                                                            }
                                                                                        ],
                                                                                    ],
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

                Select();
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

        function Select() {

                $("#product_name").select2({
                        placeholder: '',
                        allowClear: true
                }).on('select2-open', function ()
                {
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                });

        }
</script>

