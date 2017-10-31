<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use common\components\LeftMenuWidget;

//$model->first_name = 'Manu';
if ($model->isNewRecord) {
    $model->first_name = $user_data->first_name;
    $model->last_name = $user_data->last_name;
}

/* @var $this yii\web\View */
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-t-b-30 bg-white">
            <div class="my-account-sidebar">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <h3 class="MyAccount-title">Manage Addresses</h3>
                    <?= LeftMenuWidget::widget() ?>
                </div>
            </div>

            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="MyAccount-content">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 welcome-msg">
                        <p>The following addresses will be used on the checkout page by default.</p>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 address">
                        <div class="user-address-form">

                            <?php $form = ActiveForm::begin(); ?>

                            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(common\models\City::find()->all(), 'id', 'city_name'), ['prompt' => 'City'])->label(FALSE) ?>

                            <?= $form->field($model, 'street_id')->dropDownList(['prompt' => 'Street'])->label(FALSE) ?>

                            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

                            <?= $form->field($model, 'landmark')->textarea(['rows' => 6]) ?>

                            <?= $form->field($model, 'default_address')->textInput() ?>

                            <?= $form->field($model, 'pincode')->textInput() ?>

                            <div class="form-group">
                                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 address">
                        <h4 class="title">Billing Address <a class="edit" href="" data-toggle="modal" data-target="#editbillingaddress" >Edit</a></h4>
                        <address>
                            Azryah Networks<br>
                            vishal ramesh<br>
                            Azryah Networks<br>
                            Azryah Networks<br>
                            Ernakulam - 682037<br>
                            Kerala, India
                        </address>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 address">
                        <h4 class="title">Shipping Address <a class="edit" href="" data-toggle="modal" data-target="#editshippingaddress" >Edit</a></h4>
                        <address>
                            Azryah Networks<br>
                            vishal ramesh<br>
                            Azryah Networks<br>
                            Azryah Networks<br>
                            Ernakulam - 682037<br>
                            Kerala, India
                        </address>
                    </div>
                </div>

                <div class="modal fade edit-address-popup" role="dialog"  id="editbillingaddress">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 modal-dialog bg-white checkout-lft-box">
                        <div class="step__sections">

                            <div class="section section--contact-information">
                                <div class="section__header">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shipping-address">
                                        <h2 class="section__title">Billing Address</h2>
                                        <form>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 first-name">
                                                <input placeholder="First name" required="" autocomplete="" data-backup="first_name" class="field__input input-width" size="" type="text" name="" id="checkout_shipping_address_first_name">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 last-name padright0">
                                                <input placeholder="Last name" required="" autocomplete="" data-backup="last_name" class="field__input input-width" size="" type="text" name="" id="checkout_shipping_address_last_name">
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 padlft0 address">
                                                <input placeholder="Address" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0 padright0 apt">
                                                <input placeholder="Apt, suite, etc. (optional)" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padlft0 padright0 city">
                                                <input placeholder="City" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0">
                                                <select class="country-select input-width"  required name="school" id="schoolContainer">
                                                    <option value="None" selected=""> Your Country</option>
                                                    <option value="uae">UAE</option>
                                                    <option value="india">INDIA</option>
                                                    <option value="usa">USA</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0">
                                                <select class="country-select input-width"  required name="school" id="schoolContainer">
                                                    <option value="None" selected=""> State</option>
                                                    <option value="uae">OMAN</option>
                                                    <option value="india">KERALA</option>
                                                    <option value="usa">LAS VEGAS</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0 padright0">
                                                <input placeholder="Pincode" autocomplete="shipping postal-code" required="" data-backup="zip" data-google-autocomplete="true" data-google-autocomplete-title="Suggestions" class="field__input field__input--zip input-width" aria-required="true" size="" type="text" name="" id="">
                                            </div>
                                            <!--                                    <div class="clearfix"></div>
                                                                                <input class="input-checkbox" data-backup="" type="checkbox" value="1" name="" id="save-info"><label class="checkbox__label" for="save-info">Save this information for next time</label>-->
                                            <div class="clearfix"></div>
                                            <div class="clearfix"></div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad0">
                                                <div class="">
                                                    <!--<a href="" class="continue-shopping">Return to Cart</a>-->
                                                    <button class="Proceed center">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade edit-address-popup" role="dialog"  id="editshippingaddress">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 modal-dialog bg-white checkout-lft-box">
                        <div class="step__sections">

                            <div class="section section--contact-information">
                                <div class="section__header">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shipping-address">
                                        <h2 class="section__title">Shipping Address</h2>
                                        <form>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 first-name">
                                                <input placeholder="First name" required="" autocomplete="" data-backup="first_name" class="field__input input-width" size="" type="text" name="" id="checkout_shipping_address_first_name">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 last-name padright0">
                                                <input placeholder="Last name" required="" autocomplete="" data-backup="last_name" class="field__input input-width" size="" type="text" name="" id="checkout_shipping_address_last_name">
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 padlft0 address">
                                                <input placeholder="Address" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0 padright0 apt">
                                                <input placeholder="Apt, suite, etc. (optional)" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padlft0 padright0 city">
                                                <input placeholder="City" required="" autocomplete="" data-backup="" class="field__input input-width" size="" type="text" name="" id="">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0">
                                                <select class="country-select input-width"  required name="school" id="schoolContainer">
                                                    <option value="None" selected=""> Your Country</option>
                                                    <option value="uae">UAE</option>
                                                    <option value="india">INDIA</option>
                                                    <option value="usa">USA</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0">
                                                <select class="country-select input-width"  required name="school" id="schoolContainer">
                                                    <option value="None" selected=""> State</option>
                                                    <option value="uae">OMAN</option>
                                                    <option value="india">KERALA</option>
                                                    <option value="usa">LAS VEGAS</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0 padright0">
                                                <input placeholder="Pincode" autocomplete="shipping postal-code" required="" data-backup="zip" data-google-autocomplete="true" data-google-autocomplete-title="Suggestions" class="field__input field__input--zip input-width" aria-required="true" size="" type="text" name="" id="">
                                            </div>
                                            <!--                                    <div class="clearfix"></div>
                                                                                <input class="input-checkbox" data-backup="" type="checkbox" value="1" name="" id="save-info"><label class="checkbox__label" for="save-info">Save this information for next time</label>-->
                                            <div class="clearfix"></div>
                                            <div class="clearfix"></div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad0">
                                                <div class="">
                                                    <!--<a href="" class="continue-shopping">Return to Cart</a>-->
                                                    <button class="Proceed center">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
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
    jQuery(document).ready(function ($) {
        $('#useraddress-city_id').on('change', function (e) {
            var city_id = $(this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                data: {id: city_id},
                url: '<?= Yii::$app->homeUrl; ?>ajax/streets',
                success: function (data) {
                    $('#useraddress-street_id').html(data);
                }
            });
        });
    });
</script>
