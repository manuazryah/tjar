<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
?>
<?php $action = Yii::$app->controller->id . '/' . Yii::$app->controller->action->id; ?>
<nav>
	<ul>
		<li class="<?= $action == 'my-account/index' ? 'active' : '' ?>"><?= Html::a('Dashboard', ['/myaccounts/my-account/index'], ['class' => 'title']) ?></li>
		<li class="<?= $action == 'my-account/my-orders' ? 'active' : '' ?>"><?= Html::a('Orders', ['/myaccounts/my-account/my-orders'], ['class' => 'title']) ?></li>
		<li class="<?= $action == 'my-account/reviews' ? 'active' : '' ?>"><?= Html::a('Reviews & Ratings', ['/myaccounts/my-account/reviews'], ['class' => 'title']) ?></li>
		<li class="<?= $action == 'my-account/address' ? 'active' : '' ?>"><?= Html::a('Addresses', ['/myaccounts/my-account/address'], ['class' => 'title']) ?></li>
		<li class="<?= $action == 'my-account/account-details' ? 'active' : '' ?>"><?= Html::a('Account Details', ['/myaccounts/my-account/account-details'], ['class' => 'title']) ?></li>
		<li class="<?= $action == 'my-wallet' ? 'active' : '' ?>"><?= Html::a('My Wallet', ['/my-wallet'], ['class' => 'title']) ?></li>
		<!--<li class="<?= $action == 'my-account/wish-list' ? 'active' : '' ?>"><?= Html::a('Wish List', ['/myaccounts/my-account/wish-list'], ['class' => 'title']) ?></li>-->
		<?php
		echo '<li class="">'
		. Html::beginForm(['/site/logout'], 'post') . '<a>'
		. Html::submitButton(
			'Log Out', ['class' => 'account-logout']
		) . '</a>'
		. Html::endForm()
		. '</li>';
		?>
	</ul>
</nav>