<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\file\FileInput;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use common\models\SearchTag;

/* @var $this yii\web\View */
/* @var $model common\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .select2product{
        /*padding: 5px;*/
        margin: 0px 0;
        font-family: sans-serif;
        font-size: 100%;
        color: #666;
        outline: 0;
        border: 0;
        -webkit-box-shadow: none;
        box-shadow: none;
        background: transparent !important;
    }

</style>


<ul class="nav nav-tabs hide_ul">
    <li class="active"><a href="#tab1" data-toggle="tab"></a></li>
    <li><a href="#tab2" data-toggle="tab"></a></li>
</ul>
<div class="products-form form-inline">
    <?php
    $form = ActiveForm::begin(['options' => ['id' => 'product-form',
    ]]);
    ?>
    <?= $form->errorSummary($model); ?>
    <div class="tab-content">



        <div class="tab-pane active" id="tab1">
            <div class="product-main-form">
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                    <?= $form->field($model, 'main_category')->dropDownList(ArrayHelper::map(common\models\ProductMainCategory::find()->all(), 'id', 'name'), ['prompt' => 'select category']) ?>
                    <label  value ='<?= Url::to('../product-main-category/ajaxcreate') ?>' class="btn btn-icon btn-white extra_btn main_cat">Add main category</label>
                    <?php
                    Modal::begin([
                        'header' => '',
                        'id' => 'modal_maincat',
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id = 'modalContent'></div>";
                    Modal::end();
                    ?>
                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                    <?php
                    echo $form->field($model, 'category')->widget(DepDrop::classname(), [
                        'options' => ['id' => 'products-category'],
                        'data' => ArrayHelper::map(\common\models\ProductCategory::find()->where(['category_id' => $model->main_category])->all(), 'id', 'category_name'),
                        'pluginOptions' => [
                            'depends' => ['products-main_category'],
                            'placeholder' => 'Select...',
                            'url' => Url::to(['/product/product-category/categories'])
                        ]
                    ]);
                    ?>
                    <label  value ='<?= Url::to('../product-category/ajaxcreate') ?>' class="btn btn-icon btn-white extra_btn ajax_category">Add category</label>
                    <?php
                    Modal::begin([
                        'header' => '',
                        'id' => 'modal_category',
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id = 'modalContent'></div>";
                    Modal::end();
                    ?>
                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                    <?php
                    echo $form->field($model, 'subcategory')->widget(DepDrop::classname(), [
                        'options' => ['id' => 'products-subcategory'],
                        'data' => ArrayHelper::map(\common\models\ProductSubCategory::find()->where(['category_id' => $model->category])->all(), 'id', 'subcategory_name'),
                        'pluginOptions' => [
                            'depends' => ['products-main_category', 'products-category'],
                            'placeholder' => 'Select...',
                            'url' => Url::to(['/product/product-sub-category/subcat'])
                        ]
                    ]);
                    ?>
                    <label  value ='<?= Url::to('../product-sub-category/ajaxcreate') ?>' class="btn btn-icon btn-white extra_btn sub_category">Add Sub category</label>
                    <?php
                    Modal::begin([
                        'header' => '',
                        'id' => 'modal_subcategory',
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id = 'modalContent'></div>";
                    Modal::end();
                    ?>
                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>

                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                    <?= $form->field($model, 'product_name_arabic')->textInput(['maxlength' => true]) ?>

                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                    <?= $form->field($model, 'canonical_name')->textInput(['maxlength' => true, 'readOnly' => true]) ?>

                </div>

                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                    <?php
                    echo $form->field($model, 'brand')->widget(DepDrop::classname(), [
                        'options' => ['id' => 'products-brand'],
                        //  'data' => ArrayHelper::map(\common\models\ProductSubCategory::find()->where(['category_id' => $model->category])->all(), 'id', 'subcategory_name'),
                        'pluginOptions' => [
                            'depends' => ['products-category', 'products-subcategory'],
                            'placeholder' => 'Select...',
                            'url' => Url::to(['/product/product-brand/brand-category'])
                        ]
                    ]);
                    ?>
                    <label  value ='<?= Url::to('../product-brand/ajaxcreate') ?>' class="btn btn-icon btn-white extra_btn product_brand">Add Brand</label>
                    <?php
                    Modal::begin([
                        'header' => '',
                        'id' => 'modal_brand',
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id = 'modalContent'></div>";
                    Modal::end();
                    ?>

                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                    <?= $form->field($model, 'item_ean')->textInput(['maxlength' => true]) ?>

                </div>

                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'main_description')->textarea(['rows' => 6]) ?>

                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'main_description_arabic')->textarea(['rows' => 6]) ?>

                </div>
                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                    <?= $form->field($model, 'gender')->textInput() ?>

                </div>
                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                    <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

                </div>
                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                    <?= $form->field($model, 'related_products')->textInput(['maxlength' => true]) ?>

                </div>
                <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
                    <?= $form->field($model, 'search_tags')->dropDownList(ArrayHelper::map(SearchTag::find()->where(['status' => '1'])->all(), 'id', 'tag_name'), ['class' => 'form-control', 'id' => 'product-search_tags', 'multiple' => 'multiple']) ?>
                    <label  value ='<?= Url::to('../search-tag/ajaxcreate') ?>' class="btn btn-icon btn-white extra_btn searchtag">Add Search Tag</label>
                    <?php
                    Modal::begin([
                        'header' => '',
                        'id' => 'modal_searchtag',
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id = 'modalContent'></div>";
                    Modal::end();
                    ?>
                </div>
                <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
                    <?= $form->field($model, 'search_tags_arabic')->dropDownList(ArrayHelper::map(SearchTag::find()->where(['status' => '1'])->all(), 'id', 'tag_name_arabic'), ['class' => 'form-control', 'id' => 'product-search_tags_arabic', 'multiple' => 'multiple']) ?>

                </div>
                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

                </div>

                <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>

                </div>

                <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'meta_keyword')->textarea(['rows' => 6]) ?>

                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'gallery_images')->fileInput(['multiple' => true]) ?>


                </div>
            </div>
            <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                <a class="btn btn-primary" id="btnNext">Next</a>


            </div>

        </div>
        <div class="tab-pane" id="tab2">
            <div class="product-features">

            </div>
            <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                <a class="btn btn-primary" id="btnPrevious">Previous</a>


            </div>

        </div>
        <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;float: right;']) ?>
            </div>
        </div>
    </div>

</div>
<?php ActiveForm::end(); ?>
<script>
    $(document).ready(function () {
        $('#products-product_name').keyup(function () {
            var name = slug($(this).val());
            $('#products-canonical_name').val(slug($(this).val()));
        });
        $('.hide_ul').hide();
        $('#products-category').blur(function () {
            $('.field-products-category .error').hide("");
        });
        $('#btnNext').click(function () {

            var category_id = $('#products-category').val();
            var sub_category_id = $('#products-subcategory').val();
            if (sub_category_id == null) {
//				$('.field-products-category').addClass('error');
                $('.field-products-category .help-block').hide("");
                if ($(".error").text() === "") {
                    $(".field-products-category").append("<div class='error'>Category cannot be blank.</div>");
                }

//				$('.field-products-category .help-block').css('display', 'block');
            } else {
                $('.field-products-category .error').hide("");
                $('.nav-tabs > .active').next('li').find('a').trigger('click');
                product_features(sub_category_id, category_id);
            }
        });

        $('#btnPrevious').click(function () {
            $('.nav-tabs > .active').prev('li').find('a').trigger('click');
        });
        $("#product-search_tags").select2({
            placeholder: 'Choose product search Tag',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#product-search_tags_arabic").select2({
            placeholder: 'Choose product search Tag',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
//        $("#products-main_category").select2({
//            placeholder: 'Choose Main Category',
//            allowClear: true
//        }).on('select2-open', function ()
//        {
//            // Adding Custom Scrollbar
//            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
//        });
    });
    var slug = function (str) {
        var $slug = '';
        var trimmed = $.trim(str);
        $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
                replace(/-+/g, '-').
                replace(/^-|-$/g, '');
        return $slug.toLowerCase();
    }
    function product_features(sub_category_id, category_id) {

        $.ajax({
            type: 'POST',
            url: '<?= Yii::$app->homeUrl; ?>product/products/product-features', // select product features
            data: {category_id: category_id, sub_category_id: sub_category_id},
            success: function (data) {
                $('.product-features').html(data);
            },
            error: function (data) {

            }
        });
    }

</script>