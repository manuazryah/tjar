<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSubCategory */

$this->title = 'URL Creation';
$this->params['breadcrumbs'][] = ['label' => 'URL Creation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
	<div class="col-md-12">

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

			</div>
			<div class="panel-body">
				<div class="panel-body">
					<div class="product-sub-category-create">
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Type</label>
								<?= Html::dropdownList('type', null, ['1' => 'Category', '2' => 'Filter Value', '3' => 'Search Tags'], ['prompt' => 'Select Type', 'class' => 'form-control', 'id' => 'url_type']) ?>

							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Category</label>
								<?= Html::dropDownList('category', null, ArrayHelper::map(common\models\ProductCategory::find()->all(), 'id', 'category_name'), ['prompt' => 'Select Category', 'class' => 'form-control change_category', 'id' => 'products-category']) ?>
								<input type="hidden" id="main_category"  can_name="">
								<input type="hidden" id="category_"  can_name="">
								<input type="hidden" id="sub_category_"  can_name="">
								<input type="hidden" id="url_before_option">

							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Sub Category</label>
								<?= Html::dropDownList('sub_category', null, ArrayHelper::map(common\models\ProductSubCategory::find()->all(), 'id', 'subcategory_name'), ['prompt' => 'Select Sub Category', 'class' => 'form-control change_subcategory', 'id' => 'products-subcategory']) ?>
							</div>
						</div>
						<div class="col-md-4" id="filter_display">
							<div class="form-group">
								<label class="control-label">Filter Values</label>
								<?= Html::dropDownList('filter_value', null, ArrayHelper::map(common\models\Features::find()->all(), 'id', 'filter_tittle'), ['prompt' => 'Select Filter', 'class' => 'form-control filter_value', 'id' => 'filter_value']) ?>
							</div>
						</div>
						<div class="col-md-4" id="filter_options">
							<div class="form-group">
								<?php
								$data = [];
								?>
								<label class="control-label">Filter Options</label>
								<?= Html::dropDownList('filter_options', null, $data, ['prompt' => 'Select Filter', 'class' => 'form-control filter_options', 'id' => 'filter_option', 'multiple' => 'multiple']) ?>
								<?php // Html::dropDownList('filter_options', null, $data, ['prompt' => 'Select Filter', 'class' => 'form-control filter_options', 'id' => 'filter_option']) ?>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Generated Url</label>
								<textarea style="width:100%;" id="created_url" readonly="true"></textarea>
								<button id="copy_url" class="url_gen" style="text-decoration: underline">copy url</button>
							</div>

						</div>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {

		$('#copy_url').click(function () {
			var copyText = document.getElementById("created_url");
			copyText.select();
			document.execCommand("Copy");
		});

		$("#filter_option").select2({
			placeholder: 'select option',
			allowClear: true
		}).on('select2-open', function ()
		{
			$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
		});
		$('#filter_display').hide();
		$('#filter_options').hide();
		var host = window.location.host + '/' + 'tjar/';
		var url_type = '';
		$('#url_type').change(function () {
			var type = this.value;
			if (type == 1) {
				url_type = host + 'products/index?';
				$('#filter_display').hide();
				$('#filter_options').hide();
			} else if (type == 2) {
				$('#filter_display').show();
				$('#filter_options').show();
				url_type = host + 'products/index?';
//				$('#products-category').attr("disabled", true);
//				$('#products-subcategory').attr("disabled", true);
			} else if (type == 3) {
				$('#filter_display').hide();
				$('#filter_options').hide();
				url_type = host + 'products/product-search?';
			}

			$('#created_url').html(url_type);
		});
		$('#products-category').change(function () {
			$('#created_url').html('');
			var category_id = this.value;
			var type = 1;
			category(category_id, type);
			featureselect(category_id, 1);

		});
		$('#products-subcategory').change(function () {
			$('#created_url').html('');
			var category_id = this.value;
			var type = 2;
			category(category_id, type);
			featureselect(category_id, 2);

		});
		$('#filter_value').change(function () {

//			if ($('#sub_category_').val() == '') {
//				var category_id = $('#category_').val();
//				var type = 1;
//				category(category_id, type);
//
//			} else {
//				var category_id = $('#sub_category_').val();
//				var type = 2;
//				category(category_id, type);
//
//			}
			var filter_id = this.value;
			filterdatas(filter_id);


		});
		$('#filter_option').change(function () {
//			alert(this.value);
			$("#filter_option option:selected").each(function () {
				var current_url = $('#created_url').val();
				var $this = $(this);
				var filter_categ = $this.attr('filtercateg');
				if ($this.length) {
					var check = filter_categ + '=' + $this.val();
					if (current_url.indexOf(check) > -1) {
						var url = current_url;
						$('#created_url').html(url);
					} else {
						var url = current_url + '&' + check;
						$('#created_url').html(url);
					}
					console.log(url);
				}
			});
//			var values = $('#filter_option').val();

//			setfilteroptions(values, filter_categ);


		});
		function setfilteroptions(values, filter_categ) {


//			var options = values.split(',');
//			console.log(values);
//			var check = filter_categ + '=' + option_id;
//			var current_url = $('#created_url').val();
//			if (current_url.indexOf(check) > -1) {
//				alert('yes');
//				var url = current_url;
//			} else {
//				alert('no');
//				var url = current_url + '&' + filter_categ + '=' + option_id;
//			}
//
//			$('#created_url').html(url);

		}

		function filterdatas(filter_id) {
			var category_id = $('#category_').val();
			var sub_categ_id = $('#sub_category_').val();
			var crnt = $('#url_before_option').val();
			var current = $('#created_url').val();
			showLoader();
			$.ajax({
				type: 'POST',
				url: '<?= Yii::$app->homeUrl; ?>url-creation/filter-datas', //get featrues
				data: {filterid: filter_id, categ: category_id, sub_categ: sub_categ_id},
				success: function (data) {
//					console.log(data);
					var $data = JSON.parse(data);
					if ($data.con === "1") {
						$('#filter_option').html('').html($data.val);

//						if (crnt === null) {
//							$('#url_before_option').val(current);
//							var url = current;
//							alert('url');
//						} else {
//							var url = $('#url_before_option').val();
//							alert(url);
//						}
//						url = current_url + '&' + $data.filter_canonical_name + '=';
						hideLoader();
					} else {
						alert('Internal Error');
						hideLoader();
					}
//					$('#created_url').html(url);
				},
				error: function (data) {
					hideLoader();

				}
			});
		}

		function featureselect(category_id, index) {/* indx for differnciate category and sub category*/
			showLoader();
			$.ajax({
				type: 'POST',
				url: '<?= Yii::$app->homeUrl; ?>url-creation/features', //get featrues
				data: {categ_id: category_id, type: index},
				success: function (data) {
					var $data = JSON.parse(data);
					if ($data.con === "1") {
						$('#filter_value').html('').html($data.val);
						hideLoader();
					} else {
						alert('Internal Error');
						hideLoader();
					}
				},
				error: function (data) {

				}
			});
		}
		function category(category_id, type) {
			showLoader();
			$.ajax({
				type: 'POST',
				url: '<?= Yii::$app->homeUrl; ?>url-creation/category', //get main category
				data: {categ_id: category_id, type: type},
				success: function (data) {
					var result = JSON.parse(data);
//					console.log(result);

					if (type == 1) {
						$('#main_category').val(result.main_categ_id);
						$('#category_').val(result.category_id);
						$("#main_category").attr("can_name", result.main_categ_cano_name);
						$("#category_").attr("can_name", result.canonical_name);
						url = url_type + 'main_categ=' + result.main_categ_cano_name + '&categ=' + result.canonical_name;
					} else if (type == 2) {
//						console.log(result);
						$('#main_category').val(result.main_categ_id);
						$("#main_category").attr("can_name", result.main_categ_cano_name);
						$('#category_').val(result.category_id);
						$("#category_").attr("can_name", result.categ_cano_name);
						$('#sub_category_').val(result.sub_categ_id);
						$("#sub_category_").attr("can_name", result.sub_categ_cano_name);
						url = url_type + 'main_categ=' + result.main_categ_cano_name + '&sub_categ=' + result.sub_categ_cano_name;
					}
					$('#created_url').html(url);
					hideLoader();
				},
				error: function (data) {
					hideLoader();
				}
			});
		}

	});
</script>
