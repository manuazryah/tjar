<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>
<tr class="">
    <td class="" data-title="Order">
        <?php
        $productvendor = \common\models\ProductVendor::findOne($model->product_id);
        $product = common\models\Products::findOne($productvendor->product_id);
        ?>
        <div class="media">
            <a style="margin: 0 auto; float: none;" class="thumbnail col-lg-5 col-md-6 col-sm-6 col-xs-6" href="#"> <img class="media-object" 
                                                                                                                         src="<?= Yii::$app->homeUrl . '/uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '_thumb.' . $product->gallery_images ?>"> </a>
        </div>
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
        <a href="" class="track">Track</a>
    </td>
</tr>