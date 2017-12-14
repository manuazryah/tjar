<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UserAddress;

/* @var $this yii\web\View */
/* @var $model common\models\OrderMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-master-search">

	<?php
	$form = ActiveForm::begin([
		    'action' => ['index'],
		    'method' => 'get',
	]);
	?>
	<div class="product-main-form">


		<div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
			<?php $user = \common\models\User::findOne($model->user_id) ?>
			<?= Html::button($user->first_name . ' ' . $user->last_name, ['value' => Url::to(['user-view', 'id' => $user->id]), 'class' => 'modalButton edit-btn']); ?>
		</div>

		<div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
			<div class="main-left" >
				<p style="font-weight: 600;">Billing Address</p>
				<?php
				$bill_address = UserAddress::findOne($model->bill_address_id);
				?>
				<p><?= $bill_address->address . '<br/> ' . $bill_address->landmark ?></p>
				<p>Phone: <?= $bill_address->phone ?></p>
			</div>
		</div>
		<div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
			<div class="main-left" >
				<p style="font-weight: 600;">Shipping Address</p>
				<?php
				$ship_address = UserAddress::findOne($model->bill_address_id);
				?>
				<p><?= $ship_address->address . '<br/> ' . $ship_address->landmark ?></p>
				<p>Phone: <?= $ship_address->phone ?></p>
			</div>
		</div>
		<div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
			<?= $form->field($model, 'admin_status')->dropDownList(['0' => 'Pending', '1' => 'Approved'], ['options' => [$model->admin_status => ['Selected' => 'selected']], 'class' => 'form-control admin_status_field', 'id' => 'order_admin_status-' . $model->id,])->label(''); ?>
		</div>
	</div>




	<?php ActiveForm::end(); ?>

</div><br>
