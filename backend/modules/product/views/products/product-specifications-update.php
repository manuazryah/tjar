<?php ?>
<?php
foreach ($specifications as $specification) {
	$product_features = \common\models\ProductFeatures::findOne($specification->product_feature_id);
	$specification_model = \common\models\Features::findOne($product_features->specification);
	$value = $specification_model->tablevalue__name;
	?>
	<div class="col-md-6 col-sm-6 col-xs-12 left_padd">
		<div class="form-group field-product-feature required">
			<label class="control-label" for="products-product-feature"><?= $specification_model->filter_tittle; ?></label>
			<?php
			if ($product_features->specification_type == 0) {
				$modelName = $specification_model->model_name;
				$specifiction_dropdown = $modelName::find()->where(['category' => $product_features->category])->all();
				?>

				<select id="specifications[]" class="form-control" name="specifications[<?= $specification->id ?>]" aria-required="true" data-krajee-depdrop="depdrop_37f5edbf" aria-invalid="true">
					<option value="">Select...</option>
					<?php
					foreach ($specifiction_dropdown as $spec_val) {
						if ($spec_val->id == $specification->product_feature_value) {
							?>
							<option selected value="<?= $spec_val->id . '_' . $spec_val->$value ?>"><?= $spec_val->$value ?></option>
						<?php } else {
							?>
							<option value="<?= $spec_val->id . '_' . $spec_val->$value ?>"><?= $spec_val->$value ?></option>
						<?php } ?>

					<?php } ?>
				</select>
			<?php } else { ?>
				<input type="text" id="specifications[]" class="form-control" name="specifications[<?= $specification->id ?>]" maxlength="500" aria-required="true" aria-invalid="true" value="<?= $specification->product_feature_value ?>">
			<?php } ?>

		</div>
	</div>

	<?php
}
if (!empty($more_features)) {

	foreach ($more_features as $more_feature) {
		$specification_model_more = \common\models\Features::findOne($more_feature->specification);
		$value = $specification_model_more->tablevalue__name;
		?>
		<div class="col-md-6 col-sm-6 col-xs-12 left_padd">
			<div class="form-group field-product-feature required">
				<label class="control-label" for="products-product-feature"><?= $specification_model_more->filter_tittle; ?></label>
				<?php
				if ($more_feature->specification_type == 0) {
					$modelName = $specification_model_more->model_name;
					$specifiction_dropdown_more = $modelName::find()->where(['category' => $more_feature->category])->all();
					?>
					<select id="specifications[]" class="form-control" name="specifications_new[<?= $more_feature->id ?>]" aria-required="true" data-krajee-depdrop="depdrop_37f5edbf" aria-invalid="true">
						<option value="">Select...</option>
						<?php foreach ($specifiction_dropdown_more as $spec_val) { ?>
							<option value="<?= $spec_val->id . '_' . $spec_val->$value ?>"><?= $spec_val->$value ?></option>
						<?php } ?>
					</select>
				<?php } else { ?>
					<input type="text" id="specifications[]" class="form-control" name="specifications_new[<?= $more_feature->id ?>]" maxlength="500" aria-required="true" aria-invalid="true" >
				<?php } ?>

			</div>
		</div>

		<?php
	}
}
?>

