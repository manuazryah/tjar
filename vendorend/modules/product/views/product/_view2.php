<?php

use yii\helpers\Html;
?>
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 product-div">
    <div class="album-image">
        <a href="#" class="thumb" data-action="edit">
            <img src="<?= yii::$app->homeUrl; ?>images/samsung-galaxy.jpg" class="img-responsive">
        </a>
        <?= Html::a($model->product_name, ['/product/product/index'], ['class' => '']) ?><br/>
        <?= Html::a($model->canonical_name, ['/product/product/index'], ['class' => '']) ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sell-btn-div">
            <?= Html::a('<span> Sell This Product</span>', ['/product/product/sell-product', 'id' => $model->id], ['class' => 'sell-btn']) ?>
        </div>
    </div>
</div>