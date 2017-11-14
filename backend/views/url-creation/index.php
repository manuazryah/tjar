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
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Sub Category</label>
								<?= Html::dropDownList('sub_category', null, ArrayHelper::map(common\models\ProductSubCategory::find()->all(), 'id', 'subcategory_name'), ['prompt' => 'Select Sub Category', 'class' => 'form-control change_subcategory', 'id' => 'products-subcategory']) ?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Filter Values</label>
								<?= Html::dropDownList('filter_value', null, ArrayHelper::map(common\models\Features::find()->all(), 'id', 'filter_tittle'), ['prompt' => 'Select Sub Category', 'class' => 'form-control filter_value', 'id' => 'filter_value']) ?>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Generated Url</label>
								<textarea style="width:100%;" id="created_url" readonly="true"></textarea>
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
		var host = window.location.host + '/' + 'tjar/';
		var url_type = '';
		$('#url_type').change(function () {
			var type = this.value;
			if (type == 1) {
				url_type = host + 'products/index?';
			} else if (type == 2) {
				url_type = host + 'products/index?';
//				$('#products-category').attr("disabled", true);
//				$('#products-subcategory').attr("disabled", true);
			} else if (type == 3) {
				url_type = host + 'products/product-search?';
			}

			$('#created_url').html(url_type);
		});
		$('#products-category').change(function () {
			$('#created_url').html('');
			var category_id = this.value;
			var type = 1;
			category(category_id, type);

		});
		$('#products-subcategory').change(function () {
			$('#created_url').html('');
			var category_id = this.value;
			var type = 2;
			category(category_id, type);

		});
		function category(category_id, type) {
			$.ajax({
				type: 'POST',
				url: '<?= Yii::$app->homeUrl; ?>url-creation/category', //get main category
				data: {categ_id: category_id, type: type},
				success: function (data) {
					var result = JSON.parse(data);
					$('#main_category').val(result.main_categ_id);
					$("#main_category").attr("can_name", result.main_categ_cano_name);
					$("#category_").attr("can_name", result.canonical_name);
					if (type == 1) {
						url = url_type + 'main_categ=' + result.main_categ_cano_name + '&categ=' + result.canonical_name;
					} else if (type == 2) {
						url = url_type + 'main_categ=' + result.main_categ_cano_name + '&sub_categ=' + result.canonical_name;
					}

					$('#created_url').html(url);
				},
				error: function (data) {

				}
			});
		}

	});
</script>
