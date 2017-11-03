<?php

use yii\helpers\Html;
?>
<style>
    .otp-resnd{
        padding-bottom: 22px;
        padding-top: 30px;
        font-size: 12px;
        font-weight: bold;
        padding-left: 4px;
    }
    #resend-otp{
        font-weight: 500;
        font-size: 13px;
        cursor: pointer;
        color: #2874f0;
        float: right;
    }
</style>
<div id="reset-entry">
    <?= Html::beginForm(['site/new-password'], 'post', ['id' => 'reset-password']) ?>
    <!--<form id="reset-password">-->
    <input type="hidden" id="otp-check" name="otp_check" value=""/>
    <div class="form-group">
        <div class="col-md-12 inputGroupContainer">
            <div class="input-group" style="width: 100%;">
                <input  id="forgot-otp" name="forgot_otp" placeholder="Enter OTP" class="form-control" type="text">
            </div>
        </div>
        <div class="col-md-12 inputGroupContainer">
            <div class="input-group otp-resnd" style="width: 100%;">
                <span style="float:left;">OTP Send to Mobile/Email</span><a href="" id="resend-otp" data-val="<?= $token_model->user_id ?>" name="resend_otp">Resend?</a>
            </div>
        </div>
        <div class="col-md-12 inputGroupContainer">
            <div class="input-group" style="width: 100%;">
                <input  id="reset-passwd" name="reset_passwd" placeholder="Set New Password" class="form-control" type="password">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12" style="padding-top: 20px;">
            <?= Html::submitButton('Reset', ['class' => 'btn btn-warning']) ?>
        </div>
    </div>
    <?= Html::endForm() ?>
    <!--</form>-->
</div>