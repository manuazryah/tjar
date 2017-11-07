<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Products;
use common\models\ProductVendor;
//use common\models\Settings;
use common\models\Brand;

$this->title = 'Payment';
?>
<style>
    .new_address_area{
        display: none;
    }
</style>
<div class="container">
    <div class="row">
        <div id="payment">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 bg-white checkout-lft-box">
                    <!--<span class="current-page">product</span>-->
                <div class="step__sections">

                    <div class="section section--contact-information">
                        <div class="section__header">
                            <div class="col-lg-12">
                                <h2 class="section__title">Delivery Address</h2>
                                <p class="layout-flex__item">
<!--                                    <a data-toggle="modal" data-target="#checkoutaaa" href="" class="checkout-button button alt wc-forward checkout_check">
                                        Proceed to Checkout</a>-->
                                    <a data-toggle="modal" data-target="#checkout" class="hidden-xs" href=""><button style="float: right;" type="email" class="start-shopping">Change Address</button></a>
                                </p>
                                <div class="modal fade" role="dialog"  id="checkout">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 modal-dialog bg-white checkout-lft-box">
                                                <div class="step__sections">

                                                    <div class="section section--contact-information">
                                                        <div class="section__header">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <h2 class="section__title">Customer information</h2>
<!--                                                                <p class="layout-flex__item">
                                                                    <span class="visually-hidden">Already have an account?</span>
                                                                    <a data-toggle="modal" data-target="#Login" href=""> Log in
                                                                    </a>     
                                                                </p>-->
                                                            </div>
                                                            <?php $form = ActiveForm::begin(); ?>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <select class="field__input input-width" id="billing" name="UserAddress[billing]" required="required">
                                                                    <option value=''>Select</option>
                                                                    <?php // foreach ($addresses as $address) { ?>
                                                                        <!--<option value="<?= $address->id ?>" ><?= $address->first_name . ', ' . $address->address . ', ' . $address->landmark ?></option>-->
                                                                    <?php // } ?>
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
                                                                            <?= $form->field($model, 'street_id')->dropDownList(ArrayHelper::map(common\models\Street::find()->all(), 'id', 'street_name'), ['prompt' => 'Street', 'class' => 'country-select input-width billing', 'disabled' => 'disabled'])->label(FALSE) ?>
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
                                                                    <input class="input-checkbox" data-backup="" type="checkbox" value="1" name="" id="save-info"><label class="checkbox__label" for="save-info">Save this information for next time</label>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad0">
                                                                    <div class="function-btn">
                                                                        <button type="button" class="continue-shopping clos" data-dismiss="modal">Return to Cart</button>
                                                                        <!--<a href="" class="continue-shopping">Return to Cart</a>-->
                                                                        <input style="float: right;" type="submit" class="start-shopping" placeholder="Continue Checkout" >
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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shipping-address">
                            <h5 class="">Azryah Networks</h5>
                            <p>
                               <?= $address->?>
                                Cittethukara CSEZ PO,
                                Kakkanad
                                Cochin,682037
                            </p>
                            <p><strong>Mobile:</strong>+91 1234567890</p>
                        </div>
                    </div> 
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h2 class="section__title">My Bag<span class="item-count">(2 Items)</span></h2>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cart-item-dtl">
                        <div class="cart">
                            <table class="table hidden-xs">
                                <tbody>
                                    <tr>
                                        <td class="col-lg-5 col-md-5 col-sm-2 col-xs-5">
                                            <div class="media">
                                                <a class="thumbnail pull-left col-lg-3 col-md-3 col-sm-7 col-xs-12" href="#"> <img class="media-object" src="images/products/1.png"> </a>
                                                <div class="media-body">
                                                    <h5 class="brand-name"><a href="#">Oppo F3 (Black,64 GB) (4GB RAM)</a></h5>
                                                    <p>Sold by GADGETBESTBUY</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="text-align: center">
                                            <div class="quantity">
                                                <input type="number" step="1" min="1" max="15" name="" value="1" title="Qty" class="input-text qty text" size="4" pattern="[0-9]*" inputmode="numeric">
                                            </div>
                                        </td>
                                        <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center price">Delivery by 2nd Nov, 17</td>

                                        <td class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center price">AED 200</td>
                                        <td class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center">
                                            <a href="#" class="btn-remove">
                                                Remove
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-lg-5 col-md-5 col-sm-2 col-xs-5">
                                            <div class="media">
                                                <a class="thumbnail pull-left col-lg-3 col-md-3 col-sm-7 col-xs-12" href="#"> <img class="media-object" src="images/products/1.png"> </a>
                                                <div class="media-body">
                                                    <h5 class="brand-name"><a href="#">Oppo F3 (Black,64 GB) (4GB RAM)</a></h5>
                                                    <p>Sold by GADGETBESTBUY</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="text-align: center">
                                            <div class="quantity">
                                                <input type="number" step="1" min="1" max="15" name="" value="1" title="Qty" class="input-text qty text" size="4" pattern="[0-9]*" inputmode="numeric">
                                            </div>
                                        </td>
                                        <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center price">Delivery by 2nd Nov, 17</td>

                                        <td class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center price">AED 200</td>
                                        <td class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center">
                                            <a href="#" class="btn-remove">
                                                Remove
                                            </a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                            <!------------------------------------------------------MOB_VIEW------------------------------------------------->

                            <div class="hidden-lg hidden-md hidden-sm">
                                <div class="payment-cart">
                                    <div class="col-xs-12 mob-car-list">
                                        <div class="media">
                                            <div class="track">
                                                <div class="col-xs-9 delivery-date">Delivery by 2nd Nov, 17</div>
                                                <button title="Remove From Cart" class="remove-cart"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                <!--<button class="add-cart green2">add to cart</button>-->
                                            </div>
                                            <a class="thumbnail pull-left col-xs-3" href="#"> <img class="media-object" src="images/products/1.png"> </a>
                                            <div class="col-xs-8">
                                                <h4 class="product-heading"><a href="#">Oppo F3 (Black,64 GB) (4GB RAM)</a></h4>
                                                <p>Sold by GADGETBESTBUY</p>
                                                <div class="col-xs-4 pad-0">
                                                    <p class="price">Price</p>
                                                </div>
                                                <div class="col-xs-7">
                                                    <p class="text-center">AED 200</p>
                                                </div>
                                                <div class="col-xs-4 pad-0">
                                                    <p class="price">Quantity</p>
                                                </div>
                                                <div class="col-xs-7 text-center">
                                                    <select min="0" max="5" id="number_passengers" name="quantity">

                                                        <option value="1">1</option>

                                                        <option value="2">2</option>

                                                        <option value="3">3</option>

                                                        <option value="4">4</option>

                                                        <option value="5">5</option>

                                                        <option value="6">6</option>

                                                        <option value="7">7</option>

                                                        <option value="8">8</option>

                                                        <option value="9">9</option>

                                                        <option value="10">10</option>

                                                    </select>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>

                                        <div class="media">
                                            <div class="track">
                                                <div class="col-xs-9 delivery-date">Delivery by 2nd Nov, 17</div>
                                                <button title="Remove From Cart" class="remove-cart"><i class="fa fa-times" aria-hidden="true"></i></button>
                                            </div>
                                            <a class="thumbnail pull-left col-xs-3" href="#"> <img class="media-object" src="images/products/1.png"> </a>
                                            <div class="col-xs-8">
                                                <h4 class="product-heading"><a href="#">Oppo F3 (Black,64 GB) (4GB RAM)</a></h4>
                                                <p>Sold by GADGETBESTBUY</p>
                                                <div class="col-xs-4 pad-0">
                                                    <p class="price">Price</p>
                                                </div>
                                                <div class="col-xs-7">
                                                    <p class="text-center">AED 200</p>
                                                </div>
                                                <div class="col-xs-4 pad-0">
                                                    <p class="price">Quantity</p>
                                                </div>
                                                <div class="col-xs-7 text-center">
                                                    <select min="0" max="5" id="number_passengers" name="quantity">

                                                        <option value="1">1</option>

                                                        <option value="2">2</option>

                                                        <option value="3">3</option>

                                                        <option value="4">4</option>

                                                        <option value="5">5</option>

                                                        <option value="6">6</option>

                                                        <option value="7">7</option>

                                                        <option value="8">8</option>

                                                        <option value="9">9</option>

                                                        <option value="10">10</option>

                                                    </select>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 checkout-rit-box">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  bg-white">
                    <h2 class="section__title">Payment Summery</h2>
                    <table>
                        <tbody>
                            <tr>
                                <td class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0">Subtotal</td>
                                <td class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padright0 amnt">AED 200</td>
                            </tr>
                            <tr>
                                <td class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0">Shipping Fee</td>
                                <td class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padright0 amnt">AED 22</td>
                            </tr>
                            <tr class="br-top-btm">
                                <td class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0"><strong>Order Total</strong></td>
                                <td class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padright0 amnt"><strong>AED 222</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <a><button class="Proceed">Proceed</button></a>
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
    </script>