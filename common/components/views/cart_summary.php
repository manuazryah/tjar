<?php

use yii\helpers\Html;
use common\models\Product;
use common\models\Fregrance;
use common\models\OrderMaster;
use common\models\Settings;
?>
<div class="summery-box lit-blue">
        <div class="heading active">
                <p>SUMMARY</p>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: left;"><p><?= count($cart_items); ?> Items</p></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php foreach ($cart_items as $cart) { ?>
                        <?php
                        if ($cart->item_type == 1) {
                                $product = \common\models\CreateYourOwn::findOne($cart->product_id);

                                $bottles = \common\models\Bottle::findOne($product->bottle);
                                $product_image = Yii::$app->basePath . '/../uploads/create_your_own/bottle/' . $bottles->id . '/small.' . $bottles->bottle_img;
                                if (file_exists($product_image)) {
                                        $image = Yii::$app->homeUrl . 'uploads/create_your_own/bottle/' . $bottles->id . '/small.' . $bottles->bottle_img;
                                }
                                $price = $product->tot_amount;
                        } else {
                                $product = Product::findOne($cart->product_id);
                                $product_image = Yii::$app->basePath . '/../uploads/product/' . $product->id . '/profile/' . $product->canonical_name . '.' . $product->profile;
                                if (file_exists($product_image)) {
                                        $image = Yii::$app->homeUrl . 'uploads/product/' . $product->id . '/profile/' . $product->canonical_name . '_thumb.' . $product->profile;
                                } else {
                                        $image = Yii::$app->homeUrl . 'uploads/product/profile_thumb.png';
                                }
                                if ($product->offer_price == '0' || $product->offer_price == '') {
                                        $price = $product->price;
                                } else {
                                        $price = $product->offer_price;
                                }
                        }
                        $total = $price * $cart->quantity;
                        ?>
                        <div class="media">
                                <a class="thumbnail col-lg-2 col-md-2 col-sm-2 col-xs-2" href="#"> <img class="media-object" src="<?= $image ?>"> </a>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="top: 10px; text-align: left">
                                        <h4 class="product-heading"><a href="#" title='<?= $cart->item_type == 1 ? 'Custom Perfume' : $product->product_name; ?>'><?= $cart->item_type == 1 ? 'Custom Perfume' : substr($product->product_name, 0, 23); ?></a></h4>
                                        <?php
                                        $label1 = '';
                                        $label2 = '';
                                        if (isset($product->label_1)) {
                                                $label1 = $product->label_1;
                                        }
                                        if (isset($product->label_2)) {
                                                $label2 = $product->label_2;
                                        }
                                        ?>
                                        <h5 class="brand-name"><a href="#"><?= $cart->item_type == 1 ? $label1 . ' , ' . $label2 : Fregrance::findOne($product->product_type)->name; ?></a></h5>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="top: 15px; text-align: right; padding-right: 0;">
                                        <p class="price">AED <?= sprintf('%0.2f', $total) ?></p>
                                </div>
                        </div>
                <?php } ?>
                <br/>
        </div>
        <div class=" sub-total">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pad-0" style="padding: 15px 15px; border-top: 1px solid #ddd; border-right: 1px solid #ddd;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 label cart-summary-subtotal">Subtotal</div>
                        <?php if (isset($promotions) && $promotions > 0) { ?>      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 label cart-summary-promotion-discount">Promotion Code Added</div> <?php } ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 label">Shipping Charges</div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pad-0" style="padding: 15px 15px; border-top: 1px solid #ddd;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 price cart-summary-subtotal-amount"><?= sprintf('%0.2f', $subtotal->total_amount) ?></div>
                        <?php
                        $promotion_disvount = 0;
                        if (isset($promotions) && $promotions > 0) {
                                $promotion_disvount = $promotions;
                                ?> <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 price cart-summary-promotion-amount"><?= sprintf('%0.2f', $promotions) ?></div><?php } ?>
                        <?php
                        $shipextra = Settings::findOne('2')->value;
                        $ship_charge = $subtotal->total_amount <= $shipping_limit ? sprintf('%0.2f', $shipextra) : 0.00
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 price"><?= $ship_charge ?></div>
                </div>
        </div>
        <div class="total">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pad-0" style="padding: 15px 15px; border-top: 1px solid #ddd; border-right: 1px solid #ddd;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 label">Total  ( tax excl )</div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pad-0" style="padding: 15px 15px; border-top: 1px solid #ddd;">
                        <?php $grand_total = $subtotal->total_amount + $ship_charge - $promotion_disvount ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 price">AED <?= sprintf('%0.2f', $grand_total) ?></div>
                </div>
        </div>
</div>