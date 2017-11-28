<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Products */

?>
<style>
    .product-vew-pop{
        /*background: #ececec;*/
        padding: 25px 12px;
        border: 1px solid #ababab;
    }
    .pro-img-left{
        border: 1px solid;
        padding: 16px 15px;
        background: white;
    }
    .panel .panel-body {
        padding-top: 0px;
    }
    h2{
        margin-top: 0px;
        color: #272727;
        text-transform: capitalize;
    }
</style>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <?php 
                $product_vendor= common\models\ProductVendor::findOne($model->product_id);
                        $products= \common\models\Products::findOne($product_vendor->product_id);?>
                <h3 class="panel-title"><?= Html::encode($model->order_id.' - '.$products->product_name) ?></h3>


            </div>
            <div class="panel-body">
                <div class="panel-body"><div class="products-view">
                        <div class="product-vendor-view">


                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-lg-12 col-sm-12 product-vew-pop">
                                            <div class="col-md-12" style="padding-top: 15px;">

                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Comment</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($history as $hitry) { ?>
                                                            <tr>
                                                                <td><?= $hitry->date ?></td>
                                                                <td>
                                                                    <?php
                                                                    if($hitry->status =='0')
                                                                        echo 'Pending';
                                                                    if($hitry->status =='1')
                                                                        echo 'Placed';
                                                                    if($hitry->status =='2')
                                                                        echo 'Dispatched';
                                                                    if($hitry->status =='3')
                                                                        echo 'Delivered';
                                                                    ?>
                                                                </td>
                                                                <td><?= $hitry->comment ?></td>
                                                            </tr>
                                                            <?php } ?>
                                                    </tbody>
                                                </table>



                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


