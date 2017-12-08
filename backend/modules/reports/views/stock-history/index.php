<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Products;
use common\models\ProductVendor;
use common\models\Vendors;
use yii\helpers\Url;

//use common\components\ModalViewWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StockHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-history-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">

                    <div class="row" style="margin-left: 0px;margin-bottom: 20px;">
                        <div class="col-md-12" style="padding: 0px;">

                            <?= $this->render('_search', ['model' => $searchModel, 'from' => $from, 'to' => $to]) ?>

                        </div>

                    </div>
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
//                                'products_id',
//                                'productvendor_id',
                                [
                                    'attribute' => 'productvendor_id',
                                    'label' => 'Product Name',
                                    'format' => 'raw',
                                    'filter' => ArrayHelper::map(Products::find()->all(), 'id', 'product_name'),
                                    'value' => function ($data) {
                                        $prdctvendor = ProductVendor::findOne($data->productvendor_id);
                                        $name = Products::findOne($prdctvendor->product_id)->product_name;
                                        return Html::tag('button', Html::encode(substr($name, 0, 29)), ['value' => Url::to(['/orders/order-master/product-view', 'id' => $data->productvendor_id]), 'title' => $name, 'class' => 'username color modalButton edit-btn']);
                                    },
                                ],
//                                'user_id',
                                [
                                    'attribute' => 'user_id',
                                    'label' => 'User',
                                    'format' => 'raw',
//                                    'filter' => ArrayHelper::map(\common\models\Vendors::find()->all(), 'id', 'first_name','last_name'),
                                    'value' => function ($data) {
                                        if ($data->usertype == '2') {
                                            $name = Vendors::findOne($data->user_id);
                                            return $name->first_name . ' ' . $name->last_name;
                                        } elseif ($data->usertype == '1') {
                                            return 'Admin';
                                        } else {
                                            return 'User';
                                        }
                                    },
                                ],
//                                'usertype',
                                'qty',
                                'total_stock',
//                                'purpose',
                                [
                                    'attribute' => 'purpose',
                                    'label' => 'Purpose',
                                    'filter' => ['1' => 'Stock Added', '2' => 'Stock Changed', '3' => 'Stock Saled', '4' => 'Stock Returned'],
                                    'value' => function ($data) {
                                        if ($data->purpose == '1')
                                            $purpose = 'Stock Added';
                                        if ($data->purpose == '2')
                                            $purpose = 'Stock Chaged';
                                        if ($data->purpose == '3')
                                            $purpose = 'Stock Saled';
                                        if ($data->purpose == '4')
                                            $purpose = 'Stock Returned';
                                        return $purpose;
                                    },
                                ],
                                 'DOC',
//                                [
//                                    'class' => 'yii\grid\ActionColumn',
//                                    'header' => 'Actions',
//                                    'template' => '{track}',
//                                    'buttons' => [
//                                        'track' => function ($url, $model) {
//
//                                            return Html::button('<i class="fa fa-truck"></i>', ['value' => Url::to(['track', 'id' => $model->id]), 'class' => 'modalButton edit-btn']);
//                                        },
//                                    ],
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
    });
</script>

