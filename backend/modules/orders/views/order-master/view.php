<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Products;
use common\models\ProductVendor;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-master-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">


                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



                    <?= Html::a('<i class="fa-th-list"></i><span> Manage Order </span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <div class="table-responsive" style="border: none">
                        <button class="btn btn-white" id="search-option" style="float: right;">
                            <i class="linecons-search"></i>
                            <span>Search</span>
                        </button>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'order_id',
                                [
                                    'attribute' => 'product_id',
//                                    'filter' => ArrayHelper::map(Product::find()->all(), 'id', 'product_name'),
                                    'value' => function($data) {
                                        $prdctvendor = ProductVendor::findOne($data->product_id);
                                        $name = Products::findOne($prdctvendor->product_id)->product_name;
//                                        $image = '<img src="' . Yii::$app->homeUrl . 'uploads/product/' . $product_details->id . '/profile/' . $product_details->canonical_name . '_thumb.' . $product_details->profile . '" width="94px" height="93px"/>';
                                        return $name;
//                                        return Product::findOne($data->product_id)->product_name;
                                    }
                                ],
                                'quantity',
                                'amount',
                                'sub_total',
//
                                [
                                    'attribute' => 'status',
                                    'format' => 'raw',
                                    'filter' => ['0' => 'Pending', '1' => 'Confirm', '2' => 'Canceled'],
                                    'value' => function ($data) {
                                        if ($data->status == 0) {
                                            return 'Pending';
                                        } elseif ($data->status == 1) {
                                            return 'Confirm';
                                        } elseif ($data->status == 2) {
                                            return 'Canceled';
                                        }
//                                        $product = \common\models\ProductVendor::findOne($data->product_id);
//                                        if ($product->full_fill == 1) {
//                                            return \yii\helpers\Html::dropDownList('status', null, ['0' => 'Not Delivered', '1' => 'Delivered'], ['options' => [$data->status => ['Selected' => 'selected']], 'class' => 'form-control admin_status_field', 'id' => 'order_admin_status-' . $data->id,]);
//                                        } else {
//                                            if ($data->status == 0) {
//                                                return 'Not Delivered';
//                                            } else {
//                                                return 'Delivered';
//                                            }
//                                        }
                                    },
                                ],
                                'delivered_date',
//                                [
//                                    'class' => 'yii\grid\ActionColumn',
////                                    'header' => 'Actions',
//                                    'template' => '{view-more}',
//                                    'buttons' => [
//                                        'view-more' => function ($url, $model) {
//                                            if ($model->item_type == 1) {
//                                                return Html::a('<span><i class="fa fa-arrow-right" aria-hidden="true"></i></span>', $url, [
//                                                            'title' => Yii::t('app', 'view more'),
//                                                            'class' => '',
//                                                ]);
//                                            }
//                                        },
//                                    ],
//                                    'urlCreator' => function ($action, $model) {
//                                        if ($action === 'view-more') {
//                                            $url = Url::to(['view-more', 'id' => $model->id]);
//                                            return $url;
//                                        }
//                                    }
//                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
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
        $('.admin_status_field').on('change', function () {
            var change_id = $(this).attr('id').match(/\d+/);
            var vendor_status = $(this).val();
            $.ajax({
                url: homeUrl + 'orders/order-master/change-vendor-status',
                type: "post",
                data: {status: vendor_status, id: change_id},
                success: function (data) {
                    alert('Status Changed Sucessfully');
                }, error: function () {
                }
            });
        });
    });
</script>

