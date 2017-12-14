<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Policies */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="policies-form form-inline">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'return_policy')->textarea(['rows' => 6]) ?>

    </div><div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'terms_of_use')->textarea(['rows' => 6]) ?>

    </div><div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'security')->textarea(['rows' => 6]) ?>

    </div><div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'privacy')->textarea(['rows' => 6]) ?>

    </div><div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'infringement')->textarea(['rows' => 6]) ?>

    </div><div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'faq')->textarea(['rows' => 6]) ?>

    </div><div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12'>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;float:right;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script src="<?= Yii::$app->homeUrl; ?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('policies-return_policy',
            {
                toolbar: 'Basic', /* this does the magic */
                height: '200px',

            });
    CKEDITOR.replace('policies-terms_of_use',
            {
                toolbar: 'Basic', /* this does the magic */
                height: '200px',

            });
    CKEDITOR.replace('policies-security',
            {
                toolbar: 'Basic', /* this does the magic */
                height: '200px',

            });
    CKEDITOR.replace('policies-privacy',
            {
                toolbar: 'Basic', /* this does the magic */
                height: '200px',

            });
    CKEDITOR.replace('policies-infringement',
            {
                toolbar: 'Basic', /* this does the magic */
                height: '200px',

            });
    CKEDITOR.replace('policies-faq',
            {
                toolbar: 'Basic', /* this does the magic */
                height: '200px',

            });

</script>
