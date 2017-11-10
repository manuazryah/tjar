<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductVendor */

$this->title = $product->product_name;
?>
<style>
        .product-vew-pop{
                /*background: #ececec;*/
                padding: 25px 12px;
                border: 1px solid #ababab;
        }
        .pro-img-left{
                border: 1px solid;
                padding: 16px 15px;
                background: white;
        }
        .panel .panel-body {
                padding-top: 0px;
        }
        h2{
                margin-top: 0px;
                color: #272727;
                text-transform: capitalize;
        }
</style>
<div class="product-vendor-view">

        <h2><?= Html::encode($this->title) ?></h2>

        <div class="panel panel-default">
                <div class="panel-body">
                        <div class="panel-body">
                                <div class="col-md-12 col-lg-12 col-sm-12 product-vew-pop">
                                        <div class="col-md-4" style="padding-top: 15px;">

						<?php
						$profile_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $model->id) . '/' . $model->id . '/profile/' . $model->canonical_name . '.' . $model->gallery_images;
						if (file_exists($profile_image)) {
							?>
							<img src="<?= Yii::$app->homeUrl . '../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $model->id) . '/' . $model->id . '/profile/' . $model->canonical_name . '.' . $model->gallery_images ?>" class="img-responsive">

						<?php } else { ?>
							<img src="<?= yii::$app->homeUrl; ?>images/gallery_dummy.png" class="img-responsive">

						<?php } ?>
						<div class="clearfix"></div>
						<div style="padding: 11px;">
							<?php
							$gallery_path = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $model->id) . '/' . $model->id . '/gallery_thumb';
							foreach (glob("{$gallery_path}/*") as $file) {
								$arry = explode('/', $file);
								?>
								<img srcset = "<?= Yii::$app->homeUrl . '../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $model->id) . '/' . $model->id . '/gallery_thumb' . '/' . end($arry) ?>" alt = "no-image" img-name = "<?= end($arry) ?>">
							<?php }
							?>
						</div>




                                        </div>
                                        <div class="col-md-8">
						<?=
						DetailView::widget([
						    'model' => $model,
						    'attributes' => [
							'product_name',
							'product_name_arabic',
							'canonical_name',
							    [
							    'attribute' => 'main_category',
							    'value' => $model->mainCategory->name,
							],
							    [
							    'attribute' => 'category',
							    'value' => $model->categoryName->category_name,
							],
							    [
							    'attribute' => 'subcategory',
							    'value' => $model->subCategoryName->subcategory_name,
							],
							    [
							    'attribute' => 'brand',
							    'value' => $model->brandName->brand_name,
							],
							'item_ean',
							'gender',
							'main_description:ntext',
							'main_description_arabic:ntext',
							'highlights:ntext',
							'highlights_arabic:ntext',
							    [
							    'attribute' => 'search_tags',
							    'format' => 'raw',
							    'value' => function ($model) {

							    },
							],
						    ]
						]);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
