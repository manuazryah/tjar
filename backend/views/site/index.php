<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\AdminPost;
use yii\helpers\ArrayHelper;
use common\models\OrderMaster;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminUsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<style>
    .user-info-navbar {
        margin-bottom: 0px;
    }
    .dashboard .panel-heading{
        color: white;
        border: none;
        padding-bottom: 0px;
        font-size: 15px;
        padding-left: 15px;
    }
    .dashboard .bord-right{
        border-right: 1px solid #7b7a7a;
    }
    .fbs-count{
        color:white;
        font-size: 16px;
    }
    .fbs-desc{
        font-size: 15px;
        color: rgba(255,255,255,.6);
    }
    .xe-widget.xe-counter-block .xe-lower, .xe-widget.xe-progress-counter .xe-lower {
        padding: 8px 30px;
    }
    .awaiting-action-count .xe-widget.xe-counter-block .xe-upper, .xe-widget.xe-progress-counter .xe-upper {
        background: #0288d1;
    }
    .awaiting-action-count .xe-widget.xe-counter-block, .xe-widget.xe-progress-counter {
        background: #0288d1;
    }
    .awaiting-action-count .xe-widget.xe-counter-block .xe-upper .xe-icon i, .xe-widget.xe-progress-counter .xe-upper .xe-icon i {
        background: #0288d1;
    }
    .not-shipped-count .xe-widget.xe-counter-block .xe-upper, .xe-widget.xe-progress-counter .xe-upper {
        background: #424242;
    }
    .not-shipped-count .xe-widget.xe-counter-block, .xe-widget.xe-progress-counter {
        background: #424242;
    }
    .not-shipped-count .xe-widget.xe-counter-block .xe-upper .xe-icon i, .xe-widget.xe-progress-counter .xe-upper .xe-icon i {
        background: #424242;
    }
    .returned-orders-count .xe-widget.xe-counter-block .xe-upper, .xe-widget.xe-progress-counter .xe-upper {
        background: #f4bd00;
    }
    .returned-orders-count .xe-widget.xe-counter-block, .xe-widget.xe-progress-counter {
        background: #f4bd00;
    }
    .returned-orders-count .xe-widget.xe-counter-block .xe-upper .xe-icon i, .xe-widget.xe-progress-counter .xe-upper .xe-icon i {
        background: #f4bd00;
    }
    .open-complaints-count .xe-widget.xe-counter-block .xe-upper, .xe-widget.xe-progress-counter .xe-upper {
        background: #f1453d;
    }
    .open-complaints-count .xe-widget.xe-counter-block, .xe-widget.xe-progress-counter {
        background: #f1453d;
    }
    .open-complaints-count .xe-widget.xe-counter-block .xe-upper .xe-icon i, .xe-widget.xe-progress-counter .xe-upper .xe-icon i {
        background: #f1453d;
    }
    .dashboard .prod-count h6{
        padding-left: 10px;
        text-transform: uppercase;
        font-size: 15px;
    }
    .dashboard .prod-count .panel-round{
        width: 80px;
        height: 80px;
        border-radius: 100%;
        text-align: center;
        margin: 0 auto;
        margin-top: 30px;
        margin-bottom: 15px;
    }
    .dashboard .prod-count .panel-round p{
        padding: 23px 30px;
        color: white;
        font-size: 18px;
    }
    .dashboard .prod-count .panel-round.psoldout{
        background: #a00000;
    }
    .dashboard .prod-count .panel-round.ppending{
        background: #f1453d;
    }
    .dashboard .prod-count .panel-round.plive{
        background: #169c76;
    }
    .dashboard .prod-count .panel-round.prejected{
        background: #f1453d;
    }
