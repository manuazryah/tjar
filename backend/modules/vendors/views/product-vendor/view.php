<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductVendor */

$this->title = $model->product->product_name;
$this->params['breadcrumbs'][] = ['label' => 'Product Vendors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	.sell-pro-div-right p{
                border-bottom: 1px solid #e8e5e5;
                padding-bottom: 5px;
                font-size: 12px;
        }
        .sell-pro-div-right p span{
                color: #4a4949;
		font-size: 12px;
        }
	.outer {
		width: 257px;
		border: 1px solid #312e2e59;
		overflow: hidden;
		height: 250px;
		position: relative;
		background-color: white;
	}
	.inner {
		float: left;
		position: relative;
		left: 50%;
	}
	.inner img {
		display: block;
		position: relative;
		left: -50%;
		height: 250px;
		padding: 12px;
	}
	.manage {
		position: relative;
		/*display: inline-block;*/
	}
	.manage:hover .tooltiptext {
		visibility: visible;
	}

	.manage .tooltiptext {
		padding-left: 0px !important;
		padding-right:  0px !important;
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

	<div class="panel panel-default">
		<div class="panel-heading" style="border-bottom: none;">
			<div>
				<h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
				<!--<span class="product_venode_view_span"><?= !empty($model->sku) ? '<br>EAN:' . $model->sku : '' ?></span>-->
			</div>


			<div style="float:left;padding-top: 13px;">
				<?= Html::a('<i class="fa-th-list manage"><span class="tooltiptext">List All</span></i>', ['index'], ['class' => 'btn btn-icon product_venode_view_btns']) ?>
				<?php // Html::a('<i class="fa-trash-o manage"><span class="tooltiptext">Delete</span></i>', ['delete', 'id' => $model->id], ['class' => 'btn btn-icon product_venode_view_btns']) ?>
				<?= Html::a('<i class="manage">pause</i>', ['index'], ['class' => 'btn btn-icon btn-success']) ?>

			</div>
			<div style="float:right">

			</div>

		</div>
		<div class="panel-body" style="border: 1px solid; margin-top: 21px;padding: 19px 0px;">
			<div style="text-align: right; padding-right: 21px;">
				<p style="padding: 8px 0px;
				   font-size: 11px;"><?= $model->product->mainCategory->name . ' > ' . $model->product->categoryName->category_name . ' > ' . $model->product->subCategoryName->subcategory_name ?></p>
			</div>
			<div class="col-md-3 col-lg-3 col-sm-12 product-vew-pop">

				<div class="outer">
					<div class="inner">
						<?php
						$profile_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $model->product_id) . '/' . $model->product_id . '/profile/' . $model->product->canonical_name . '.' . $model->product->gallery_images;
						if (file_exists($profile_image)) {
							?>
							<img src="<?= Yii::$app->homeUrl . '../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $model->product_id) . '/' . $model->product_id . '/profile/' . $model->product->canonical_name . '.' . $model->product->gallery_images ?>" class="img-responsive"></div>

					<?php } else { ?>
						<img src="<?= yii::$app->homeUrl; ?>images/gallery_dummy.png" class="img-responsive">

					<?php } ?>

				</div>
				<div style="padding-top:17px">

					<div class="sell-pro-div-right">

						<?php
						foreach ($product_specifications as $specification) {
							if (isset($specification->Product_feature_text) && $specification->Product_feature_text != '') {
								$product_features = \common\models\ProductFeatures::findOne($specification->product_feature_id);
								$specification_model = \common\models\Features::findOne($product_features->specification);
								$value = $specification_model->tablevalue__name;
								?>
								<p><?= $specification_model->filter_tittle; ?>: <span><?= $specification->Product_feature_text ?></span></p>

								<?php
							}
						}
						?>
					</div>
				</div>


			</div>
			<div class="col-md-9">
				<div class="panel panel-default" style="padding-top: 0px !important;">
					<div class="panel-body" style="padding-top:0px !important">
						<div class="col-md-6" style="border-right: 1px solid #d0d0d0;">
							<div class="sell-pro-div-offerleft">
								<?=
								$this->render('_form2', [
								    'model' => $model,
								    'id' => $id,
								    'vendor_address' => $vendor_address,
								])
								?>
							</div>
						</div>
						<div class="col-md-6 sell-pro-div-offerright">
							<div class="default-tool-tip">
								<h4>Seller Helper</h4>
								<div class="tool-tip-box">
									<p>The Seller Helper will help guide you with filling in accurate information about your product and your offer during the listing process.</p>
									<p>Please read the message carefully.</p>
									<p>Seller Helper will appear vertically alongside the fields as you land on any field.</p>
									<p>For non-field entries, click on (?) to open the Seller Helper for that specific entry.</p>
								</div>
							</div>
							<div class="tool-tip">

							</div>
						</div>
					</div>
				</div>
			</div>





		</div>
	</div>

</div>



