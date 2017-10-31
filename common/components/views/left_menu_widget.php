<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
?>
<nav>
    <ul>
        <li class="active"><?= Html::a('Dashboard', ['/myaccounts/my-account/index'], ['class' => 'title']) ?></li>
        <li><?= Html::a('Orders', ['/myaccounts/my-account/my-orders'], ['class' => 'title']) ?></li>
        <li><?= Html::a('Reviews & Ratings', ['/myaccounts/my-account/reviews'], ['class' => 'title']) ?></li>
        <li><?= Html::a('Addresses', ['/myaccounts/my-account/address'], ['class' => 'title']) ?></li>
        <li><a href="#">Account Details</a></li>
        <li><?= Html::a('Wish List', ['/myaccounts/my-account/wish-list'], ['class' => 'title']) ?></li>
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