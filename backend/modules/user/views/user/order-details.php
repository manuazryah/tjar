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
                                    'format' => 'raw',
                                    'value' => function($data) {
                                        $prdctvendor = ProductVendor::findOne($data->product_id);
                                        $name = Products::findOne($prdctvendor->product_id)->product_name;
//                                        return $name;
                                        return  Html::button(substr($name, 0, 29).'..', ['value' => Url::to(['/vendors/product-vendor/product-view', 'id' => $prdctvendor->product_id]), 'class' => 'modalButton edit-btn']);
//                                        return Html::tag('p', Html::encode(substr($name, 0, 29)), ['title' => $name, 'class' => 'username color'],['value' => Url::to(['/vendors/product-vendor/product-view', 'id' => $prdctvendor->product_id]), 'class' => 'modalButton edit-btn']);
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
                                            return 'Order Placed';
                                        } elseif ($data->status == 2) {
                                            return 'Order Dispatched';
                                        } elseif ($data->status == 3) {
                                            return 'Order Delivered';
                                        }
                                    },
                                ],
                                'delivered_date',
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

