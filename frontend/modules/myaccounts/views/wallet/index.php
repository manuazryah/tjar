<?php

use yii\helpers\Html;
use common\components\LeftMenuWidget;
use common\models\User;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\widgets\ListView;

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
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marg-top-20 wallt_hist">
								<fieldset>
									<span class="info-head wallet_data" style="float:left">Your Wallet Balanace :<i><?= $user_data->wallet_amount != NULL ? $user_data->wallet_amount : '0' ?></i></span>
									<div class="clearfix"></div>
									<?= $form->field($model, 'amount')->textInput(['maxlength' => true, 'class' => '', 'placeholder' => 'Enter amount to be added in Wallet'])->label(false) ?>
									<?= Html::submitButton('Add Money to Wallet', ['class' => 'Proceed marg-btm-20']) ?>
									<!--									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 padright0 btm-padding">
									<?= $form->field($model, 'amount')->textInput(['maxlength' => true, 'class' => 'field__input field__input--zip input-width', 'placeholder' => 'Enter amount to be added in Wallet'])->label(false) ?>
																		</div>

																		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padlft0 padright0 btm-padding">
									<?= Html::submitButton('Add Money to Wallet', ['class' => 'Proceed marg-btm-20', 'style' => 'width: 25%;margin-right: 40px;']) ?>
																		</div>-->
								</fieldset>
							</div>
							<?php ActiveForm::end(); ?>
						</div>


					</div>
					<table class="order-table wallet_hstry">
                                                <thead>
                                                        <tr>

                                                                <th class=""><span class="">Date</span></th>
                                                                <th class=""><span class="">Action</span></th>
                                                                <th class=""><span class="">Deposit</span></th>
                                                                <th class=""><span class="">Withdrawl</span></th>
                                                                <th class=""><span class="">comment</span></th>
                                                        </tr>
                                                </thead>
                                                <tbody>
							<?php
							if ($dataProvider->totalCount > 0) {
								?>
								<?=
								ListView::widget([
								    'dataProvider' => $dataProvider,
								    'itemView' => 'wallet_history',
								    'pager' => [
									'firstPageLabel' => 'first',
									'lastPageLabel' => 'last',
									'prevPageLabel' => '<',
									'nextPageLabel' => '>',
									'maxButtonCount' => 3,
								    ],
								]);
								?>
								<?php
							} else {
								?>

								<?php
							}
							?>
                                                </tbody>
                                        </table>
				</div>
			</div>
		</div>
	</div>
</div>
