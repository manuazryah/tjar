<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
?>
<tr class="">
        <td class="" data-title="Order">
                <?php
                $productvendor = \common\models\ProductVendor::findOne($model->product_id);
                $product = common\models\Products::findOne($productvendor->product_id);
                if ($product) {
                        ?>
                        <div class="media">

                                <a style="margin: 0 auto; float: none;" class="thumbnail col-lg-5 col-md-6 col-sm-6 col-xs-6" href="<?= '/tjar/product-detail/' . $product->canonical_name . '/' . yii::$app->EncryptDecrypt->Encrypt('encrypt', $model->product_id) ?>">
                                        <?php
                                        $product_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '_thumb.' . $product->gallery_images;
                                        if (file_exists($product_image)) {
                                                ?>
                                                <img class="media-object" src="<?= Yii::$app->homeUrl . '/uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '_thumb.' . $product->gallery_images ?>">
                                        <?php } else { ?>
                                                <img src="<?= Yii::$app->homeUrl . 'uploads/products/gallery_dummy.png' ?>?scale.height=400" alt=""/>
                                        <?php } ?>
                                </a>
                        </div>
                <?php } else { ?>
                        <img src="<?= Yii::$app->homeUrl . 'uploads/products/dummy_gallery_thump.png' ?>" alt=""/>
                <?php } ?>
        </td>
        <td class="" data-title="Date">
                <time datetime="2017-10-24T09:25:49+00:00"><?= date("M d, Y", strtotime($model->DOC)); ?></time>
        </td>
        <td class="" data-title="Status">
                <?php
                if ($model->status == '0')
                        echo 'Processing';
                if ($model->status == '1')
                        echo 'Order Placed';
                if ($model->status == '2')
                        echo 'Order Dispatched';
                if ($model->status == '3')
                        echo 'Order Delivered';
                ?>
        </td>
        <td class="" data-title="Total">
                <span class=""><span class="">AED </span><?= sprintf("%0.2f", $model->sub_total); ?></span> for <?= $model->quantity ?> item
        </td>
        <td class="" data-title="Actions">
                <?php if ($model->status != '0') { ?>
                        <a href="" class="track track-status" id="<?= $model->id ?>" data-toggle="modal" data-target="#myModal">Track</a>
                <?php } ?>
                <input type="hidden" id="<?= $model->product_id ?>" class="product-id-val" value="<?= $model->product_id ?>">
                <a href="" class="track add-product-review" id="<?= $model->product_id ?>" order-id="<?= $model->id ?>" style="margin-top:10px;">Add Review</a>
                <a href="<?= Yii::$app->homeUrl . 'order-cancel/' . yii::$app->EncryptDecrypt->Encrypt('encrypt', $model->id) ?>" class="track cancel_order" onclick = "return confirm('Are you sure want to cancel the Order?');" style="margin-top:10px;">Cancel Product</a>
        </td>
</tr>

<div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">

                </div>

        </div>
</div>