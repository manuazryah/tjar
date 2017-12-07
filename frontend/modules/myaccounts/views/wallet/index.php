<?php

use yii\helpers\Html;
use common\components\LeftMenuWidget;
use common\models\User;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
?>
<style>
	.MyAccount-content .edit-account label {
		display: unset;
	}
	#personal-submit{
		display: none;
	}
	#pinfo-cancel{
		display: none;
	}
	#einfo-cancel{
		display: none;
	}
	#user-gender{
		padding-top: 8px;
	}
	button[disabled], html input[disabled] {
		cursor: default;
		background: #f1f1f1;
	}
</style>
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-t-b-30 bg-white">
			<div class="my-account-sidebar">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<h3 class="MyAccount-title">My Account</h3>
					<?= LeftMenuWidget::widget() ?>
				</div>
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<div class="MyAccount-content">
					<div class="edit-account">
						<div class="personal-info marg-btm-20">
							<?php $form = ActiveForm::begin(['id' => 'add-money', 'method' => 'post',]); ?>
							<?php if (Yii::$app->session->hasFlash('error')): ?>
								<div class="alert alert-danger" role="alert" style="
								     margin-top: 10px;    width: 96%;">
								     <?= Yii::$app->session->getFlash('error') ?>
								</div>
							<?php endif; ?>
							<?php if (Yii::$app->session->hasFlash('success')): ?>
								<div class="alert alert-success" role="alert" style="
								     margin-top: 10px;    width: 96%;">
								     <?= Yii::$app->session->getFlash('success') ?>
								</div>
							<?php endif; ?>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marg-top-20">
								<fieldset>
									<span class="info-head" style="float:left">Your Wallet Balanace:<?= $user_data->wallet_amount != NULL ? $user_data->wallet_amount : '0' ?></span>

									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 padright0 btm-padding">
										<?= $form->field($model, 'amount')->textInput(['maxlength' => true, 'class' => 'field__input field__input--zip input-width', 'placeholder' => 'Enter amount to be added in Wallet'])->label(false) ?>
									</div>

									<div class="marg-top-20">
										<?= Html::submitButton('Add Money to Wallet', ['class' => 'Proceed marg-btm-20', 'style' => 'width: 25%;margin-right: 40px;']) ?>
									</div>
								</fieldset>
							</div>
							<?php ActiveForm::end(); ?>
						</div>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>