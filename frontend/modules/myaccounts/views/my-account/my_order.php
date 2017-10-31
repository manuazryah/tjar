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
                    <h3 class="MyAccount-title">Orders</h3>
                    <?= LeftMenuWidget::widget() ?>
                </div>
            </div>

            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="MyAccount-content">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th class=""><span class="">Order</span></th>
                                <th class=""><span class="">Date</span></th>
                                <th class=""><span class="">Status</span></th>
                                <th class=""><span class="">Total</span></th>
                                <th class=""><span class="">Actions</span></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="">
                                <td class="" data-title="Order">
                                    <div class="media">
                                        <a style="margin: 0 auto; float: none;" class="thumbnail col-lg-5 col-md-6 col-sm-6 col-xs-6" href="#"> <img class="media-object" src="<?= yii::$app->homeUrl; ?>images/products/1.png"> </a>
                                    </div>
                                </td>
                                <td class="" data-title="Date">
                                    <time datetime="2017-10-24T09:25:49+00:00">October 24, 2017</time>
                                </td>
                                <td class="" data-title="Status">
                                    Processing
                                </td>
                                <td class="" data-title="Total">
                                    <span class=""><span class="">AED </span>200.00</span> for 1 item
                                </td>
                                <td class="" data-title="Actions">
                                    <a href="" class="track">Track</a>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="" data-title="Order">
                                    <div class="media">
                                        <a style="margin: 0 auto; float: none;" class="thumbnail col-lg-5 col-md-6 col-sm-6 col-xs-6" href="#"> <img class="media-object" src="<?= yii::$app->homeUrl; ?>images/products/1.png"> </a>
                                    </div>
                                </td>
                                <td class="" data-title="Date">
                                    <time datetime="2017-10-24T09:25:49+00:00">October 24, 2017</time>
                                </td>
                                <td class="" data-title="Status">
                                    Processing
                                </td>
                                <td class="" data-title="Total">
                                    <span class=""><span class="">AED </span>200.00</span> for 1 item
                                </td>
                                <td class="" data-title="Actions">
                                    <a href="" class="track">Track</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>