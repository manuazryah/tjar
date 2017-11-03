<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;
use common\components\ModalViewWidget;
?>

<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 product-div">
        <div class="album-image">
                <a href="#" class="thumb" data-action="edit">
                        <!--<img src="<?= yii::$app->homeUrl; ?>../images/products/1.png" class="img-responsive">-->
                        <?php
                        $product_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $model->id) . '/' . $model->id . '/profile/' . $model->canonical_name . '.' . $model->gallery_images;
                        if (file_exists($product_image)) {
                                ?>
                                <img src="<?= Yii::$app->homeUrl . '../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $model->id) . '/' . $model->id . '/profile/' . $model->canonical_name . '.' . $model->gallery_images ?>" class="img-responsive">

                        <?php } else { ?>
                                <img src="<?= yii::$app->homeUrl; ?>images/gallery_dummy.png" class="img-responsive">

                        <?php } ?>
                </a>
                <div>
                        <label  value ='<?= Url::to(['details', 'id' => $model->id]) ?>' class="modalButton " style="color: #000;font-weight: bold;cursor: pointer"> <?= $model->product_name ?></label><br>
                        <?php if (isset($model->item_ean) && $model->item_ean != '') { ?>  <lable>EAN: <?= $model->item_ean ?></lable><br> <?php } ?>
                        <span>Sold for: 2,079.00 → 2,089.00 AED</span>

                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sell-btn-div">
                        <label  value ='<?= Url::to(['details', 'id' => $model->id]) ?>' class="modalButton view_detail "><i class="fa fa-eye"> View Detail</i></label>
                        <?= ModalViewWidget::widget() ?>
                        <?= Html::a('<span> Sell This Product</span>', ['/product/product/sell-product', 'id' => $model->id], ['class' => 'sell-btn']) ?>
                </div>
        </div>
</div>