<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductVendorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Vendors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-vendor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Vendor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'vendor_id',
            'qty',
            'price',
            //'sku',
            //'offer_note:ntext',
            //'handling_time:datetime',
            //'pick_up_location',
            //'free_shipping',
            //'courier_handover',
            //'conditions:ntext',
            //'offer_price',
            //'full_fill',
            //'field1',
            //'field2',
            //'field3',
            //'status',
            //'CB',
            //'UB',
            //'DOC',
            //'DOU',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
