<?php

use yii\helpers\Html;
?>
<div class="col-md-3 col-sm-4 col-xs-6">
    <div class="album-image">
        <a href="#" class="thumb" data-action="edit">
            <img src="<?= yii::$app->homeUrl; ?>images/samsung-galaxy.jpg" class="img-responsive">
        </a>
        <?= Html::a($model->product_name, ['/product/product/index'], ['class' => '']) ?><br/>
        <?= Html::a($model->canonical_name, ['/product/product/index'], ['class' => '']) ?>
        <?= Html::a('<span> Sell This Product</span>', ['/product/product/sell-product', 'id' => $model->id], ['class' => 'sell-btn']) ?>
    </div>
</div>