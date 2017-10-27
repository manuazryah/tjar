<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductVendor */

$this->title = $product->product_name;
$this->params['breadcrumbs'][] = ['label' => 'Product Vendors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .product-vew-pop{
        background: #ececec;
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
<div class="product-vendor-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panel-body">
                <div class="col-md-12 col-lg-12 col-sm-12 product-vew-pop">
                    <div class="col-md-4" style="padding-top: 15px;">
                        <div class="pro-img-left">
                            <img src="<?= yii::$app->homeUrl; ?>images/samsung-galaxy.jpg" class="img-responsive">
                        </div>
                    </div>
                    <div class="col-md-8">
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
    </div>

</div>
