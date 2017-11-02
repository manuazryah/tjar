<?php

use yii\helpers\Html;
use common\components\LeftMenuWidget;

/* @var $this yii\web\View */
?>
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
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 welcome-msg">
                        <p>Hello <span><?= Yii::$app->user->identity->first_name ?></span></p>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 welcome-msg">
                        <p>From your account dashboard you can view your <?= Html::a('recent orders', ['/myaccounts/my-account/my-orders'], ['class' => '']) ?>, manage your <?= Html::a('addresses', ['/myaccounts/my-account/address'], ['class' => '']) ?> and <?= Html::a('edit your password and account details', ['/myaccounts/my-account/account-details'], ['class' => '']) ?>.</p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <?= Html::a('<i class="fa fa-gift" aria-hidden="true"></i><p>Orders</p>', ['/myaccounts/my-account/my-orders'], ['class' => 'box']) ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <?= Html::a('<i class="fa fa-map-marker" aria-hidden="true"></i><p>Reviews & Ratings</p>', ['/myaccounts/my-account/reviews'], ['class' => 'box']) ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <?= Html::a('<i class="fa fa-map-marker" aria-hidden="true"></i><p>Addresses</p>', ['/myaccounts/my-account/address'], ['class' => 'box']) ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <?= Html::a('<i class="fa fa-user" aria-hidden="true"></i><p>Account Details</p>', ['/myaccounts/my-account/account-details'], ['class' => 'box']) ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <?= Html::a('<i class="fa fa-heart" aria-hidden="true"></i><p>Wish List</p>', ['/myaccounts/my-account/wish-list'], ['class' => 'box']) ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <?php
                        echo ''
                        . Html::beginForm(['/site/logout'], 'post') . '<a class="box box-out">'
                        . Html::submitButton(
                                ' <i class="fa fa-sign-out" aria-hidden="true"></i><p>log out</p>', ['class' => 'logout-box']
                        ) . '</a>'
                        . Html::endForm()
                        . '';
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>