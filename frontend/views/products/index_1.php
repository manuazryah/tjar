<?php

use yii\helpers\Html;
use common\models\ProductCategory;
use common\models\Features;
use yii\widgets\Pjax;

if (!empty($categ)) {
	$category = ProductCategory::findOne(['id' => $categ]);
	$min_amount = $category->min_amount;
	$max_amount = $category->max_amount;
}
?>


<div id="product-page">
	<div class="container">
		<div class="row">

			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 padright10">

				<div class="breadcrumb bg-white hidden-lg hidden-md hidden-sm">
					<ol class="path">
						<li><a href="index.php">Home</a></li>
						<li><a href="#">About Us</a></li>
						<li class="active">products</li>
					</ol>
					<p class="current-page">products</p>
				</div>

				<div class="left-menu">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h4 class="heading">Product Categories</h4>

						<div class="panel-group" id="accordion">


							<?php
							$j = 0;
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
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?= $j ?>">
												<?= $feature_detail->filter_tittle ?>
											</a>
										</h4>
									</div><!--/.panel-heading -->

									<div id="collapse_<?= $j ?>" class="panel-collapse collapse">
										<div class="panel-body">

											<form>
												<?php
												foreach ($filter_values as $filter_value) {
													if ($feature_detail->canonical_name == 'brand') {
														?>
														<label for="mi">
															<input type="checkbox" class="test"id="<?= $feature_detail->canonical_name . '_' . $filter_value->brand_name ?>" value="" name="<?= $filter_value->brand_name ?>"/>
															<!--<input type="checkbox" id="mi" name="mi" value="1" >-->
															<?= $filter_value->brand_name ?>
														</label>
														<?php
													} else {
														?>
														<label for="mi">
															<input type="checkbox" class="test"id="<?= $feature_detail->canonical_name . '_' . $filter_value->value ?>" value="" name="<?= $filter_value->value ?>"/>
															<!--<input type="checkbox" id="mi" name="mi" value="1" >-->
															<?= $filter_value->value ?>
														</label>
														<?php
													}
												}
												?>

											</form>

										</div><!--/.panel-body -->
									</div><!--/.panel-collapse -->

								</div><!-- /.panel -->
								<?php
								$j++;
							}
							?>





						</div><!-- /.panel-group -->

					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marg-top-20">
						<h4 class="heading">Filter by Price</h4>
						<input type="hidden" id="amount_min" value="<?= $min_amount ?>" />
						<input type="hidden" id="categ_min" value="<?= $min_amount ?>" />
						<input type="hidden" id="categ_max" value="<?= $max_amount ?>" />
						<input type="hidden" id="amount_max"  value="<?= $max_amount ?>"/>
						<div id="slider-container"></div>
						<p class="slider-values">
						    <!--<input type="text" id="amount" />-->

							<span class="min_value" id="min"></span>
							<span class="max_value" id="max"></span>
						</p>


					</div>


				</div>
			</div>

			<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 right-section padlft-rit0">

				<div class="breadcrumb bg-white hidden-xs">
					<ol class="path">
						<li><a href="index.php">Home</a></li>
						<li><a href="#">About Us</a></li>
						<li class="active">products</li>
					</ol>
					<p class="current-page">products</p>
				</div>

				<div class="bg-white">
					<?php
					Pjax::begin(['id' => 'product_view',
					    'clientOptions' => ["push" => true, "replace" => false, "timeout" => 5500, "scrollTo" => false, "container" => "#pjax-page-container"]]);
					?>
					<ul class="">

						<?php
						$i = 0;
						foreach ($dataProvider as $model) {

							$product_details = \common\models\Products::findOne($model->product_id);
							$split_folder = Yii::$app->UploadFile->folderName(0, 1000, $product_details->id);
							?>

							<li class="<?= $i == 0 ? 'active' : '' ?>">
								<div class="item col-lg-3 col-md-3 col-sm-6 col-xs-6">
									<div class="pad10">
										<a href="#">
											<div class="product-img">
												<?php echo Html::img(Yii::$app->homeUrl . "uploads/products/" . $split_folder . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images, ['class' => 'img-responsive mainimg']); ?>
												<?php echo Html::img(Yii::$app->homeUrl . "uploads/products/" . $split_folder . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images, ['class' => 'img-responsive hovrimg']); ?>
	<!--												<img class="img-responsive mainimg" src="<?= Yii::$app->homeUrl; ?>images/product1.png"/>
												<img class="img-responsive hovrimg" src="<?= Yii::$app->homeUrl; ?>images/product2.png"/>-->
											</div>
											<h3 class="product-name"><?= $product_details->product_name ?></h3>
											<?php if (!empty($model->offer)) { ?>
												<h5 class="product-discount">Upto <?= $model->offer ?>% off</h5>
											<?php } ?>
											<h6 class="actual-price">QAR&nbsp;<?= $model->price ?>
												<?php if (!empty($model->offer)) { ?>
													<span class="old-price">/ <strike>QAR&nbsp;<?= $model->offer_price ?></strike></span></h6>
											<?php } ?>
										</a>
									</div>
								</div>
							</li>

							<?php
							$i++;
						}
						?>



					</ul>


					<div class="sld-btn text-center col-lg-12">
						<div class="">
							<button class="btn btn-primary prv" type="submit"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
							<ol class="pagenation"></ol>
							<button class="btn btn-primary pull-right next" type="submit"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
						</div>
					</div>
					<?php \yii\widgets\Pjax::end(); ?>
				</div>

			</div>
		</div>

	</div>
</div>
<!--</div>-->
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
					$("#min").text(min_);
					$("#max").text(max_);
				},
				slide: function (event, ui) {
					$("#min").text(ui.values[0]);
					$("#max").text(ui.values[1]);
					$("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
				},
				change: function (event, ui) {
					var url = window.location.href;
					$("#min").text(ui.values[0]);
					$("#max").text(ui.values[1]);
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
					$.pjax({container: '#product_view', url: url});




				}


			});

		});



		//set initial state.
		$(".test").change(function () {
			var ischecked = $(this).is(':checked');

			if (ischecked) {
				var params = this.id.split('_');
				console.log(params);
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