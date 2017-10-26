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
    <?= $form->field($model, 'free_shipping')->checkbox(); ?>

    <?= $form->field($model, 'conditions')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'offer_price')->textInput(['maxlength' => true]) ?>

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

    });
</script>
