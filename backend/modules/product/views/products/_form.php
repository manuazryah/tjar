<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>



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

				</div>
				<div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
					<?= $form->field($model, 'item_ean')->textInput(['maxlength' => true]) ?>

				</div>

				<div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
					<?= $form->field($model, 'main_description')->textarea(['rows' => 6]) ?>

				</div>
				<div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
					<?= $form->field($model, 'main_description_arabic')->textarea(['rows' => 6]) ?>

				</div>
				<div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
					<?= $form->field($model, 'gender')->textInput() ?>

				</div>

				<div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
					<?= $form->field($model, 'related_products')->textInput(['maxlength' => true]) ?>

				</div>
				<div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
					<?= $form->field($model, 'search_tags')->textInput(['maxlength' => true]) ?>

				</div>
				<div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
					<?= $form->field($model, 'search_tags_arabic')->textInput(['maxlength' => true]) ?>

				</div>
				<div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
					<?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

				</div>
				<div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
					<?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

				</div>

				<div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
					<?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>

				</div>

				<div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
					<?= $form->field($model, 'meta_keyword')->textarea(['rows' => 6]) ?>

				</div>
				<?php
//				if (!$model->isNewRecord) {
//
				?>
				<input type="hidden" name="model-id"id="model-id" value="<?= $model->isNewRecord ? 0 : $model->id ?>">


				<?php //}  ?>
				<div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
					<?= $form->field($model, 'gallery_images')->fileInput(['multiple' => true, 'id' => $model->isNewRecord ? 'products-gallery_images' : 'products-gallery_images_update']) ?>
				</div>
				<div class="image_preview">


				</div>
			</div>
			<div class='col-md-12 col-sm-12 col-xs-12 left_padd' style="padding-top: 45px;">
				<a class="btn btn-primary next-btn" id="<?= $model->isNewRecord ? 'btnNext' : 'btnNextUpdate' ?>">Next</a>


			</div>

		</div>
		<div class="tab-pane" id="tab2">
			<div class="product-features">

			</div>
			<div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
				<a class="btn btn-primary" id="btnPrevious">Previous</a>


			</div>
			<div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
				<div class="form-group">
					<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;float: right;']) ?>
				</div>
			</div>

		</div>

	</div>

</div>
<?php ActiveForm::end(); ?>
<script>
	$(document).ready(function () {


		var modelId = $('#model-id').val();
		$.ajax({
			type: 'POST',
			url: '<?= Yii::$app->homeUrl; ?>product/products/product-gallery-images', // select already saved gallery images
			data: {modelId: modelId},
			success: function (data) {
				$('.image_preview').html(data);
			},
			error: function (data) {

			}
		});
		$("#products-gallery_images_update").change(function (e) {
			var modelId = $('#model-id').val();
			var form_data = new FormData();
			var ins = document.getElementById('products-gallery_images_update').files.length;
			for (var x = 0; x < ins; x++) {
				form_data.append("files[]", document.getElementById('products-gallery_images_update').files[x]);
			}
			form_data.append('model_id', modelId);

			$.ajax({
				url: '<?= Yii::$app->homeUrl; ?>product/products/more-gallery-image', // Upload Script
				dataType: 'text', // what to expect back from the PHP script
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function (data) {

					if (data === 0) {
						alert("error");
					} else {
						$('.image_preview').html(data);


					}
				},
				error: function (data) {
				}
			});
		});


		/* for temperary storage of gallery image in uploads temp folder */
		$("#products-gallery_images").change(function (e) {
			var form_data = new FormData();
			var ins = document.getElementById('products-gallery_images').files.length;
			for (var x = 0; x < ins; x++) {
				form_data.append("files[]", document.getElementById('products-gallery_images').files[x]);
			}
			$.ajax({
				url: '<?= Yii::$app->homeUrl; ?>product/products/product-image', // Upload Script
				dataType: 'text', // what to expect back from the PHP script
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function (data) {
					if (data === 0) {
						alert("error");
					} else {
						$('.image_preview').html(data);
					}
				},
				error: function (data) {
				}
			});
		});


		$('#btnNextUpdate').click(function () {
			var sub_category_id = $('#products-subcategory').val();
			var category_id = $('#products-category').val();
			var modelId = $('#model-id').val();
			productfeaturesUpdate(sub_category_id, category_id, modelId);
			subcategoryAlert(sub_category_id);
		});

		$('#products-product_name').keyup(function () {
			var name = slug($(this).val());
			$('#products-canonical_name').val(slug($(this).val()));
		});
		$('.hide_ul').hide();
		$('#products-category').blur(function () {
			$('.field-products-category .error').hide("");
		});
		$('#products-category').change(function () {
			var category_id = $('#products-category').val();
			var sub_category_id = $('#products-subcategory').val();
			product_features(sub_category_id, category_id);
		});
		$('#btnNext').click(function () {
			var sub_category_id = $('#products-subcategory').val();
			var modelId = $('#model-id').val();
			var radio_btn = $('input[name="profile-image"]:checked').attr("id-for");
			setProfilePic(radio_btn);
			subcategoryAlert(sub_category_id, modelId);
		});
		$('#btnPrevious').click(function () {
			$('.nav-tabs > .active').prev('li').find('a').trigger('click');
		});
	});
	var slug = function (str) {
		var $slug = '';
		var trimmed = $.trim(str);
		$slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
			replace(/-+/g, '-').
			replace(/^-|-$/g, '');
		return $slug.toLowerCase();
	};
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
	function productfeaturesUpdate(sub_category_id, category_id, modelid) {

		$.ajax({
			type: 'POST',
			url: '<?= Yii::$app->homeUrl; ?>product/products/product-features-update', // select product features
			data: {category_id: category_id, sub_category_id: sub_category_id, modelid: modelid},
			success: function (data) {
				$('.product-features').html(data);
			},
			error: function (data) {

			}
		});
	}
	function subcategoryAlert(sub_category_id, modelId) {
		if (sub_category_id == null) {
			$('.field-products-category .help-block').hide("");
			if ($(".error").text() === "") {
				$(".field-products-category").append("<div class='error'>Category cannot be blank.</div>");
			}

		} else {
			$('.field-products-category .error').hide("");
			$('.nav-tabs > .active').next('li').find('a').trigger('click');
		}
		if (modelId == 0) {
		}
	}
	function setProfilePic(radio_btn) {
		var img_path = $('#image_' + radio_btn).attr("img-name");
		$.ajax({
			url: '<?= Yii::$app->homeUrl; ?>product/products/set-profile-image', // Upload Script
			data: {imagepath: img_path},
			type: 'post',
			success: function (data) {

			},
			error: function (data) {
			}
		});
	}

</script>