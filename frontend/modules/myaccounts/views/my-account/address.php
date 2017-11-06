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
<script>
    $(document).ready(function () {
        var error_return = '<?php echo $error_return ?>';
        if (error_return == 1 || error_return == 2) {
            $('#divC').css('display', 'inline-block');
        }
    });
</script>
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

                    <div id="divAnim">
                        <!--<input type="button" id="btAnimate" value="Click it" />-->
                        <button type="button" id="btAnimate"><?= $error_return == 2 ? '<span><i class="fa fa-pencil" aria-hidden="true"></i></span> UPDATE ADDRESS' : '<span>+</span>  ADD A NEW ADDRESS' ?></button>
                        <div id="divC" class="edit-address-popup ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shipping-address">
                                <!--<h2 class="section__title">Billing Address</h2>-->
                                <?php $form = ActiveForm::begin(); ?>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 first-name">
                                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'class' => 'field__input input-width', 'placeholder' => 'First Name'])->label(FALSE) ?>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 last-name padright0">
                                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'class' => 'field__input input-width', 'placeholder' => 'Last Name'])->label(FALSE) ?>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 padlft0 address">
                                    <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'class' => 'field__input input-width', 'placeholder' => 'Address'])->label(FALSE) ?>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 padlft0 padright0 apt">
                                    <?= $form->field($model, 'landmark')->textInput(['maxlength' => true, 'class' => 'field__input input-width', 'placeholder' => 'Apt, suite, etc. (optional)'])->label(FALSE) ?>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padlft0 padright0 city">
                                    <?= $form->field($model, 'country_id')->dropDownList(ArrayHelper::map(common\models\Country::find()->all(), 'id', 'country_name'), ['class' => 'country-select input-width'])->label(FALSE) ?>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padlft0 padright0">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0">
                                        <?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(common\models\City::find()->all(), 'id', 'city_name'), ['prompt' => 'City', 'class' => 'country-select input-width'])->label(FALSE) ?>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 padright0">
                                        <?= $form->field($model, 'street_id')->dropDownList(ArrayHelper::map(common\models\Street::find()->all(), 'id', 'street_name'), ['prompt' => 'Street', 'class' => 'country-select input-width'])->label(FALSE) ?>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0">
                                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'class' => 'field__input field__input--zip input-width', 'placeholder' => 'Phone number'])->label(FALSE) ?>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 padright0">
                                    <?= $form->field($model, 'pincode')->textInput(['maxlength' => true, 'class' => 'field__input field__input--zip input-width', 'placeholder' => 'Pincode'])->label(FALSE) ?>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padlft0 padright0">
                                    <?= $form->field($model, 'default_address')->checkbox() ?>
                                </div>
                                <!--                                    <div class="clearfix"></div>
                                                                    <input class="input-checkbox" data-backup="" type="checkbox" value="1" name="" id="save-info"><label class="checkbox__label" for="save-info">Save this information for next time</label>-->
                                <div class="clearfix"></div>
                                <div class="clearfix"></div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad0">
                                    <div class="marg-top-20">
                                        <!--<a href="" class="continue-shopping">Return to Cart</a>-->
                                        <?= Html::submitButton('Save', ['class' => 'Proceed', 'style' => 'width: 25%;margin-right: 40px;']) ?>
                                        <?= Html::a('Cancel', ['address'], ['class' => 'Cancel', 'id' => 'btHide']) ?>
                                        <!--<a class="Cancel" id="btHide" href="">Cancel</a>-->
                                    </div>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="marg-top-btm20 my-account-address">
                        <?php foreach ($user_address as $value) { ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 address">
                                <div class="option-space">
                                    <b><span><?= $value->first_name . ' ' . $value->last_name ?></span><span class="number"><?= $value->phone ?></span></b>
                                    <?php if ($value->default_address == 1) {
                                        ?>
                                        <span><button class="default">DEFAULT</button></span>
                                    <?php }
                                    ?>

                                    <ul class="nav navbar-nav">
                                        <li class="option-btn dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjE2IiB2aWV3Qm94PSIwIDAgNCAxNiI+CiAgICA8ZyBmaWxsPSIjODc4Nzg3IiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPgogICAgICAgIDxjaXJjbGUgY3g9IjIiIGN5PSIyIiByPSIyIi8+CiAgICAgICAgPGNpcmNsZSBjeD0iMiIgY3k9IjgiIHI9IjIiLz4KICAgICAgICA8Y2lyY2xlIGN4PSIyIiBjeT0iMTQiIHI9IjIiLz4KICAgIDwvZz4KPC9zdmc+Cg=="/></a>
                                            <ul class="dropdown-menu options">
                                                <li><?= Html::a('Edit', ['address', 'id' => $value->id], ['class' => '']) ?></li>
                                                <?php if ($value->default_address == 0) {
                                                    ?>
                                                    <li><?= Html::a('Set as default', ['set-default', 'id' => $value->id], ['class' => '']) ?></li>
                                                    <li><?= Html::a('Delete', ['delete', 'id' => $value->id], ['class' => '']) ?></li>
                                                <?php }
                                                ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <address>
                                    <?= $value->address ?>
                                    <?php
                                    $landmark = '';
                                    $city = '';
                                    $street = '';
                                    if ($value->landmark != '') {
                                        $landmark = ', ' . $value->landmark;
                                    }
                                    if (isset($value->city_id)) {
                                        $city = ', ' . common\models\City::findOne($value->city_id)->city_name;
                                    }
                                    if (isset($value->street_id)) {
                                        $street = ', ' . common\models\Street::findOne($value->street_id)->street_name;
                                    }
                                    echo $landmark;
                                    echo $city;
                                    echo $street;
                                    echo ', ' . $value->pincode;
                                    ?>
                                </address>
                            </div>
                        <?php }
                        ?>
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
