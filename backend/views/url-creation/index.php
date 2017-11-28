<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSubCategory */

$this->title = 'URL Creation';
$this->params['breadcrumbs'][] = ['label' => 'URL Creation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	.url_gen {
		position: relative;
		/*color: #27292a;*/
		/*font-size: 23px;*/
		/*display: inline-block;*/
	}
	.url_gen:hover .tooltiptext {
		visibility: visible;
	}

	.url_gen .tooltiptext {
		visibility: hidden;
		width: 55px;
		background-color: black;
		color: #fff;
		text-align: center;
		border-radius: 6px;
		padding: 5px 0;
		position: absolute;
		z-index: 1;
		font-size: 14px;

		/* Position the tooltip */
		position: absolute;
		z-index: 1;
	}
</style>
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
						<div class="col-md-4" id="sub_categg">
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
							</div>
						</div>
						<div class="col-md-4" id="search_tags">
							<div class="form-group">
								<?php
								$data_ = [];
								?>
								<label class="control-label">Search Tags</label>
								<?= Html::dropDownList('search_tags', null, $data_, ['prompt' => 'Select Tag', 'class' => 'form-control search_tag', 'id' => 'search_tag']) ?>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-md-12">

							<div class="form-group">
								<label class="control-label">Generated Url</label>
								<textarea style="float: left;
									  width: 96%;" id="created_url" readonly="true"></textarea>
								<button id="copy_url" class="url_gen" style="background-color: white;
									padding-top: 10px;
									font-size: 24px;
									float: right;"><i class="fa fa-clipboard" aria-hidden="true"><span class="tooltiptext">copy url</span></i></button>
								<!--								<button id="refresh" class="url_gen" style="background-color: white;
																	padding-top: 11px;
																	padding-right: 20px;
																	font-size: 24px;
																	float: right;"><i class="fa fa-refresh" aria-hidden="true"><span class="tooltiptext">refresh form</span></i></button>-->
							</div>

						</div>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?= yii::$app->homeUrl; ?>/js/url_creation.js"></script>
