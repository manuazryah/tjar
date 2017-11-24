<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\MenuManagement;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\MenuManagement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-management-form form-inline">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'type')->dropDownList(['1' => 'Main', '2' => 'Sub', '3' => 'Child']) ?>

    </div>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd type-main'>
        <?= $form->field($model, 'main_menu')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd type-main'>
        <?= $form->field($model, 'main_menu_arabic')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd type-main_id'>
        <?= $form->field($model, 'main_menu_id')->dropDownList(ArrayHelper::map(MenuManagement::find()->where(['main_menu_id' => null])->all(), 'id', 'main_menu'), ['prompt' => 'select Main', 'class' => 'form-control']) ?>

    </div>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd type-child'>
        <?= $form->field($model, 'sub_menu_id')->dropDownList(ArrayHelper::map(MenuManagement::find()->where(['sub_menu_id' => null])->andWhere(['not', ['main_menu_id' => null]])->all(), 'id', 'sub_menu'), ['prompt' => 'select Main', 'class' => 'form-control']) ?>

    </div>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd type-sub'>
        <?= $form->field($model, 'sub_menu')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd type-sub'>
        <?= $form->field($model, 'sub_menu_arabic')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd type-sub'>
        <?= $form->field($model, 'sub_menu_link')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd type-child'>
        <?= $form->field($model, 'child_menu')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd type-child'>
        <?= $form->field($model, 'child_menu_arabic')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd type-child'>
        <?= $form->field($model, 'child_menu_link')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12'>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;float: right;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(document).ready(function () {
        var type_id = $('#menumanagement-type').val();
        DisplayForm(type_id);
        $(document).on('change', '#menumanagement-type', function (e) {
            var id = $(this).val();
            DisplayForm(id);
        });
        $(document).on('change', '#menumanagement-main_menu_id', function () {
            var main_id = $(this).val();
            showLoader();
            $.ajax({
                url: homeUrl + 'menumanagement/menu-management/select-sub-menu',
                type: "post",
                data: {main_cat: main_id},
                success: function (data) {
                    $("#menumanagement-sub_menu_id").html(data);
                    hideLoader();
                }, error: function () {
                    hideLoader();
                }
            }
            );
        });
        function DisplayForm(type_id) {
            if (type_id == 1) {
                $(".type-main_id").hide();
                $(".type-sub").hide();
                $(".type-child").hide();
                $(".type-main").show();
            } else if (type_id == 2) {
                $(".type-main_id").show();
                $(".type-sub").show();
                $(".type-child").hide();
                $(".type-main").hide();
            } else if (type_id == 3) {
                $(".type-main_id").show();
                $(".type-sub").hide();
                $(".type-child").show();
                $(".type-main").hide();
            }
        }
    });
</script>