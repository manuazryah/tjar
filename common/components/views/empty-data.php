<?php

use yii\helpers\Html;
?>
<div class="empty-img">
	<img class="img-responsive" src="<?= $path; ?>"/>
</div>
<h2><span><?= $msg; ?></span></h2>
<div class="col-md-12">
	<?= Html::a('<button class="green2">Continue shopping</button>', ['/site/index'], ['class' => 'button']) ?>
</div>

