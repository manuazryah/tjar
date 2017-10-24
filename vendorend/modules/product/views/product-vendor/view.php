<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductVendor */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Product Vendors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-vendor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'product_id',
            'vendor_id',
            'qty',
            'price',
            'sku',
            'offer_note:ntext',
            'handling_time:datetime',
            'pick_up_location',
            'free_shipping',
            'courier_handover',
            'conditions:ntext',
            'offer_price',
            'full_fill',
            'field1',
            'field2',
            'field3',
            'status',
            'CB',
            'UB',
            'DOC',
            'DOU',
        ],
    ]) ?>

</div>
