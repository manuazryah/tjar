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
                                <div class="product-img min-height">
                                        <?php echo Html::img(Yii::$app->homeUrl . "uploads/products/" . $split_folder . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images, ['class' => 'img-responsive mainimg']); ?>
                                        <?php echo Html::img(Yii::$app->homeUrl . "uploads/products/" . $split_folder . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images, ['class' => 'img-responsive hovrimg']); ?>
                                </div>
                                <h3 class="product-name"title="<?= $model->product->product_name ?>"><?= substr($model->product->product_name, 0, 29) ?></h3>
                                <?php if (!empty($model->offer)) { ?>
                                        <h5 class="product-discount">Upto <?= $model->offer ?>% off</h5>
                                <?php } ?>

                                <?php if (isset($model->offer_price) && $model->offer_price != "0") { ?>
                                        <h6 class="actual-price">$&nbsp;<?= $model->offer_price ?>
                                                <span class="old-price">/ <strike>$&nbsp;<?= $model->price ?></strike></span>
                                        </h6>
                                <?php } else { ?>
                                        <h6 class="actual-price">$&nbsp;<?= $model->price ?>
                                                <span class="old-price"></span>
                                        </h6>
                                <?php } ?>
                        </a>
                </div>
        </div>
</li>

