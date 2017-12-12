<?php

// _list_item.php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\ProductVendor;
use common\models\Products;
?>
<div class="row">
    <?php
    $prod_details = ProductVendor::findOne($data->product_id);
    $product = Products::findOne($prod_details->product_id);
    $vendor = common\models\Vendors::findone($prod_details->vendor_id);
    if ($prod_details->offer_price == '0' || $prod_details->offer_price == '') {
        $price = $prod_details->price;
    } else {
        $price = $prod_details->offer_price;
    }
    ?>
    <a href="">
        <div class="col-md-12 col-sm-12 col-xs-12" >
            <img  height="60" src="<?= Yii::$app->homeUrl . '../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '_thumb.' . $product->gallery_images ?>" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="product-women-01" srcset="" sizes="(max-width: 180px) 100vw, 180px">
            <?= Html::tag('button', Html::encode(substr($product->product_name, 0, 29)), ['value' => Url::to(['/vendors/product-vendor/product-view', 'id' => $product->id]), 'title' => $product->product_name, 'class' => 'username color modalButton edit-btn']) ?>
            Price <?= $price ?>
            EAN : <?= $product->item_ean ?>
            Vendor : <?= $vendor->first_name . ' ' . $vendor->last_name ?>


        </div>
    </a>
</div>
<div style="clear: both"></div>