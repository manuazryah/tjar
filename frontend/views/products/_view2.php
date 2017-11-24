<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;

$product_details = \common\models\Products::findOne($model->product_id);
$split_folder = Yii::$app->UploadFile->folderName(0, 1000, $product_details->id);
?>
<li class="active">
        <div class="item col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="pad10">
                        <a href="<?= Yii::$app->homeUrl ?>product-detail/<?= $model->id ?>">
                                <div class="product-img">
                                        <?php echo Html::img(Yii::$app->homeUrl . "uploads/products/" . $split_folder . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images, ['class' => 'img-responsive mainimg']); ?>
                                        <?php echo Html::img(Yii::$app->homeUrl . "uploads/products/" . $split_folder . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images, ['class' => 'img-responsive hovrimg']); ?>
                                </div>
                                <h3 class="product-name"><?= $model->product->product_name ?></h3>
                                <?php
                                if (isset($model->offer_price) && $model->offer_price != "0") {
                                        $percentage = round(100 - (($model->offer_price / $model->price) * 100));
                                        ?>
                                        <h5 class="product-discount">Upto <?= $percentage ?>% off</h5>
                                <?php } ?>
                                <h6 class="actual-price"><?php if (!empty($model->offer_price)) { ?>$&nbsp;<?= $model->offer_price ?><?php } ?>

                                        <span class="old-price">/ <strike>$&nbsp;<?= $model->price ?></strike></span>

                                </h6>
                        </a>
                </div>
        </div>
</li>
