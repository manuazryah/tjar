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
												<img src="<?= Yii::$app->homeUrl . 'uploads/products/' . $split_folder . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images ?>" style="width: 150px;height:150px" alt="1" />
											</div>
											<div class="col-md-9">
												<span>Price:<?= $model->price; ?></span>
											</div>

										</div>
									</div>
								</div>
								<?php
							}
//							$dataProvider->totalcount > 0 ? ListView::widget([
//								    'dataProvider' => $dataProvider,
//								    'itemView' => '_view',
//								    'pager' => [
//									'firstPageLabel' => 'first',
//									'lastPageLabel' => 'last',
//									'prevPageLabel' => '<',
//									'nextPageLabel' => '>',
//									'maxButtonCount' => 5,
//								    ],
//								]) : $this->render('no_product');
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


	});
</script>
