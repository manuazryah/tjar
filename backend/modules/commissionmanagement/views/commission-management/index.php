<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\ProductVendor;
use common\models\Products;
use yii\helpers\Url;
use common\models\Vendors;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommissionManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Commission Managements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commission-management-index">
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


                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



                    <?php //  Html::a('<i class="fa-th-list"></i><span> Create Commission Management</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>

                    <div class="table-responsive" style="border: none;margin-top: 10px;">
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
//                                'id',
                                [
                                    'attribute' => 'product_id',
                                    'format' => 'raw',
                                    'value' => function($data) {
                                        $prdctvendor = ProductVendor::findOne($data->product_id);
                                        $name = Products::findOne($prdctvendor->product_id)->product_name;
                                        return Html::tag('button', Html::encode(substr($name, 0, 29)), ['value' => Url::to(['product-view', 'id' => $data->product_id]), 'title' => $name, 'class' => 'username color modalButton edit-btn']);
                                    }
                                ],
                                [
                                    'attribute' => 'vendor_id',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if (isset($data->vendor_id)) {
                                            return \yii\helpers\Html::a(Vendors::findOne($data->vendor_id)->first_name, ['/vendors/vendors/view', 'id' => $data->vendor_id], ['target' => '_blank']);
                                        } else {
                                            return '';
                                        }
                                    },
                                ],
                                [
                                    'attribute' => 'order_id',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if (isset($data->order_id)) {
                                            return \yii\helpers\Html::a($data->order_id, ['/orders/order-master/view', 'id' => $data->order_id], ['target' => '_blank']);
                                        } else {
                                            return '';
                                        }
                                    },
                                ],
                                'product_price',
                                // 'offer_price',
                                'commission',
                            // 'status',
                            // 'DOC',
                            // 'DOU',
//                                ['class' => 'yii\grid\ActionColumn'],
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
    });
</script>

