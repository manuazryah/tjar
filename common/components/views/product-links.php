<?php

use yii\helpers\Html;
use common\models\Fregrance;
?>
<style>
    .offer-tag {
        position: absolute;
        top: 2px;
        right: -7px;
        width: 100px;
    }
    .offer-tag span {
        color: white;
        font-size: 14px;
        position: absolute;
        width: 100%;
        left: -2px;
        top: 3px;
    }
</style>
<div class="gp_products_inner" id="<?= $div_id ?>">
    <div class="gp_products_item_image">
        <a href="<?= Yii::$app->homeUrl . 'product_detail/' . $model->canonical_name ?>">
            <?php
            $product_image = Yii::$app->basePath . '/../uploads/product/' . $model->id . '/profile/' . $model->canonical_name . '.' . $model->profile;
            if (file_exists($product_image)) {
                ?>
                <img src="<?= Yii::$app->homeUrl . 'uploads/product/' . $model->id . '/profile/' . $model->canonical_name . '.' . $model->profile ?>" height="100%" alt="1" />
                <?php
            } else {
                ?>
                <img src="<?= Yii::$app->homeUrl . 'uploads/product/dummy_perfume.png' ?>" height="100%" alt="1" />
            <?php }
            ?>
            <?php if ($model->stock_availability != 1 || $model->stock < 1) { ?>
               
                <div class="outofstock">  
                    <p>OUT OF STOCk</p>     
                </div>
            <?php } ?>
        </a>
        <?= Html::a(' <div class="img-overlay"></div>', ['/product/product_detail', 'product' => $model->canonical_name]) ?>
    </div>
    <ul class="text-center">
        <input type="hidden" value="1" class="q_ty">
        <?php if ($model->stock_availability == 1 && $model->stock > 0) { ?>
            <?= Html::a('<li><i class="fa fa-shopping-cart"></i></li>', '#', ['class' => 'add_to_cart', 'id' => $model->canonical_name]) ?>
        <?php } ?>
        <?= Html::a('<li><i class="fa fa-heart"></i></li>', 'javascript:void(0)', ['class' => 'add_to_wish_list', 'id' => $model->id]) ?>
        <?= Html::a('<li><i class="fa fa-eye"></i></li>', ['/product/product_detail', 'product' => $model->canonical_name], ['class' => '']) ?>
    </ul>
<!--	<div class="wish-list-popup " id="wish-list-popup-<?= $model->id ?>">
<i class="fa fa-check" aria-hidden="true"></i>Added to Your Wishlist
</div>-->
    <div class="gp_products_item_caption">

        <ul class="gp_products_caption_name">
            <li><a href="<?= Yii::$app->homeUrl . 'product_detail/' . $model->canonical_name ?>" title="<?= $model->product_name ?>"><?= substr($model->product_name, 0, 35) ?></a></li>
            <?php $product_type = Fregrance::findOne($model->product_type); ?>
            <li><a href="<?= Yii::$app->homeUrl . 'product_detail/' . $model->canonical_name ?>"><?= $product_type->name; ?></a></li>
        </ul>
        <ul class="gp_products_caption_rating">
            <?php
            if ($model->offer_price != "0" && isset($model->offer_price)) {
                $percentage = round(100 - (($model->offer_price / $model->price) * 100));
                ?>
                <li>AED <?= $model->offer_price; ?></li>
                <li class="center">AED <?= $model->price; ?></li>
                <li class="pull-right"><a href="#">(<?= $percentage ?>%OFF)</a></li>
                <?php
            } else {
                ?>
                <li class="center">AED <?= $model->price; ?></li>
                <?php } ?>
        </ul>

    </div>
</div>




