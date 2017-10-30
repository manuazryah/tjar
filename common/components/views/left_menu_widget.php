<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
?>
<nav>
    <ul>
        <li class="active"><?= Html::a('Dashboard', ['/myaccounts/my-account/index'], ['class' => 'title']) ?></li>
        <li><a href="orders.php">orders</a></li>
        <li><a href="reviews-ratings.php">Reviews & Ratings</a></li>
        <li><?= Html::a('Addresses', ['/myaccounts/my-account/address'], ['class' => 'title']) ?></li>
        <li><a href="account-details.php">Account Details</a></li>
        <li><a href="wishlist.php">Wish List</a></li>
        <li><a>Log Out</a></li>
    </ul>
</nav>