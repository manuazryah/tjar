<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Products;
use common\models\ProductVendor;
use common\models\Brand;

$this->title = 'Shopping Cart';
?>
<style>
    .attachment-shop_thumbnail{
        margin-right: 25px;
    }
    .new_address_area{
        display: none;
    }
</style>
<div id="cart">
    <div class="container">
        <div class="wpb_column vc_column_container vc_col-sm-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="vc_column-inner ">
                <div class="wpb_wrapper">
                    <div class="woocommerce">
                        <!--<form action="#" method="post" id="order_master_form">-->
                        <?php $form1 = ActiveForm::begin(['id' => '']); ?>

                        <table class="shop_table shop_table_responsive cart" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="product-item">Cart Item</th>
                                    <th class="product-price">Unit Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal">Sub Total</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($cart_items as $cart_item) {
                                    $prod_details = ProductVendor::findOne($cart_item->product_id);
                                    $product = Products::findOne($prod_details->product_id);
                                    if ($prod_details->offer_price == '0' || $prod_details->offer_price == '') {
                                        $price = $prod_details->price;
                                    } else {
                                        $price = $prod_details->offer_price;
                                    }
                                    ?>
                                    <tr class="cart_item">

                                        <td class="product-item" data-title="Product">

                                            <a href="#"><img  height="60" src="<?= Yii::$app->homeUrl . '/uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '_thumb.' . $product->gallery_images ?>" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="product-women-01" srcset="" sizes="(max-width: 180px) 100vw, 180px"></a><a class="product-discrp" href=""><?= $product->product_name; ?></a></td>

                                        <td class="product-price" data-title="Price">
                                            <span class="woocommerce-Price-amount amount"><?= sprintf("%0.2f", $price); ?><span class="woocommerce-Price-currencySymbol"> AED</span></span></td>

                                        <td class="product-quantity" data-title="Quantity">
                                            <div class="quantity">
                                                <input type="number" step="1" min="1" max="<?= $prod_details->qty; ?>" name="" value="<?= $cart_item->quantity ?>" title="Qty" class="input-text qty text cart_qty" id="<?= yii::$app->EncryptDecrypt->Encrypt('encrypt', $cart_item->id); ?>" size="4" pattern="[0-9]*" inputmode="numeric">
                                            </div>
                                        </td>

                                        <td class="product-subtotal" data-title="Total">
                                            <?php $total = $price * $cart_item->quantity; ?>
                                            <span class="woocommerce-Price-amount amount total_<?= yii::$app->EncryptDecrypt->Encrypt('encrypt', $cart_item->id) ?>"><?= sprintf("%0.2f", $total); ?><span class="woocommerce-Price-currencySymbol"> AED</span></span></td>

                                        <td class="product-remove">
                                            <?= Html::a('<i class="fa fa-trash-o"></i>', ['cart/cart_remove?id=' . $cart_item->id], ['class' => 'remove', 'title' => 'Remove this item']) ?>
                                            <!--<a href="#" class="remove" title="Remove this item" data-product_id="247" data-product_sku=""><i class="fa fa-trash-o"></i></a></td>--> 

                                    </tr>
                                <?php } ?>

                                <tr>
                                    <td colspan="6" class="actions">
                                        <div class="coupon">
                                            <label for="coupon_code">Coupon:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="Coupon code"> <input type="submit" class="button apply-coupen" name="apply_coupon" value="Apply Coupon">
                                        </div>
                                        <input type="submit" class="button update-cart" name="update_cart" value="Update Cart">
                                        <input type="hidden" id="_wpnonce" name="_wpnonce" value="6fa1d8e185"><input type="hidden" name="_wp_http_referer" value="/wordpress/lemonshop/cart/"></td>
                                </tr>

                            </tbody>
                        </table>



                        <div class="cart-collaterals">
                            <div class="cart_totals ">
                                <!--h2>Cart Totals</h2-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="shipping-wrap">
                                            <h4>Estimate Shipping Tax</h4>
                                            <p>Choose Your Destination And Get Shiping &amp; Tax Estimate.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-5">
                                        <div class="total-wrap">
                                            <table cellspacing="0" class="shop_table shop_table_responsive">

                                                <tbody>
                                                    <tr class="cart-subtotal">
                                                        <th>Subtotal</th>
                                                        <td data-title="Subtotal"><span class="woocommerce-Price-amount amount cart_subtotal"><?= sprintf("%0.2f", $subtotal); ?><span class="woocommerce-Price-currencySymbol">AED</span></span></td>
                                                    </tr>

                                                    <tr class="order-total">
                                                        <th>Grand Total</th>
                                                        <td data-title="Total"><strong><span class="woocommerce-Price-amount amount grand_total"><?= sprintf("%0.2f", $subtotal); ?><span class="woocommerce-Price-currencySymbol">AED</span></span></strong> </td>
                                                    </tr>

                                                </tbody></table>
                                        </div>
                                        <?php
                                        if (!isset(Yii::$app->user->identity->id)) {
                                            ?>
                                            <div class="wc-proceed-to-checkout proceed-to-checkout">
                                                <a data-toggle="modal" data-target="#aaa" href="" class="checkout-button button alt wc-forward login_checkout">
                                                    Login to Checkout</a>
                                            </div>
                                        <?php } else { ?>
                                            <div class="wc-proceed-to-checkout proceed-to-checkout">
                                                <a data-toggle="modal" data-target="#checkoutaaa" href="" class="checkout-button button alt wc-forward checkout_check">
                                                    Proceed to Checkout</a>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <?= $form1->field($order, 'ship_address_id')->hiddenInput(['maxlength' => true, 'class' => 'field__input input-width'])->label(FALSE) ?>
                                        <?= $form1->field($order, 'bill_address_id')->hiddenInput(['maxlength' => true, 'class' => 'field__input input-width'])->label(FALSE) ?>
                                        <div class="wc-proceed-to-checkout confirm-checkout hide">
                                            <?= Html::submitButton('Confirm Order', ['class' => 'checkout-button button alt wc-forward']) ?>
                                            <?php // Html::a('Confirm Order', ['cart/checkout'], ['class' => 'checkout-button button alt wc-forward', 'title' => 'Confirm Order']) ?>

                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <!--</form>-->
                        <div class="modal fade" role="dialog"  id="checkout">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 modal-dialog bg-white checkout-lft-box">
                                <div class="step__sections">

                                    <div class="section section--contact-information">
                                        <div class="section__header">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <h2 class="section__title">Shipping Address</h2>
<!--                                                                <p class="layout-flex__item">
                                                                    <span class="visually-hidden">Already have an account?</span>
                                                                    <a data-toggle="modal" data-target="#Login" href=""> Log in
                                                                    </a>     
                                                                </p>-->
                                            </div>
                                            <?php $form = ActiveForm::begin(['id' => 'shipping_id']); ?>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <select class="field__input input-width" id="billing" name="UserAddress[billing]" required="required">
                                                    <option value=''>Select</option>
                                                    <?php // foreach ($addresses as $address) {   ?>
                                                        <!--<option value="<?= $address->id ?>" ><?= $address->first_name . ', ' . $address->address . ', ' . $address->landmark ?></option>-->
                                                    <?php // }     ?>
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-lg-12">OR</div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <button type="button" id="new_address">  ADD A NEW ADDRESS</button>
                                              <!--<input class="input-checkbox" data-backup="" type="checkbox" value="1" name="" id="subscribe"><label class="checkbox__label" for="subscribe">Subscribe to our newsletter</label>-->
                                            </div>
                                            <!--                                                            </form>-->
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shipping-address">
                                                <div class="new_address_area">
                                                    <h2 class="section__title">Address</h2>
                                                    <!--<form>-->
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 first-name">
                                                        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'class' => 'field__input input-width billing', 'placeholder' => 'First Name', 'disabled' => 'disabled'])->label(FALSE) ?>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 last-name padright0">
                                                        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'class' => 'field__input input-width billing', 'placeholder' => 'Last Name', 'disabled' => 'disabled'])->label(FALSE) ?>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 padlft0 address">
                                                        <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'class' => 'field__input input-width billing', 'placeholder' => 'Address', 'disabled' => 'disabled'])->label(FALSE) ?>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0 padright0 apt">
                                                        <?= $form->field($model, 'landmark')->textInput(['maxlength' => true, 'class' => 'field__input input-width billing', 'placeholder' => 'Apt, suite, etc. (optional)', 'disabled' => 'disabled'])->label(FALSE) ?>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padlft0 padright0 city">
                                                        <?= $form->field($model, 'country_id')->dropDownList(ArrayHelper::map(common\models\Country::find()->all(), 'id', 'country_name'), ['class' => 'country-select input-width billing', 'disabled' => 'disabled'])->label(FALSE) ?>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padlft0 padright0">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0">
                                                            <?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(common\models\City::find()->all(), 'id', 'city_name'), ['prompt' => 'City', 'class' => 'country-select input-width billing', 'disabled' => 'disabled'])->label(FALSE) ?>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 padright0">
                                                            <?php $street = []; ?>
                                                            <?= $form->field($model, 'street_id')->dropDownList($street, ['prompt' => 'Street', 'class' => 'country-select input-width billing', 'disabled' => 'disabled'])->label(FALSE) ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0">
                                                        <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'class' => 'field__input field__input--zip input-width billing', 'placeholder' => 'Phone number', 'disabled' => 'disabled'])->label(FALSE) ?>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 padright0">
                                                        <?= $form->field($model, 'pincode')->textInput(['maxlength' => true, 'class' => 'field__input field__input--zip input-width billing', 'placeholder' => 'Pincode', 'disabled' => 'disabled'])->label(FALSE) ?>
                                                    </div>
                                                    <!--                                    <div class="clearfix"></div>
                                                                                        <input class="input-checkbox" data-backup="" type="checkbox" value="1" name="" id="save-info"><label class="checkbox__label" for="save-info">Save this information for next time</label>-->
                                                    <div class="clearfix"></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 delivery_address">
                                                    <input class="input-checkbox" data-backup="" type="checkbox" value="1" name="UserAddress[delivery]" id="delivery_address"><label class="checkbox__label" for="save-info">Save this information for Delivery </label></div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad0">
                                                    <div class="function-btn">
                                                        <button type="button" class="continue-shopping clos" data-dismiss="modal">Return to Cart</button>
                                                        <!--<a href="" class="continue-shopping">Return to Cart</a>-->
                                                        <input style="float: right;" type="submit" class="start-shopping continue_shipping" id="proceed_to_checkout" placeholder="Continue Checkout" >
                                                    </div>
                                                </div>
                                                <?php ActiveForm::end(); ?>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#new_address').click(function () {
        if ($(".new_address_area").is(":visible")) {//not view
            $('.billing').prop('disabled', true);
            $('#billing').prop('disabled', false);
            $('#billing').attr('required', 'required');

        } else {
            $('.billing').prop('disabled', false);
            $('#billing').prop('disabled', true);
            $("#billing").val('');
            $('#billing').removeAttr('required');

        }
        $(".new_address_area").animate({
            height: 'toggle'
        });

//alert($('.new_address_area').css('visibility'));
//        if ($('.new_address_area').css('display') === 'block') {
//            alert('Car 2 is hidden');
//        } else {
//            alert('balle');
//        }
    });
//visibility
//    $('#billing').on('change', function () {
//        var id = $(this).val();
//        if (id === '') {
//            $('.billing').prop('disabled', false);
//        } else {
//            $('.billing').prop('disabled', true);
//        }
//
//    });
</script>