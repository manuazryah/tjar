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
    .tooltip{
        width: 100%;
    }
    .tool-tip-box{
        padding: 10px 20px;
    }
    .tip-box{
        padding: 10px 20px;
    }
    .default-tool-tip{
        background: #eeeeee;
        border: 1px solid #d0d0d0;
        margin-top: 50px;
    }
    .default-tool-tip h4{
        padding-left: 19px;
        padding-bottom: 5px;
        border-bottom: 1px solid #d0d0d0;
        color: black;
    }
    .tool-tip{
        opacity: 0;
        background: #eeeeee;
        border: 1px solid #d0d0d0;
    }
    .tool-tip h4{
        padding-left: 19px;
        padding-bottom: 5px;
        border-bottom: 1px solid #d0d0d0;
        color: black;
    }
</style>
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
            <div class="col-md-6" style="border-right: 1px solid #d0d0d0;">
                <div class="sell-pro-div-offerleft">
                    <h4 class="sell-offer-heading">Offer Details</h4>
                    <?=
                    $this->render('_form', [
                        'model' => $model,
                        'id' => $id,
                        'vendor_address' => $vendor_address,
                    ])
                    ?>
                </div>
            </div>
            <div class="col-md-6 sell-pro-div-offerright">
                <div class="default-tool-tip">
                    <h4>Seller Helper</h4>
                    <div class="tool-tip-box">
                        <p>The Seller Helper will help guide you with filling in accurate information about your product and your offer during the listing process.</p>
                        <p>Please read the message carefully.</p>
                        <p>Seller Helper will appear vertically alongside the fields as you land on any field.</p>
                        <p>For non-field entries, click on (?) to open the Seller Helper for that specific entry.</p>
                    </div>
                </div>
                <div class="tool-tip">

                </div>
            </div>
        </div>
    </div>
</div>

