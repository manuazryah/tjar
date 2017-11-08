
<?php
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

		</div>
	</div>
</div>