<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SearchTag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="search-tag-form form-inline">

    <?php $form = ActiveForm::begin(['id' => 'ajax_searchtag']); ?>

    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(common\models\ProductCategory::find()->all(), 'id', 'category_name'), ['prompt' => 'select category', 'class' => 'form-control change_category']) ?>
    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?php $cat = []; ?>
        <?= $form->field($model, 'subcategory')->dropDownList($cat, ['prompt' => 'Select Sub Category', 'class' => 'form-control']) ?>

    </div>
    <div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'tag_name')->textInput() ?>
    </div>
    <div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'tag_name_arabic')->textInput() ?>
    </div>

    <div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'canonical_name')->textInput(['readOnly' => true]) ?>
    </div>
    <div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group">
            <?= Html::submitButton('Create', ['id' => 'add_searchtag', 'class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;float:right;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $('#searchtag-tag_name').keyup(function () {
        var name = slug($(this).val());
        $('#searchtag-canonical_name').val(slug($(this).val()));
    });
    $('#add_searchtag').click(function (event) {
        event.preventDefault();
        if (valid()) {
            var category = $('#searchtag-category').val();
            var subcategory = $('#searchtag-subcategory').val();
            var tag_name = $('#searchtag-tag_name').val();
            var tag_name_arabic = $('#searchtag-tag_name_arabic').val();
            var status = $('#searchtag-status').val();
            $.ajax({
                url: homeUrl + 'product/search-tag/ajaxcreate',
                type: "post",
                data: {category: category, subcat: subcategory, tag_name: tag_name, tag_name_arabic: tag_name_arabic, status: status},
                success: function (data) {
                    var $data = JSON.parse(data);
                    if ($data.con === "1") {
                        $('#product-search_tags').append($('<option value="' + $data.id + '" selected="selected" >' + $data.tag + '</option>'));
                        $('#s2id_product-search_tags').select2('data', {id: $data.id, text: $data.tag});
//               
                        $('#modal_searchtag').modal('toggle');
                    } else {
                        alert('internal error');
                    }

                }, error: function () {

                }
            });
        } else {
            alert('Please fill the Field');
        }

    });
    var valid = function () { //Validation Function - Sample, just checks for empty fields
        var valid;
        $("input").each(function () {
            if ($('#searchtag-category').val() === "" || $('#searchtag-subcategory').val() === "" || $('#searchtag-tag_name').val() === "" || $('#searchtag-tag_name_arabic').val() === "") {
                valid = false;
            }
        });
        if (valid !== false) {
            return true;
        } else {
            return false;
        }
    }
    var slug = function (str) {
        var $slug = '';
        var trimmed = $.trim(str);
        $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
                replace(/-+/g, '-').
                replace(/^-|-$/g, '');
        return $slug.toLowerCase();
    };
    $("#searchtag-category").select2({
        placeholder: '- select Category',
        allowClear: true
    }).on('select2-open', function ()
    {
        // Adding Custom Scrollbar
        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
    });
    $("#searchtag-subcategory").select2({
        placeholder: '- select Sub Category',
        allowClear: true
    }).on('select2-open', function ()
    {
        // Adding Custom Scrollbar
        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
    });
</script>
