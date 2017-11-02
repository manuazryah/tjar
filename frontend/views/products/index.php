<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use common\models\Products;

if (isset($product_details->meta_title) && $product_details->meta_title != '')
	$this->title = $product_details->meta_title;
else
	$this->title = $product_details->canonical_name;
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

			</div>

			<div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 product-details-right">
				<div class="container">
					<div class="row">
						<?php
						foreach ($vendor_products as $products) {
							$product_details = Products::findOne(['id' => $products->product_id]);
							$split_folder = Yii::$app->UploadFile->folderName(0, 1000, $product_details->id);
							?>
							<div class="col-md-12">
								<div style="border: 1px solid #ddd;
								     border-right: 0px;
								     border-left: 0px;">
									<div class="row" style="padding-top: 10px">
										<?php
//										$data = array();
//										$data['arabic']['product_name'] = 'product_name_arabic';
//										$data['english']['product_name'] = 'product_name';
										?>
										<h3><?= $product_details->product_name ?></h3>
										<div class="col-md--3">
											<img src="<?= Yii::$app->homeUrl . 'uploads/products/' . $split_folder . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images ?>" style="width: 150px;height:150px" alt="1" />
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>

			</div>






		</div>
	</div>
</div>
