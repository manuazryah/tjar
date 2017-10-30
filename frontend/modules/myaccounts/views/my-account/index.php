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
                        <p>From your account dashboard you can view your <a href="orders.php">recent orders</a>, manage your <a href="">shipping and billing addresses</a> and <a href="">edit your password and account details</a>.</p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <a href="orders.php" class="box">
                            <i class="fa fa-gift" aria-hidden="true"></i>
                            <p>Orders</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <a href="" class="box">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <p>Reviews & Ratings</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <a href="" class="box">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <p>Addresses</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <a href="" class="box">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <p>Account Details</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <a href="" class="box">
                            <i class="fa fa-heart" aria-hidden="true"></i>
                            <p>Wish List</p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <a href="" class="box">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            <p>log out</p>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>