<?php

use yii\helpers\Html;
use common\components\LeftMenuWidget;

/* @var $this yii\web\View */
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-t-b-30 bg-white">
            <div class="my-account-sidebar">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <h3 class="MyAccount-title">Orders</h3>
                    <?= LeftMenuWidget::widget() ?>
                </div>
            </div>

            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="MyAccount-content">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th class=""><span class="">Order</span></th>
                                <th class=""><span class="">Date</span></th>
                                <th class=""><span class="">Status</span></th>
                                <th class=""><span class="">Total</span></th>
                                <th class=""><span class="">Actions</span></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($orders as $order){?>
                            <tr class="">
                                <td class="" data-title="Order">
                                    <?php 
                                    $productvendor = \common\models\ProductVendor::findOne($order->product_id);
                                    $product= common\models\Products::findOne($productvendor->product_id);
                                    ?>
                                    <div class="media">
                                        <a style="margin: 0 auto; float: none;" class="thumbnail col-lg-5 col-md-6 col-sm-6 col-xs-6" href="#"> <img class="media-object" 
                                         src="<?= Yii::$app->homeUrl . '/uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '_thumb.' . $product->gallery_images ?>"> </a>
                                    </div>
                                </td>
                                <td class="" data-title="Date">
                                    <time datetime="2017-10-24T09:25:49+00:00"><?= date("M d, Y", strtotime($order->DOC) );?></time>
                                </td>
                                <td class="" data-title="Status">
                                    <?php 
                                    if($order->status =='0') echo 'Processing';
                                    if($order->status =='1') echo 'Order Placed';
                                    if($order->status =='2') echo 'Order Dispatched';
                                    
                                    ?>
                                </td>
                                <td class="" data-title="Total">
                                    <span class=""><span class="">AED </span><?= sprintf("%0.2f", $order->sub_total);?></span> for <?= $order->quantity?> item
                                </td>
                                <td class="" data-title="Actions">
                                    <a href="" class="track">Track</a>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>