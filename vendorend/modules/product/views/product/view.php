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
                                                        <?php
                                                        $product_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '.' . $product->gallery_images;
                                                        if (file_exists($product_image)) {
                                                                ?>
                                                                <img src="<?= Yii::$app->homeUrl . '../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '.' . $product->gallery_images ?>" class="img-responsive">

                                                        <?php } else { ?>
                                                                <img src="<?= yii::$app->homeUrl; ?>images/gallery_dummy.png" class="img-responsive">

                                                        <?php } ?>
                                                </div>
                                        </div>
                                        <div class="col-md-8">
                                                <h3 class="sell-pro-heading"><?= $product_model->product_name ?></h3>
                                                <?php
                                                foreach ($product_specifications as $specification) {
                                                        if (isset($specification->Product_feature_text) && $specification->Product_feature_text != '') {
                                                                $product_features = \common\models\ProductFeatures::findOne($specification->product_feature_id);
                                                                $specification_model = \common\models\Features::findOne($product_features->specification);
                                                                $value = $specification_model->tablevalue__name;
                                                                ?>
                                                                <p><?= $specification_model->filter_tittle; ?>: <span><?= $specification->Product_feature_text ?></span></p>

                                                                <?php
                                                        }
                                                }
                                                ?>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>

</div>
