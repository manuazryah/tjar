<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

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
                                                $product_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images;
                                                if (file_exists($product_image)) {
                                                        ?>
                                                        <a id="Zoom-1" class="MagicZoom" title="" href="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images ?>">
                                                                <img src="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images ?>?scale.height=400" alt=""/>
                                                                <div class="offer-tag">
                                                                        <img src="<?= Yii::$app->homeUrl ?>/images/offer-tag-bg.png"/><span>10% OFF</span>
                                                                </div>
                                                        </a>
                                                <?php } else { ?>

                                                        <a id="Zoom-1" class="MagicZoom" title="" href="#">
                                                                <img src="<?= Yii::$app->homeUrl . 'uploads/products/gallery_dummy.png' ?>?scale.height=400" alt=""/>
                                                                <div class="offer-tag">
                                                                        <img src="<?= Yii::$app->homeUrl ?>/images/offer-tag-bg.png"/><span>10% OFF</span>
                                                                </div>
                                                        </a>

                                                <?php } ?>
                                                <div class="selectors">

                                                        <?php if (file_exists($product_image)) { ?>
                                                                <a
                                                                        data-zoom-id="Zoom-1"
                                                                        href="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images ?>"
                                                                        data-image="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images ?>?scale.height=400"
                                                                        >
                                                                        <img srcset="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '_thumb.' . $product_details->gallery_images ?>?scale.width=112 2x" src="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '_thumb.' . $product_details->gallery_images ?>?scale.width=56"/>
                                                                </a>
                                                        <?php } ?>




                                                        <?php
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!--                                                                                                <a data-zoom-id="Zoom-1" href="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/gallery/' . end($arry) ?>" data-image="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/gallery/' . end($arry) ?>?scale.height=400">

                                                                                                -->                                                                                                <a
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
                                                        <?= Html::a('add to cart', '#', ['class' => 'start-shopping add_to_cart', 'id' => yii::$app->EncryptDecrypt->Encrypt('encrypt', $vendor_product->id)]) ?>
                                                        <!--<a href="cart.php"><button class="start-shopping">add to cart</button></a>-->
                                                        <a href="#"><button class="start-shopping">Buy now</button></a>
                                                </div>
                                        </div>
                                </div>
                                <!--<span class="company-speciality col-md-12">Safe and Secure Payments. Easy returns. 100% Authentic products.</span>-->
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

                                <h4 class="product-heading"><?= $product_details->product_name ?></h4>
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
                                <!--<span><?= sprintf('%0.2f', $price2) ?> AED</span>-->
                                <p class="message">FREE Shipping on orders over 150.00 AED</p>
                                <div class="product-specifications">
                                        <div class="product-detailed-points">
                                                <h5>Warrenty: </h5>
                                                <span class="message">1 Year for mobile & 6 months for Accessories</span>
                                        </div>
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
                                                        <?= $product_details->highlights ?>
                                                </span>
                                        </div>

                                        <div class="product-detailed-points">
                                                <h5>Important Notes:</h5>
                                                <span class="message"><?= $product_details->important_notes ?></span>
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
                                        <?= $product_details->short_description ?>
                                </div>

                                <div class="product-info-tab">
                                        <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#info" aria-expanded="true">Product Description</a></li>
                                                <li class=""><a data-toggle="tab" href="#spec" aria-expanded="false">Specifications</a></li>
                                        </ul>

                                        <div class="tab-content">
                                                <div id="info" class="tab-pane fade active in">
                                                        <div class="pro-dis-img">
                                                                <p>
                                                                        <?= $product_details->main_description ?>
                                                                </p>
                                                        </div>
                                                </div>
                                                <div id="spec" class="tab-pane fade">
                                                        <table cellspacing="0" cellpadding="0" border="0">
                                                                <tbody>
                                                                        <?php
                                                                        foreach ($product_specifications as $specification) {
                                                                                $product_features = \common\models\ProductFeatures::findOne($specification->product_feature_id);
                                                                                $specification_model = \common\models\Features::findOne($product_features->specification);
                                                                                $value = $specification_model->tablevalue__name;
                                                                                ?>

                                                                                <tr><td class="label"> <?= $specification_model->filter_tittle; ?> </td><td class="value"><?= $specification->Product_feature_text ?></td></tr>

                                                                        <?php } ?>
                                                                </tbody>
                                                        </table>
                                                </div>
                                        </div>
                                </div>

                                <div class="ratings-reviews">
                                        <div class="">
                                                <div class="well well-sm">
                                                        <div class="row">
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
                                                                        <form name = "myform" >
                                                                                <input name="title" id="title" class="input-text js-input form-control" placeholder="Title" type="text" required="">
                                                                                <textarea class="form-control" placeholder="Discription" required="required" id="message" name="message"></textarea>
                                                                                <input type = "submit" id = "add" />
                                                                        </form>
                                                                </div>

                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>

                        <section id="product-slider">
                                <div class="container">
                                        <div class="category-heading">Related Products</div>
                                        <div class="row">
                                                <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel1" data-interval="1000">
                                                        <div class="MultiCarousel-inner" style="transform: translateX(0px); width: 2560px;">
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product1.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product2.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product3.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product4.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product5.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product1.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product2.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product3.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product4.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product5.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <button class="btn btn-primary leftLst over">&lt;</button>
                                                        <button class="btn btn-primary rightLst">&gt;</button>
                                                </div>
                                        </div>
                                </div>
                        </section>


                        <section id="product-slider">
                                <div class="container">
                                        <div class="category-heading">Recently Viewed</div>
                                        <div class="row">
                                                <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel1" data-interval="1000">
                                                        <div class="MultiCarousel-inner" style="transform: translateX(0px); width: 2560px;">
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product1.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product2.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product3.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product4.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product5.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product1.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product2.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product3.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product4.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                                <div class="item" style="width: 256px;">
                                                                        <div class="pad25">
                                                                                <a href="#">
                                                                                        <div class="product-img">
                                                                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/products/featured/product5.png">
                                                                                        </div>
                                                                                        <h3 class="product-name">Vu 102cm (40) Full HD LED TV</h3>
                                                                                        <h5 class="product-discount">Upto 50% off</h5>
                                                                                        <h6 class="actual-price">$120.00<span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <button class="btn btn-primary leftLst over">&lt;</button>
                                                        <button class="btn btn-primary rightLst">&gt;</button>
                                                </div>
                                        </div>
                                </div>
                        </section>

                </div>
        </div>
</div>
