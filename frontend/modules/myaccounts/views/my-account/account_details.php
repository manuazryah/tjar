<?php

use yii\helpers\Html;
use common\components\LeftMenuWidget;
use common\models\User;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
?>
<style>
    .MyAccount-content .edit-account label {
        display: unset;
    }
    #personal-submit{
        display: none;
    }
    #pinfo-cancel{
        display: none;
    }
    #einfo-cancel{
        display: none;
    }
    #user-gender{
        padding-top: 8px;
    }
    button[disabled], html input[disabled] {
        cursor: default;
        background: #f1f1f1;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-t-b-30 bg-white">
            <div class="my-account-sidebar">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <h3 class="MyAccount-title">My Account</h3>
                    <?= LeftMenuWidget::widget() ?>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="MyAccount-content">
                    <div class="edit-account">
                        <div class="personal-info marg-btm-20">
                            <div class="personal-info-head marg-btm-20">
                                <span class="info-head">Personal Information</span>
                                <span class="info-link" id="pinfo-edit">Edit</span>
                                <span class="info-link" id="pinfo-cancel">Cancel</span>
                            </div>
                            <?php
                            $model = new User();
                            $model->scenario = 'profile-edit';
                            if (!empty($user_details)) {
                                $model->first_name = $user_details->first_name;
                                $model->last_name = $user_details->last_name;
                                $model->mobile_number = $user_details->mobile_number;
                                $model->dob = $user_details->dob;
                                if (isset($user_details->gender)) {
                                    $model->gender = $user_details->gender;
                                } else {
                                    $model->gender = 1;
                                }
                                if (isset($user_details->dob) && $user_details->dob != '0000-00-00 00:00:00') {
                                    $model->dob = date('d-m-Y', strtotime($model->dob));
                                } else {
                                    $model->dob = date('d-m-Y');
                                }
                            }
                            ?>
                            <?php yii\widgets\Pjax::begin(['id' => 'user-account']); ?>
                            <?php $form_prof = ActiveForm::begin(['action' => 'edit-personal-info', 'id' => 'personal-info-form', 'method' => 'post',]); ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marg-top-20">
                                <fieldset>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padlft0">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 padlft0">
                                            <?= $form_prof->field($model, 'first_name')->textInput(['maxlength' => true, 'class' => 'field__input field__input--zip input-width', 'placeholder' => 'First Name'])->label() ?>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 padlft0">
                                            <?= $form_prof->field($model, 'last_name')->textInput(['maxlength' => true, 'class' => 'field__input field__input--zip input-width', 'placeholder' => 'Last Name'])->label() ?>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padright0" id="gender-div">
                                            <?= $form_prof->field($model, 'gender')->radioList(array('1' => 'Male', 2 => 'Female')); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padlft0">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0">
                                            <?php
                                            echo DatePicker::widget([
                                                'model' => $model,
                                                'form' => $form_prof,
                                                'type' => DatePicker::TYPE_INPUT,
                                                'attribute' => 'dob',
                                                'pluginOptions' => [
                                                    'autoclose' => true,
                                                    'format' => 'dd-mm-yyyy',
                                                ]
                                            ]);
                                            ?>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 padright0" id="gender-div">
                                            <?= $form_prof->field($model, 'mobile_number')->textInput(['maxlength' => true, 'class' => 'field__input field__input--zip input-width', 'placeholder' => 'Mobile Number'])->label() ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="clearfix"></div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad0" id="personal-submit">
                                        <div class="marg-top-20">
                                            <?= Html::submitButton('Save', ['class' => 'Proceed marg-btm-20', 'style' => 'width: 25%;margin-right: 40px;']) ?>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <?php ActiveForm::end(); ?>
                            <?php yii\widgets\Pjax::end(); ?>
                        </div>
                        <div class="emailaddress-info">
                            <div class="personal-info-head marg-btm-20">
                                <span class="info-head">Email Address</span>
                                <span class="info-link" id="einfo-edit">Edit</span>
                                <span class="info-link" id="einfo-cancel">Cancel</span>
                                <span class="info-link" id="einfo-changepass">Change Password</span>
                                <div class="clearfix"></div>
                                <form id="email-save-form">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marg-top-20">
                                        <fieldset>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 marg-top-20">
                                                <div class="form-group field-user-email">
                                                    <input type="text" id="edit-user-email" class="field__input field__input--zip input-width" name="email" value="<?= $user_details->email ?>" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 email-save" style="margin-top: 18px;display: none;">
                                                <button class="Proceed center" id="email-save">Save</button>
                                            </div>
                                        </fieldset>
                                    </div>
                                </form>
                                <form id="change-password-form" style="display:none">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marg-top-20">
                                        <fieldset>
                                            <legend>Password change</legend>
                                            <p class=" marg-btm-20">
                                                <span class="pss-err-msg" style="color: red;padding-top: 8px;font-size: 12px;font-weight: 500;"></span>
                                            </p>
                                            <p class=" marg-btm-20">
                                                <label for="password_current">Current password (leave blank to leave unchanged)</label>
                                                <input type="password" id="user-oldpassword" class="woocommerce-Input woocommerce-Input--password input-text" name="old_password" value="" placeholder="Enter Old Password">
                                            </p>
                                            <p class=" marg-btm-20">
                                                <label for="password_1">New password (leave blank to leave unchanged)</label>
                                                <input type="password" id="user-newpassword" class="woocommerce-Input woocommerce-Input--password input-text" name="new_password" value="" placeholder="Enter New Password">
                                            </p>
                                            <p class=" marg-btm-20">
                                                <label for="password_2">Confirm new password</label>
                                                <input type="password" id="user-confirmpassword" class="woocommerce-Input woocommerce-Input--password input-text" name="confirn_password" value="" placeholder="Enter Confirm Password">
                                            </p>
                                            <p class=" marg-btm-20">
                                                <button class="Proceed center" id="change-pass">Change Password</button>
                                            </p>
                                        </fieldset>
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
<script>
    jQuery(document).ready(function ($) {
        $("#user-first_name").prop('disabled', true);
        $("#user-last_name").prop('disabled', true);
        $("#user-mobile_number").prop('disabled', true);
        $("#edit-user-email").prop('disabled', true);
        $("#user-gender input:radio").attr('disabled', true);
        $("#user-dob").attr('disabled', true);

        $('#pinfo-edit').click(function () {
            $('#personal-submit').css('display', 'block');
            $("#user-gender input:radio").attr('disabled', false);
            $('#pinfo-cancel').show();
            $('#pinfo-edit').css('display', 'none');
            $("#user-first_name").prop('disabled', false);
            $("#user-last_name").prop('disabled', false);
            $("#user-mobile_number").prop('disabled', false);
            $("#user-dob").prop('disabled', false);
        });

        $('#pinfo-cancel').click(function () {
            $("#user-gender input:radio").attr('disabled', true);
            $('#personal-submit').css('display', 'none');
            $('#pinfo-edit').show();
            $('#pinfo-cancel').css('display', 'none');
            $("#user-first_name").prop('disabled', true);
            $("#user-last_name").prop('disabled', true);
            $("#user-mobile_number").prop('disabled', true);
            $("#user-dob").prop('disabled', true);
        });

        $('#einfo-edit').click(function () {
            $('#email-save-form').show();
            $('#change-password-form').hide();
            $("#edit-user-email").prop('disabled', false);
            $('#einfo-cancel').show();
            $('#einfo-edit').css('display', 'none');
            $('.email-save').css('display', 'block');
            $('.pss-err-msg').css('display', 'none');
            $('#user-oldpassword').val('');
            $('#user-newpassword').val('');
            $('#user-confirmpassword').val('');
        });

        $('#einfo-cancel').click(function () {
            $("#edit-user-email").prop('disabled', true);
            $('#einfo-edit').show();
            $('#einfo-cancel').css('display', 'none');
            $('.email-save').css('display', 'none');
            $('#email-save-form').show();
            $('#change-password-form').hide();
        });
        $('#einfo-changepass').click(function () {
            $('#email-save-form').hide();
            $('#change-password-form').show();
        });

        $("#email-save-form").submit(function (e) {
            e.preventDefault();
            if (validateEmailEdit() == 0) {
                var email_id = $("#edit-user-email").val();
                $.ajax({
                    type: 'POST',
                    cache: false,
                    data: {email: email_id},
                    url: homeUrl + 'myaccounts/my-account/change-email-address',
                    success: function (data) {
                        if (data == 0) {
                            return false
                        } else {
                            if ($("#edit-user-email").parent().next(".validation").length != 0) // only add if not added
                            {
                                $("#edit-user-email").parent().next(".validation").remove(); // remove it
                            }
                        }
                        $("#edit-user-email").prop('disabled', true);
                        $('#einfo-edit').show();
                        $('#einfo-cancel').css('display', 'none');
                        $('.email-save').css('display', 'none');
                    }
                });
                return true;
            } else {
                e.preventDefault();
                e.stopImmediatePropagation();
            }
        });

        $("#change-password-form").submit(function (e) {
            e.preventDefault();
            if (validateChangePass() == 0) {
                var str = $("#change-password-form").serialize();
                $.ajax({
                    type: 'POST',
                    cache: false,
                    data: str,
                    url: homeUrl + 'myaccounts/my-account/change-password',
                    success: function (data) {
                        var res = $.parseJSON(data);
                        if (res.result['msg'] != '') {
                            $('.pss-err-msg').css('display', 'block');
                            $('.pss-err-msg').text(res.result['msg']);
                            if (res.result['err_code'] == 1) {
                                $('.pss-err-msg').css('color', 'green');
                                $('#user-oldpassword').val('');
                                $('#user-newpassword').val('');
                                $('#user-confirmpassword').val('');
                            } else {
                                $('.pss-err-msg').css('color', 'red');
                            }
                        }
                    }
                });
                return true;
            } else {
                e.preventDefault();
                e.stopImmediatePropagation();
            }
        });

        function validateChangePass() {
            var valid = 0;
            if (!$('#user-oldpassword').val()) {
                if ($("#user-oldpassword").next(".validation").length == 0) // only add if not added
                {
                    $("#user-oldpassword").after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>This Field cannot be blank.</div>");
                }
                $('#user-oldpassword').focus();
                var valid = 1;
            } else {
                $("#user-oldpassword").next(".validation").remove(); // remove it
            }
            if (!$('#user-newpassword').val()) {
                if ($("#user-newpassword").next(".validation").length == 0) // only add if not added
                {
                    $("#user-newpassword").after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>This Field cannot be blank.</div>");
                }
                $('#user-newpassword').focus();
                var valid = 1;
            } else {
                $("#user-newpassword").next(".validation").remove(); // remove it
            }
            if (!$('#user-confirmpassword').val()) {
                if ($("#user-confirmpassword").next(".validation").length == 0) // only add if not added
                {
                    $("#user-confirmpassword").after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>This Field cannot be blank.</div>");
                }
                $('#user-confirmpassword').focus();
                var valid = 1;
            } else {
                $("#user-confirmpassword").next(".validation").remove(); // remove it
            }
            return valid;
        }

        function validateEmailEdit() {
            var valid = 0;
            if (!$('#edit-user-email').val()) {
                if ($("#edit-user-email").parent().next(".validation").length == 0) // only add if not added
                {
                    $("#edit-user-email").parent().after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>Email cannot be blank.</div>");
                }
                $('#edit-user-email').focus();
                var valid = 1;
            } else {
                var emailaddress = $('#edit-user-email').val();
                if (!isValidEmail(emailaddress)) {
                    if ($("#edit-user-email").parent().next(".validation").length != 0) // only add if not added
                    {
                        $("#edit-user-email").parent().next(".validation").remove(); // remove it
                    }
                    $("#edit-user-email").parent().after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>Enter valid email.</div>");
                    var valid = 1;
                } else {
                    $("#edit-user-email").parent().next(".validation").remove(); // remove it
                }
            }
            return valid;
        }
        function isValidEmail(emailAddress) {
            var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
            return pattern.test(emailAddress);
        }

    });
</script>