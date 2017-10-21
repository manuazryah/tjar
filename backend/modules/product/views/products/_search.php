<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'product_name') ?>

    <?= $form->field($model, 'canonical_name') ?>

    <?= $form->field($model, 'main_category') ?>

    <?= $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'subcategory') ?>

    <?php // echo $form->field($model, 'brand') ?>

    <?php // echo $form->field($model, 'item_ean') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'main_description') ?>

    <?php // echo $form->field($model, 'gallery_images') ?>

    <?php // echo $form->field($model, 'related_products') ?>

    <?php // echo $form->field($model, 'search_tags') ?>

    <?php // echo $form->field($model, 'meta_title') ?>

    <?php // echo $form->field($model, 'meta_description') ?>

    <?php // echo $form->field($model, 'meta_keyword') ?>

    <?php // echo $form->field($model, 'field1') ?>

    <?php // echo $form->field($model, 'field2') ?>

    <?php // echo $form->field($model, 'field3') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'CB') ?>

    <?php // echo $form->field($model, 'UB') ?>

    <?php // echo $form->field($model, 'DOC') ?>

    <?php // echo $form->field($model, 'DOU') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
