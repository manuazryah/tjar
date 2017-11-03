<?php

use yii\helpers\Html;
?>
<div id="reset-entry">
    <p style="color:green;">An OTP has been sent.</p>
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
            <div class="input-group" style="width: 100%;">
                <input  id="reset-passwd" name="reset_passwd" placeholder="Set Password" class="form-control" type="text">
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