</style>
<div class="dashboard">
    <div class="row">
        <div class="col-md-12">
            <h4>Dashboard</h4>
            <h6 style="color: #085d9e;">Take a tour</h6>
            <!-- Default panel -->
            <div class="panel panel-default" style="border-top: 3px solid #008BFF;background: #252934;padding-left: 0px;">
                <div class="panel-heading">Fulfilled by Tjar</div>
                <div class="panel-body fbs-dashboard-widget">
                    <div class="col-md-2 bord-right">
                        <p class="fbs-count">0</p>
                        <p class="fbs-desc">Live Offers</p>
                    </div>
                    <div class="col-md-2 bord-right">
                        <p class="fbs-count">0</p>
                        <p class="fbs-desc">Pending Receiving</p>
                    </div>
                    <div class="col-md-2 bord-right">
                        <p class="fbs-count">0</p>
                        <p class="fbs-desc">Rejected Items</p>
                    </div>
                    <div class="col-md-2 bord-right">
                        <p class="fbs-count">0</p>
                        <p class="fbs-desc">Orders in Fulfillment</p>
                    </div>
                    <div class="col-md-2 bord-right">
                        <p class="fbs-count">0</p>
                        <p class="fbs-desc">Requested Returns</p>
                    </div>
                    <div class="col-md-2">
                        <p class="fbs-count">0</p>
                        <p class="fbs-desc">Open Complaints</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">

        <div class="col-sm-3 awaiting-action-count">

            <div class="xe-widget xe-counter-block" data-count=".num" data-from="0" data-to="99.9" data-suffix="%" data-duration="2">
                <div class="xe-upper">

                    <div class="xe-icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="xe-label">
                        <strong class="num">99.9%</strong>
                        <span>Awaiting Action</span>
                    </div>

                </div>
                <div class="xe-lower">
                    <div class="border"></div>
                    <span>Take Action</span>
                </div>
            </div>

        </div>

        <div class="col-sm-3 not-shipped-count">

            <div class="xe-widget xe-counter-block" data-count=".num" data-from="0" data-to="99.9" data-suffix="%" data-duration="2">
                <div class="xe-upper">

                    <div class="xe-icon">
                        <i class="fa fa-truck"></i>
                    </div>
                    <div class="xe-label">
                        <strong class="num">99.9%</strong>
                        <span>Not Shipped</span>
                    </div>

                </div>
                <div class="xe-lower">
                    <div class="border"></div>
                    <span>Take Action</span>
                </div>
            </div>

        </div>

        <div class="col-sm-3 returned-orders-count">

            <div class="xe-widget xe-counter-block" data-count=".num" data-from="0" data-to="99.9" data-suffix="%" data-duration="2">
                <div class="xe-upper">

                    <div class="xe-icon">
                        <i class="fa fa-repeat"></i>
                    </div>
                    <div class="xe-label">
                        <strong class="num">99.9%</strong>
                        <span>Returned Orders</span>
                    </div>

                </div>
                <div class="xe-lower">
                    <div class="border"></div>
                    <span>Take Action</span>
                </div>
            </div>

        </div>

        <div class="col-sm-3 open-complaints-count">

            <div class="xe-widget xe-counter-block" data-count=".num" data-from="0" data-to="99.9" data-suffix="%" data-duration="2">
                <div class="xe-upper">

                    <div class="xe-icon">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div class="xe-label">
                        <strong class="num">99.9%</strong>
                        <span>Open Complaints</span>
                    </div>

                </div>
                <div class="xe-lower">
                    <div class="border"></div>
                    <span>Take Action</span>
                </div>
            </div>

        </div>

    </div>
    <div class="row prod-count">
        <div class="col-md-3">
            <!-- Default panel -->
            <div class="panel panel-default" style="border-top: 3px solid #008BFF;padding-left: 0px;padding-top: 0px;padding-bottom: 30px;">
                <h6>Rejected</h6>
                <div class="panel-round prejected"><p>0</p></div>
                <p style="text-align: center;">View</p>
            </div>

        </div>
        <div class="col-md-3">
            <!-- Default panel -->
            <div class="panel panel-default" style="border-top: 3px solid #008BFF;padding-left: 0px;padding-top: 0px;padding-bottom: 30px;">
                <h6>Live</h6>
                <div class="panel-round plive"><p>0</p></div>
                <p style="text-align: center;">View</p>
            </div>

        </div>
        <div class="col-md-3">
            <!-- Default panel -->
            <div class="panel panel-default" style="border-top: 3px solid #008BFF;padding-left: 0px;padding-top: 0px;padding-bottom: 30px;">
                <h6>Sold Out</h6>
                <div class="panel-round psoldout"><p>0</p></div>
                <p style="text-align: center;">View</p>
            </div>

        </div>
        <div class="col-md-3">
            <!-- Default panel -->
            <div class="panel panel-default" style="border-top: 3px solid #008BFF;padding-left: 0px;padding-top: 0px;padding-bottom: 30px;">
                <h6>Pending</h6>
                <div class="panel-round ppending"><p>0</p></div>
                <p style="text-align: center;">View</p>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- Default panel -->
            <div class="panel panel-default" style="border-top: 3px solid #008BFF;padding-left: 0px;padding-top: 0px;padding-bottom: 30px;">
                <div class="stock-heading">
                    Stock Notification
                </div>
                <div  style="min-height: 210px; margin-left: 5px">
                    <table class="table">
                        <thead>
                            <tr style="text-align: center;">
                                <th width="">Product Name</th>
                                <th width="">Vendor</th>
                                <th width="">Available Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($products)) {
                                foreach ($products as $value) {
                                    $name= common\models\Products::findOne($value->product_id)->product_name;
                                    $vendor= \common\models\Vendors::findOne($value->vendor_id);
                                    ?>
                                    <tr>
                                        <td>
                                            <?php if (isset($name)) { ?>
                                                <?= $name ?>
                                                <?php
                                            } else {
                                                echo '';
                                            }
                                            ?>
                                        </td>
                                        <td><?= $vendor->first_name.' '.$vendor->last_name?></td>
                                        <td>
                                            <?php
                                            if ($value->qty == 0) {
                                                echo 'No stock';
                                            } else {
                                                echo $value->qty;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>



