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
	<div class="row">
                <div class="col-md-10">
                        <div class="panel panel-default">
                                <div class="panel-body">
                                        <div class="panel-body">
                                                <div class="col-md-4">
                                                        <div class="sell-pro-div-left">
								<?php
								$product_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_model->id) . '/' . $product_model->id . '/profile/' . $product_model->canonical_name . '.' . $product_model->gallery_images;
								if (file_exists($product_image)) {
									?>
									<img src="<?= Yii::$app->homeUrl . '../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_model->id) . '/' . $product_model->id . '/profile/' . $product_model->canonical_name . '.' . $product_model->gallery_images ?>" class="img-responsive">
								<?php } else { ?>
									<img src="<?= yii::$app->homeUrl; ?>images/gallery_dummy.png" class="img-responsive">
								<?php } ?>
                                                        </div>
                                                </div>
                                                <div class="col-md-8 sell-pro-div-right">
                                                        <h5 class="sell-pro-heading"><?= $product_model->product_name ?></h5>


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
        <div class="panel panel-default">
                <div class="panel-body">
                        <div class="panel-body">

                                <div class="panel panel-default">
                                        <div class="panel-body">
                                                <div class="small-24 columns sell-this-button">
							<?= Html::a('<button type="button" class="tiny ng-binding" >Sell This Product</button>', ['/product/product/sell-product', 'id' => $id]) ?>
							<?php $action = '../../product-detail/' . $product_model->canonical_name; ?>
							<?= Html::a('<button type="button" class="tiny ng-binding" >Product Preview</button>', [$action], ['target' => '_blank']) ?>
                                                        <!--<button type="button" class="tiny ng-binding" >Sell This Product</button></div>-->
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>

</div>


