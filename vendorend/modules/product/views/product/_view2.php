<?php

use yii\helpers\Html;
?>
<div class="col-md-3 col-sm-4 col-xs-6">
    <div class="album-image">
        <a href="#" class="thumb" data-action="edit">
            <img src="<?= yii::$app->homeUrl; ?>images/samsung-galaxy.jpg" class="img-responsive">
        </a>

        <a href="#" class="name">
            <span><?= $model->product_name ?></span>
            <em><?= $model->canonical_name ?></em>
        </a>
        <?= Html::a('<span> Sell This Product</span>', ['/product/sell-product'], ['class' => 'sell-btn']) ?>
    </div>
</div>