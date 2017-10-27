<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductVendor */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .pick-up-head{
        background: #efeeee;
        padding: 10px 10px;
        margin-bottom: 15px;
    }
    .pick-up-address p{
        color: Black;
        line-height: 3px;
        font-size: 12px;
    }
    .pick-up-address{
        padding-right: 60px;
        position: relative;
        vertical-align: middle;
    }
    .pick-up-address i{
        position: absolute;
        right: 20px;
        vertical-align: middle;
        text-align: center;
        /*top: 30px;*/
        font-size: 24px;
    }
    .back-colr{
        background:#52a1e2;
    }
    #productvendor-full_fill label{
        padding-right: 20px;
    }
</style>

<div class="product-vendor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->hiddenInput(['value' => $id])->label(false) ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sku')->textInput() ?>

    <?= $form->field($model, 'offer_note')->textarea(['rows' => 4]) ?>
    <?php
    $location_id = common\models\Locations::find()->where(['dafault_address' => 1])->one();
    $model->pick_up_location = $location_id->id;
    $model->full_fill = '0';
    $model->courier_handover = '1';
    ?>
    <?= $form->field($model, 'handling_time')->dropDownList(['1' => 'Same Day', '2' => '2 Business days', '3' => '3 Business days'], ['prompt' => 'Please select from below']) ?>

    <?= $form->field($model, 'pick_up_location')->hiddenInput() ?>
    <?php foreach ($vendor_address as $value) { ?>
        <div class="col-md-12 pick-up-head <?= $value->dafault_address == 1 ? 'back-colr' : '' ?>" id="pick_up_head-<?= $value->id ?>">
            <div class="pick-up-address">
                <i class="fa fa-map-marker" id="marker-<?= $value->id ?>" aria-hidden="true" style="<?= $value->dafault_address == 1 ? 'color:green' : 'color:red' ?>"></i>
                <p style="<?= $value->dafault_address == 1 ? 'color:white' : 'color:black' ?>"><strong><?= $value->first_name . '' . $value->last_name ?></strong></p>
                <p style="<?= $value->dafault_address == 1 ? 'color:white' : 'color:black' ?>">Street : <?= $value->street ?></p>
                <p style="<?= $value->dafault_address == 1 ? 'color:white' : 'color:black' ?>">Phone  : <?= $value->mobile_no ?></p>
            </div>
        </div>
    <?php }
    ?>
    <?= $form->field($model, 'conditions')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'offer_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'free_shipping')->checkbox(); ?>

    <?= $form->field($model, 'full_fill')->radioList(array('1' => 'Yes', 0 => 'No')); ?>

    <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>
    <label style="color:black;">Courier Handover</label>
    <?= $form->field($model, 'courier_handover')->radio(); ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'style' => 'float: right;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        $(".pick-up-head").on('click', function () {
            var str = $(this).attr('id');
            var ret = str.split("-");
            var add = $('#productvendor-pick_up_location').val();
            $("#marker-" + ret[1]).css("color", 'green');
            $("#marker-" + add).css("color", 'red');
            $(".pick-up-head").removeClass("back-colr");
            $('#pick_up_head-' + ret[1]).addClass("back-colr");
            $('#pick_up_head-' + ret[1] + ' p').css("color", "white");
            $('#pick_up_head-' + add + ' p').css("color", "black");
            $('#productvendor-pick_up_location').val(ret[1]);
        });

        $("#productvendor-qty").on('click', function () {
            var top = $(this).position().top;
            $(".default-tool-tip").hide();
            $(".tool-tip").css('opacity', 2);
            $(".tool-tip").css('margin-top', top);
            var ver = '<h4>Stock Quantity is Important</h4>\n\
                    <div class="tip-box">\n\
                        <p>Please specify the exact quantity available in stock for this item.</p>\n\
                        <p><b style="color:black;">Note:</b> Please be sure to publish accurate quantity that reflects your actual stock. Never list an item that does not physically exists in your stock. Selling out of stock items may lead to the closure of your selling account.</p>\n\
                    </div>';
            $(".tool-tip").html(ver);
            $(".tool-tip").show();
        });
        $("#productvendor-qty").on('blur', function () {
            $(".tool-tip").hide();
        });
        $("#productvendor-price").on('click', function () {
            var top = $(this).position().top;
            $(".default-tool-tip").hide();
            $(".tool-tip").css('opacity', 2);
            $(".tool-tip").css('margin-top', top);
            var ver = '<h4>Offer Selling Price</h4>\n\
                    <div class="tip-box">\n\
                        <p>This is the price amount you want your item to be sold for. Please keep in mind that the (Final Value Fee) will be deducted based on the final Selling Price.</p>\n\
                    </div>';
            $(".tool-tip").html(ver);
            $(".tool-tip").show();
        });
        $("#productvendor-price").on('blur', function () {
            $(".tool-tip").hide();
        });
        $("#productvendor-sku").on('click', function () {
            var top = $(this).position().top;
            $(".default-tool-tip").hide();
            $(".tool-tip").css('opacity', 2);
            $(".tool-tip").css('margin-top', top);
            var ver = '<h4>Stock Keeping Unit - SKU</h4>\n\
                    <div class="tip-box">\n\
                        <p>This is your unique item number/stocking number. The same SKU number cannot be used for two different items.</p>\n\
                    </div>';
            $(".tool-tip").html(ver);
            $(".tool-tip").show();
        });
        $("#productvendor-sku").on('blur', function () {
            $(".tool-tip").hide();
        });
        $("#productvendor-offer_note").on('click', function () {
            var top = $(this).position().top;
            $(".default-tool-tip").hide();
            $(".tool-tip").css('opacity', 2);
            $(".tool-tip").css('margin-top', top);
            var ver = '<h4>Your Offer Note</h4>\n\
                    <div class="tip-box">\n\
                        <p>Announce any special promotions or guarantees you will honour and warranty availability</p>\n\
                        <p><b>IMPORTANT:</b> You can’t publish your contact information</p>\n\
                        <p>Publishing contact information of any kind is a violation of Souq.com privacy policy; you may be subject to a range of actions‚ including rejecting your listing or suspending your selling account.</p>\n\
                    </div>';
            $(".tool-tip").html(ver);
            $(".tool-tip").show();
        });
        $("#productvendor-offer_note").on('blur', function () {
            $(".tool-tip").hide();
        });
        $("#productvendor-handling_time").on('click', function () {
            var top = $(this).position().top;
            $(".default-tool-tip").hide();
            $(".tool-tip").css('opacity', 2);
            $(".tool-tip").css('margin-top', top);
            var ver = '<h4>Your Item Handling Time</h4>\n\
                    <div class="tip-box">\n\
                        <p>This is the time frame (business days) you need to prepare the item for shipping after receiving the order confirmation.</p>\n\
                        <p>Note: The handling time does not include the number of business days the shipping courier will take to deliver the item to the buyer.</p>\n\
                    </div>';
            $(".tool-tip").html(ver);
            $(".tool-tip").show();
        });
        $("#productvendor-handling_time").on('blur', function () {
            $(".tool-tip").hide();
        });
    });
</script>
