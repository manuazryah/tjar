<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;
?>
<style>
    .view_detail{
        opacity: 0;
        position: absolute;
        bottom: 180px;
        left: 46px;
        transition: all 5ms;
        z-index: 2;
        background: #0070CC;
        color: white;
        border: #0070CC;
        padding: 8px 10px;
        margin-left: 31px;
    }
    .album-image:hover .view_detail{
        opacity: 2;
        color: white;
    }
</style>
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 product-div">
    <div class="album-image">
        <a href="#" class="thumb" data-action="edit">
            <img src="<?= yii::$app->homeUrl; ?>images/samsung-galaxy.jpg" class="img-responsive">
        </a>
        <div>
            <?= Html::a($model->product_name, ['/product/product/index'], ['class' => '']) ?><br/>
            <?= Html::a($model->canonical_name, ['/product/product/index'], ['class' => '']) ?>
            
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sell-btn-div">
            <label  value ='<?= Url::to(['details', 'id' => $model->id]) ?>' class="modalButton view_detail "><i class="fa fa-eye">View Detail</i></label>
            <?php
            Modal::begin([
                'header' => '',
                'id' => 'modal',
                'size' => 'modal-lg',
            ]);
            echo "<div id = 'modalContent'></div>";
            Modal::end();
            ?>
            <?= Html::a('<span> Sell This Product</span>', ['/product/product/sell-product', 'id' => $model->id], ['class' => 'sell-btn']) ?>
        </div>
    </div>
</div>