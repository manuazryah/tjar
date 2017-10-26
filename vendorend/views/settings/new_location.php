<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

//$model->first_name = 'Manu';
if ($model->isNewRecord) {
    $model->first_name = $vendors->first_name;
    $model->last_name = $vendors->last_name;
    $model->mobile_no = $vendors->mobile_number;
}
?>
<style>
    .panel{
        padding: 20px 10px;
    }
</style>
<div>
    <h3>Add New Location</h3>
</div>
<div class="clearfix"></div>
<div class="panel panel-default">
    <div class="panel-body" style="padding-top:0px;">
        <div class="col-md-6">
            <div class="new-address-box">
                <?php $form = ActiveForm::begin(); ?>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => "First Name"])->label(FALSE) ?>

                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => "Last Name"])->label(FALSE) ?>

                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'city')->dropDownList(ArrayHelper::map(common\models\City::find()->all(), 'id', 'city_name'), ['prompt' => 'City'])->label(FALSE) ?>
                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?php
                    echo $form->field($model, 'street')->widget(DepDrop::classname(), [
                        'options' => ['id' => 'locations-street'],
//                        'data' => ArrayHelper::map(\common\models\ProductCategory::find()->where(['category_id' => $model->main_category_id])->all(), 'id', 'subcategory_name'),
                        'pluginOptions' => [
                            'depends' => ['locations-city'],
                            'placeholder' => 'Select...',
                            'url' => Url::to(['/settings/streets'])
                        ]
                    ])->label(FALSE);
                    ?>
                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'building_no')->textInput(['maxlength' => true, 'placeholder' => "Building No"])->label(FALSE) ?>

                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true, 'placeholder' => "Mobile No"])->label(FALSE) ?>

                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'landline')->textInput(['maxlength' => true, 'placeholder' => "Land Line"])->label(FALSE) ?>

                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'postbox_no')->textInput(['placeholder' => "Postbox No"])->label(FALSE) ?>

                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'dafault_address')->checkBox()->label(FALSE) ?>

                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <div class="form-group">
                        <?= Html::a('Discard', ['/settings/locations'], ['class' => 'btn btn-gray', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
                        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;float: right;']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="col-md-6">
        </div>
    </div>
</div>