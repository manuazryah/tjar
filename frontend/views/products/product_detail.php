<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\RecentlyViewedWidget;
use common\components\RelatedProductWidget;

if (isset($product_details->meta_title) && $product_details->meta_title != '')
        $this->title = $product_details->meta_title;
else
        $this->title = $product_details->canonical_name;
?>
<div id="product-detail">
        <div class="container">
                <div class="row">

                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 product-img-view-box">

                                <div id="affix">
                                        <div class="app-figure" id="zoom-fig">

                                                <?php
                                                /* show profile image */
                                                $product_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images;
                                                if (file_exists($product_image)) {
                                                        ?>
                                                        <a id="Zoom-1" class="MagicZoom" title="" href="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images ?>">
                                                                <img src="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images ?>?scale.height=400" alt=""/>
                                                                <?php
                                                                if (isset($vendor_product->offer_price) && $vendor_product->offer_price != "0") {
                                                                        $percentage = round(100 - (($vendor_product->offer_price / $vendor_product->price) * 100));
                                                                        ?>
                                                                        <div class="offer-tag">
                                                                                <img src="<?= Yii::$app->homeUrl ?>/images/offer-tag-bg.png"/><span><?= $percentage ?>% OFF</span>
                                                                        </div>
                                                                <?php } ?>
                                                        </a>
                                                <?php } else { ?>

                                                        <a id="Zoom-1" class="MagicZoom" title="" href="#">
                                                                <img src="<?= Yii::$app->homeUrl . 'uploads/products/gallery_dummy.png' ?>?scale.height=400" alt=""/>

                                                        </a>
                                                <?php } ?>

                                                <div class="selectors">


                                                        <?php
                                                        /* show gallery images */
                                                        $path = Yii::getAlias('@paths') . '/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/gallery_thumb';
                                                        if (file_exists($product_image)) {
                                                                if (count(glob("{$path}/*")) > 0) {
                                                                        $k = 0;
                                                                        foreach (glob("{$path}/*") as $file) {
                                                                                if ($k <= '4') {
                                                                                        $k++;
                                                                                        $arry = explode('/', $file);
                                                                                        $img_nmee = end($arry);
                                                                                        $img_nmees = explode('.', $img_nmee);
                                                                                        if ($img_nmees['1'] != '') {
                                                                                                ?>

                                                                                                <a
                                                                                                        data-zoom-id="Zoom-1"
                                                                                                        href="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/gallery/' . end($arry) ?>"
                                                                                                        data-image="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/gallery/' . end($arry) ?>?scale.height=400"
                                                                                                        >
                                                                                                        <img srcset="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/gallery_thumb/' . end($arry) ?>?scale.width=112 2x" src="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/gallery_thumb/' . end($arry) ?>?scale.width=56"/>
                                                                                                </a>
                                                                                                <?php
                                                                                        }
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                        ?>



                                                </div>
                                                <div class="function-btn">
                                                        <?= Html::a('<button class="start-shopping">add to cart</button>', '#', ['class' => 'add_to_cart', 'id' => yii::$app->EncryptDecrypt->Encrypt('encrypt', $vendor_product->id)]) ?>
                                                        <!--<a href="cart.php"><button class="start-shopping">add to cart</button></a>-->
                                                        <a href="#"><button class="start-shopping">Buy now</button></a>
                                                </div>
                                        </div>
                                </div>
                        </div>

                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 product-details-right">
                                <div class="breadcrumb">
                                        <ol class="path">
                                                <li><a href="index.php">Home</a></li>
                                                <li><a href="#">Mobiles & Accessories</a></li>
                                                <li><a href="#">Mobiles</a></li>
                                                <li><a href="#">Oppo F3</a></li>
                                                <li class="active">product details</li>
                                        </ol>
                                        <!--<span class="current-page">product</span>-->
                                </div>


                                <h4 class="product-heading"><?= Yii::$app->SetLanguage->ViewData($product_details, 'product_name'); ?></h4>


                                <div class="rating">
                                        <input type="number" class="rating" id="test" name="test" data-min="1" data-max="5" value="0">
                                </div>
                                <?php
                                if (isset($vendor_product->offer_price)) {
                                        $price1 = $vendor_product->offer_price;
                                        $price2 = $vendor_product->price;
                                } else {
                                        $price1 = $vendor_product->price;
                                        $price2 = "";
                                }
                                ?>
                                <p class="price"><?= sprintf('%0.2f', $price1) ?> AED  <?= $price2 != '' ? '<span>' . sprintf("%0.2f", $price2) . '  AED</span>' : ''; ?> </p>
                                <p class="message">FREE Shipping on orders over 150.00 AED</p>
                                <div class="product-specifications">
                                        <?php if (isset($vendor_product->warranty) && $vendor_product->warranty != '') { ?>
                                                <div class="product-detailed-points">
                                                        <h5>Warranty: </h5>
                                                        <span class="message"><?= $vendor_product->warranty ?></span>
                                                </div>
                                        <?php } ?>
                                        <div class="product-detailed-points">
                                                <h5 class="model-clr">Color:</h5>
                                                <span class="message">
                                                        <div class="app-figure" id="zoom-fig">
                                                                <div class="selectors">
                                                                        <a
                                                                                data-zoom-id="Zoom-1"
                                                                                href="<?= Yii::$app->homeUrl ?>/images/products/1.png"
                                                                                data-image="<?= Yii::$app->homeUrl ?>/images/products/1.png?scale.height=400"
                                                                                >
                                                                                <img srcset="<?= Yii::$app->homeUrl ?>/images/products/1.png?scale.width=112 2x" src="<?= Yii::$app->homeUrl ?>/images/products/1thumb.png?scale.width=56"/>
                                                                        </a>
                                                                        <a
                                                                                data-zoom-id="Zoom-1"
                                                                                href="<?= Yii::$app->homeUrl ?>/images/products/2.png"
                                                                                data-image="<?= Yii::$app->homeUrl ?>/images/products/2.png?scale.height=400"
                                                                                >
                                                                                <img srcset="<?= Yii::$app->homeUrl ?>/images/products/2.png?scale.width=112 2x" src="<?= Yii::$app->homeUrl ?>/images/products/2thumb.png?scale.width=56"/>
                                                                        </a>
                                                                </div>
                                                        </div>
                                                </span>
                                        </div>

                                        <div class="product-detailed-points">
                                                <h5>Highlights: </h5>
                                                <span class="message">
                                                        <?= Yii::$app->SetLanguage->ViewData($product_details, 'highlights'); ?>
                                                </span>
                                        </div>

                                        <div class="product-detailed-points">
                                                <h5> Notes:</h5>
                                                <p class="important-notes"> <?= Yii::$app->SetLanguage->ViewData($product_details, 'important_notes'); ?></p>
                                        </div>

                                        <div class="product-detailed-points availability">
                                                <h5>seller:</h5>
                                                <span class="message"><?= $vendor_product->vendor->first_name ?></span>
                                        </div>
                                        <div class="product-detailed-points availability">
                                                <h5>availability:</h5>
                                                <span class="message"><?php
                                                        if (isset($vendor_product->qty)) {
                                                                if ($vendor_product->qty <= 0) {
                                                                        echo 'No Stock';
                                                                } else if ($vendor_product->qty <= 5) {
                                                                        echo 'In Stock';
                                                                } else if ($vendor_product->qty > 5) {
                                                                        echo 'Many In Stock';
                                                                }
                                                        }
                                                        ?></span>
                                        </div>
                                </div>
                                <div class="message">
                                        <?= Yii::$app->SetLanguage->ViewData($product_details, 'short_description'); ?>
                                </div>

                                <div class="product-info-tab">
                                        <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#info" aria-expanded="true">Product Description</a></li>
                                                <!--<li class=""><a data-toggle="tab" href="#spec" aria-expanded="false">Specifications</a></li>-->
                                        </ul>

                                        <div class="tab-content">
                                                <div id="info" class="tab-pane fade active in">
                                                        <div class="pro-dis-img">
                                                                <p>
                                                                        <?= Yii::$app->SetLanguage->ViewData($product_details, 'main_description'); ?>
                                                                </p>

                                                                <label>Specifications</label>
                                                                <table cellspacing="0" cellpadding="0" border="0">
                                                                        <tbody>
                                                                                <?php
                                                                                foreach ($product_specifications as $specification) {
                                                                                        if (isset($specification->Product_feature_text) && $specification->Product_feature_text != '') {
                                                                                                $product_features = \common\models\ProductFeatures::findOne($specification->product_feature_id);
                                                                                                $specification_model = \common\models\Features::findOne($product_features->specification);
                                                                                                $value = $specification_model->tablevalue__name;
                                                                                                ?>
                                                                                                <tr><td class="label"> <?= Yii::$app->SetLanguage->ViewData($specification_model, 'filter_tittle'); ?> </td><td class="value"><?= $specification->Product_feature_text ?></td></tr>
                                                                                                <?php
                                                                                        }
                                                                                }
                                                                                ?>
                                                                        </tbody>
                                                                </table>

                                                        </div>

                                                </div>
                                                <!--                                                <div id="spec" class="tab-pane fade">
                                                                                                        <table cellspacing="0" cellpadding="0" border="0">
                                                                                                                <tbody>
                                                <?php /*
                                                  foreach ($product_specifications as $specification) {
                                                  if (isset($specification->Product_feature_text) && $specification->Product_feature_text != '') {
                                                  $product_features = \common\models\ProductFeatures::findOne($specification->product_feature_id);
                                                  $specification_model = \common\models\Features::findOne($product_features->specification);
                                                  $value = $specification_model->tablevalue__name; */
                                                ?>
                                                                                                                                                        <tr><td class="label"> <?php // Yii::$app->SetLanguage->ViewData($specification_model, 'filter_tittle');                                                           ?> </td><td class="value"><?php // $specification->Product_feature_text                                                           ?></td></tr>
                                                <?php
                                                /*  }
                                                  } */
                                                ?>
                                                                                                                </tbody>
                                                                                                        </table>
                                                                                                </div>-->
                                        </div>
                                </div>

                                <div class="ratings-reviews">
                                        <div class="">
                                                <div class="well well-sm">
                                                        <div class="row">
                                                                <div class="review-success"><i class="fa fa-check" aria-hidden="true" style="color:#FFF;margin-right: 5px;"></i>Review Added Succesfully</div>
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <h5>RATINGS AND REVIEWS</h5>
                                                                </div>
                                                                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 text-center">
                                                                        <h1 class="rating-num">4.0</h1>
                                                                        <div class="rating">
                                                                                <div class="rating-input"><span class="glyphicon glyphicon-star" data-value="1"></span><span class="glyphicon glyphicon-star" data-value="2"></span><span class="glyphicon glyphicon-star" data-value="3"></span><span class="glyphicon glyphicon-star-empty" data-value="4"></span><span class="glyphicon glyphicon-star-empty" data-value="5"></span><input type="hidden" name="test" value="0" id="test"></div>
                                                                        </div>
                                                                        <div class="total-rating">
                                                                                <span>10,000 Total</span>
                                                                        </div>
                                                                </div>
                                                                <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="row rating-desc">
                                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left ratings">
                                                                                        <span class="glyphicon glyphicon-star-empty"></span>5
                                                                                </div>
                                                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 progressbar">
                                                                                        <div class="progress progress-striped">
                                                                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20"
                                                                                                     aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                                                                        <span class="sr-only">80%</span>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!-- end 5 -->
                                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left ratings">
                                                                                        <span class="glyphicon glyphicon-star-empty"></span>4
                                                                                </div>
                                                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 progressbar">
                                                                                        <div class="progress">
                                                                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20"
                                                                                                     aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                                                                        <span class="sr-only">60%</span>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!-- end 4 -->
                                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left ratings">
                                                                                        <span class="glyphicon glyphicon-star-empty"></span>3
                                                                                </div>
                                                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 progressbar">
                                                                                        <div class="progress">
                                                                                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                                                                                     aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                                                                        <span class="sr-only">40%</span>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!-- end 3 -->
                                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left ratings">
                                                                                        <span class="glyphicon glyphicon-star-empty"></span>2
                                                                                </div>
                                                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 progressbar">
                                                                                        <div class="progress">
                                                                                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20"
                                                                                                     aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                                                                                        <span class="sr-only">20%</span>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!-- end 2 -->
                                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left ratings">
                                                                                        <span class="glyphicon glyphicon-star-empty"></span>1
                                                                                </div>
                                                                                <div class=" col-lg-9 col-md-9 col-sm-9 col-xs-9 progressbar">
                                                                                        <div class="progress">
                                                                                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80"
                                                                                                     aria-valuemin="0" aria-valuemax="100" style="width: 15%">
                                                                                                        <span class="sr-only">15%</span>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>

                                                                                <!-- end 1 -->


                                                                        </div>


                                                                        <!-- end row -->
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 review-add-btn">
                                                                        <button id = "buttonreview" <?php if (isset(Yii::$app->user->identity->id)) { ?> onclick = "displayLoginBox()" <?php } ?> href="cart.php" class="add-review <?php if (!isset(Yii::$app->user->identity->id)) { ?> log-sign <?php } ?>">add review</button>
                                                                </div>
                                                                <div id = "addreview">
                                                                        <?php $form_review = ActiveForm::begin(['id' => 'add-review-form']); ?>

                                                                        <?= $form_review->field($new_customer_review, 'product_id')->hiddenInput(['value' => $vendor_product->id])->label(false); ?>
                                                                        <?= $form_review->field($new_customer_review, 'title')->textInput(['maxlength' => true, 'class' => 'input-text js-input form-control', 'placeholder' => 'Title', 'required' => ''])->label(FALSE) ?>
                                                                        <?= $form_review->field($new_customer_review, 'description')->textarea(['class' => 'form-control', 'placeholder' => 'Description', 'required' => ''])->label(FALSE) ?>
                                                                        <?= Html::submitButton('Submit', ['id' => 'add', 'class' => 'add-review-form']) ?>

                                                                        <?php ActiveForm::end(); ?>
                                                                </div>

                                                                <!------------------------Display Reviews---------------------->
                                                                <div style="clear:both" class="marg-btm-20"></div>
                                                                <?php
                                                                if (!empty($product_reveiws)) {
                                                                        foreach ($product_reveiws as $reveiws) {
                                                                                ?>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 reviews-list">
                                                                                        <label><?= $reveiws->title ?></label>
                                                                                        <p><?= $reveiws->description ?></p>
                                                                                        <p class="review-add-name"><i><?= \common\models\User::findOne($reveiws->user_id)->first_name ?>   <?= date("M d , Y", strtotime($reveiws->review_date)) ?></i></p>
                                                                                </div>

                                                                                <?php
                                                                        }
                                                                }
                                                                ?>



                                                        </div>

                                                </div>

                                        </div>



                                </div>
                        </div>


                        <!-----------------------------------------List Related Products--------------------------------------------->
                        <?= RelatedProductWidget::widget(['id' => $product_details->related_products]) ?>

                        <!-----------------------------------------List Recently Viewed--------------------------------------------->
                        <?= RecentlyViewedWidget::widget(['id' => $user_id]) ?>
                </div>
        </div>
</div>
