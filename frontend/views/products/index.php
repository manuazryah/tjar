<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use common\models\Products;
use yii\widgets\ListView;
use common\models\Features;

//if (isset($product_details->meta_title) && $product_details->meta_title != '')
//	$this->title = $product_details->meta_title;
//else
//	$this->title = $product_details->canonical_name;
//$this->params['breadcrumbs'][] = $this->title;
//echo $categ;
//exit;
if (!empty($categ)) {
	$category = \common\models\ProductCategory::findOne(['id' => $categ]);
	$min_amount = $category->min_amount;
	$max_amount = $category->max_amount;
}
?>

<style>
	.product-details-right{
		height:auto !important;
	}

</style>


<div id="product-detail" >
	<div class="container">
		<div class="row">

			<div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 product-img-view-box">
				<div id="slider-container"></div>
				<p>
				<h4 class="heading">Filter by Price</h4>
				<input type="text" id="amount" style="border: 0; color: #f6931f; font-weight: bold;" />
				<input type="hidden" id="amount_min" value="<?= $min_amount ?>" />
				<input type="hidden" id="categ_min" value="<?= $min_amount ?>" />
				<input type="hidden" id="categ_max" value="<?= $max_amount ?>" />
				<input type="hidden" id="amount_max"  value="<?= $max_amount ?>"/>
				</p>

				<div id="slider-range"></div>

				<?php
				foreach ($filters as $value) {
					$feature_detail = Features::findOne($value->features);
					$model_name = $feature_detail->model_name;

					if (!empty($categ))
						$filter_values = $model_name::find()->where(['category' => $categ])->all();
					elseif (!empty($sub_categ))
						$filter_values = $model_name::find()->where(['subcategory' => $sub_categ])->all();
					elseif (!empty($categ) && !empty($sub_categ))
						$filter_values = $model_name::find()->where(['category' => $categ, 'subcategory' => $sub_categ])->all();
					?>
					<h6><?= $feature_detail->filter_tittle ?></h6>
					<?php
					foreach ($filter_values as $filter_value) {

						if ($feature_detail->canonical_name == 'brand') {
							?><input type="checkbox" class="test"id="<?= $feature_detail->canonical_name . '_' . $filter_value->brand_name ?>" value="" name="<?= $filter_value->brand_name ?>"/> <?= $filter_value->brand_name ?><br />

							<?php
						} else {
							?>
							<input type="checkbox" class="test"id="<?= $feature_detail->canonical_name . '_' . $filter_value->value ?>" value="" name="<?= $filter_value->value ?>"/> <?= $filter_value->value ?><br />
							<?php
						}
					}
				}
				?>


			</div>

			<div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 product-details-right">
				<div class="container">
					<div class="row">
						<div class="col-md-9 product-list" style="height: auto">
							<?php \yii\widgets\Pjax::begin(['id' => 'product_view']); ?>

							<?php
							foreach ($dataProvider as $model) {
								$product_details = \common\models\Products::findOne($model->product_id);
								$split_folder = Yii::$app->UploadFile->folderName(0, 1000, $product_details->id);
								?>
								<div class="col-md-12">
									<div style="border: 1px solid #ddd;
									     border-right: 0px;
									     border-left: 0px;">
										<div class="row" style="padding-top: 10px">

											<h3><?= $product_details->product_name ?></h3>

											<div class="col-md-3">
												<img src="<?= Yii::$app->homeUrl . 'uploads/products/' . $split_folder . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images ?>?<?= rand() ?>" style="width: 150px;height:150px" alt="1" />
											</div>
											<div class="col-md-9">
												<span>Price:<?= $model->price; ?></span>
											</div>

										</div>
									</div>
								</div>
								<?php
							}
							?>
							<?php \yii\widgets\Pjax::end(); ?>


						</div>

					</div>
				</div>

			</div>






		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		var base = window.location.href;
		checkparameters(base);

		$("#amount").val("$" + paramss('min-range') + '-$' + paramss('max-range'));
		if (paramss('min-range') != null && paramss('max-range') != null) {
			$('#amount_min').val(paramss('min-range'));
			$('#amount_max').val(paramss('max-range'));
		}
		$(function () {

			var min_ = $('#amount_min').val();
			var max_ = $('#amount_max').val();
			var max_categ = $('#categ_max').val();
			var max_1 = parseInt(max_categ) + 1000;
			$('#slider-container').slider({
				range: true,
				min: Math.ceil($('#categ_min').val()),
				max: Math.ceil(max_1),
				values: [min_, max_],
				create: function () {
					$("#amount").val("$" + min_ + '-$' + max_);
				},
				slide: function (event, ui) {
					$("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
				},
				change: function (event, ui) {
					var url = window.location.href;

					$("#amount").val(ui.values[0] + "-" + ui.values[1]);
					var min_value = paramss('min-range');
					var max_value = paramss('max-range');
					if (window.location.href.indexOf("min-range") > -1) {
						var re = new RegExp('&min-range=' + min_value + '&max-range=' + max_value);
						var newUrl = window.location.href;
						var url = newUrl.replace(re, '');
					}
					var cahracter = url.charAt(url.length - 1);
					if (cahracter === '&') {
						url = url + 'min-range' + '=' + ui.values[0] + '&max-range=' + ui.values[1];
					} else {
						url = url + '&' + 'min-range' + '=' + ui.values[0] + '&max-range=' + ui.values[1];
					}
					$.pjax({container: '#product_view', url: url, timeout: 5000});




				}


			});

		});



		//set initial state.
		$(".test").change(function () {
			var ischecked = $(this).is(':checked');

			if (ischecked) {

				var params = this.id.split('_');
				var arr = '';
				var url = window.location.href;

				if (url.indexOf('?') > -1) {
					if (window.location.search.indexOf(params[0] + '=' + params[1]) > -1) {
					} else {
						$('input.test:checkbox:checked').each(function () {
							var param = $(this).attr('id').split('_');
							var value = param[0] + '=' + param[1];
							arr += value + '&';
						});
						if (window.location.href.indexOf("min-range") > -1) {

						} else {
							if (paramss('min-range') != null && paramss('max-range') != null) {
								arr += 'min-range=' + paramss('min-range') + '&max-range=' + paramss('max-range');
							}
						}

						var cahracter = base.charAt(base.length - 1);
						if (cahracter === '&') {
							url = base + arr;
						} else {
							url = base + '&' + arr;
						}
						$.pjax({container: '#product_view', url: url});
					}

				} else {
					url += '';
				}
			} else {
				var params = this.id.split('_');

				var re = new RegExp('&' + params[0] + '=' + params[1]);
				var newUrl = window.location.href;
				var url = newUrl.replace(re, '');
				$.pjax({container: '#product_view', url: url});

			}
		});
		function paramss(name) {
			var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
			if (results == null) {
				return null;
			} else {
				return decodeURI(results[1]) || 0;
			}
		}
		function checkparameters(url) {
			var arguments = url.split('&');
//			console.log(arguments);
			$.each(arguments, function (index, value) {
				var paramtersplit = value.split('=');
				var namess = paramtersplit[0] + '_' + paramtersplit[1];
				if (document.getElementById(namess)) {
					$('#' + namess).prop('checked', true);

				}

			});
		}


	});
</script>
