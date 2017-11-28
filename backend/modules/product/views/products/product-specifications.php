<?php ?>
<?php
foreach ($features as $mod) {

	$specification_model = \common\models\Features::findOne($mod->specification);
	$value = $specification_model->tablevalue__name;
	?>
	<div class="col-md-6 col-sm-6 col-xs-12 left_padd">
		<div class="form-group field-product-feature required">
			<label class="control-label" for="products-product-feature"><?= $specification_model->filter_tittle; ?></label>
			<?php
			if ($mod->specification_type == 0) {
				$modelName = $specification_model->model_name;

				$specifiction_dropdown = $modelName::find()->where(['category' => $mod->category])->all();
//				var_dump($specifiction_dropdown);
//				echo $specifiction_dropdown;
//				exit;
				?>
				<select id="specifications[]" class="form-control" name="specifications[<?= $mod->id ?>]" aria-required="true" data-krajee-depdrop="depdrop_37f5edbf" aria-invalid="true">
					<option value="">Select...</option>
					<?php foreach ($specifiction_dropdown as $spec_val) { ?>
						<option value="<?= $spec_val->id . '_' . $spec_val->$value ?>"><?= $spec_val->$value ?></option>
					<?php } ?>
				</select>
			<?php } else { ?>
				<input type="text" id="specifications[]" class="form-control" name="specifications[<?= $mod->id ?>]" maxlength="500" aria-required="true" aria-invalid="true">
			<?php } ?>

		</div>
	</div>

<?php } ?>

