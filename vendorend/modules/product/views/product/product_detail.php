<?php

use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
    .sell-pro-div-left{
        border: 1px solid #e8e5e5;
        padding: 15px;
    }
    .sell-pro-heading{
        margin-top: 0px;
        text-transform: uppercase;
        color: #4a4949;
    }
    .sell-offer-heading{
        margin-top: 0px;
        color: #4a4949;
        font-weight: bold;
        margin-bottom: 25px;
    }
    .sell-pro-div-right{

    }
    .sell-pro-div-right p{
        border-bottom: 1px solid #e8e5e5;
        padding-bottom: 5px;
        font-size: 15px;
    }
    .sell-pro-div-right p span{
        color: #4a4949;
    }
    .sell-this-button {
        text-align: center;
        /*background: #0070CC;*/
        color: white;
        border: #0070CC;
    }
    .button.tiny, button.tiny {
        background-color: #0070CC;
        padding:0px 23px !important;
        border-radius: 2px;
        line-height: 35px;
        color: white;
    }
</style>
<div class="row">
    <div class="small-22 medium-22 large-22 columns"><h5 class="ng-binding">Xiaomi Mi A1 Dual Sim - 64 GB, 4GB RAM, 4G LTE, Gold</h5><div class="offer-detailes-info"><span class="offerBy"><span class="light-gray ng-binding">EAN:</span><span class="ng-binding">2724467876593</span></span></div></div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="small-24 columns sell-this-button">
                <?= Html::a('<button type="button" class="tiny ng-binding" >Sell This Product</button>', ['/product/product/sell-product', 'id' => $id]) ?>
                <!--<button type="button" class="tiny ng-binding" >Sell This Product</button></div>-->
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="panel-body">
            <div class="col-md-4">
                <div class="sell-pro-div-left">
                    <img src="<?= yii::$app->homeUrl; ?>images/samsung-galaxy.jpg" class="img-responsive">
                </div>
            </div>
            <div class="col-md-8 sell-pro-div-right">
                <h3 class="sell-pro-heading"><?= $product_model->product_name ?></h3>
                <p>Brand: <span>samsung</span></p>
                <p>Color: <span>["black"]</span></p>
                <p>Operating System Type: <span>android</span></p>
                <p>Storage Capacity: <span>["64 gb"]</span></p>
                <p>Rear Camera Resolution: <span>12 mp</span></p>
                <p>Mobile Phone Type: <span>smartphone</span></p>
                <p>Battery Capacity in mAh: <span>3000 mah & above</span></p>
                <p>Memory RAM: <span>4 gb</span></p>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="panel-body">
            <div class="col-md-6">
                <div class="sell-pro-div-offerleft">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>adasd</td>
                                <td>adasd</td>
                            </tr>
                            <tr>
                                <td>adasd</td>
                                <td>adasd</td>
                            </tr>
                            <tr>
                                <td>adasd</td>
                                <td>adasd</td>
                            </tr>
                            <tr>
                                <td>adasd</td>
                                <td>adasd</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="col-md-6 sell-pro-div-offerright">
            </div>
        </div>
    </div>
</div>

