<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

if (isset($product_details->meta_title) && $product_details->meta_title != '')
    $this->title = $product_details->meta_title;
else
    $this->title = $product_details->canonical_name;
//$this->params['breadcrumbs'][] = $this->title;
?>
<div id="product-detail">
    <div class="container">
        <div class="row">

            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 product-img-view-box">
                <!--                <div class="xzoom-container app-figure" id="zoom-fig">
                                    <img class="xzoom" id="xzoom-default" src="<?= Yii::$app->homeUrl ?>/images/products/escape2.png" xoriginal="<?= Yii::$app->homeUrl ?>/images/products/escape2.png" />
                                    <div class="xzoom-thumbs">
                                        <a href="<?= Yii::$app->homeUrl ?>/images/products/escape2.png"><img class="xzoom-gallery" width="80" height="80" src="<?= Yii::$app->homeUrl ?>/images/products/escape2.png"  xpreview="<?= Yii::$app->homeUrl ?>/images/products/escape2.png"></a>
                                        <a href="<?= Yii::$app->homeUrl ?>/images/products/metal.png"><img class="xzoom-gallery" width="80" height="80" src="<?= Yii::$app->homeUrl ?>/images/products/metal.png"></a>
                                        <a href="<?= Yii::$app->homeUrl ?>/images/gallery/original/03_r_car.jpg"><img class="xzoom-gallery" width="80" src="<?= Yii::$app->homeUrl ?>/images/gallery/preview/03_r_car.jpg" title="The description goes here"></a>
                                        <a href="<?= Yii::$app->homeUrl ?>/images/gallery/original/04_g_car.jpg"><img class="xzoom-gallery" width="80" src="<?= Yii::$app->homeUrl ?>/images/gallery/preview/04_g_car.jpg" title="The description goes here"></a>
                                    </div>
                                </div>        -->

                <div id="affix">
                    <div class="app-figure" id="zoom-fig">
                        <a id="Zoom-1" class="MagicZoom" title=""
                           href="<?= Yii::$app->homeUrl ?>/images/products/1.png"
                           >
                            <img src="<?= Yii::$app->homeUrl ?>/images/products/1.png?scale.height=400" alt=""/>
                            <div class="offer-tag">
                                <img src="<?= Yii::$app->homeUrl ?>/images/offer-tag-bg.png"/><span>10% OFF</span>
                            </div>
                        </a>
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
                            <a
                                data-zoom-id="Zoom-1"
                                href="<?= Yii::$app->homeUrl ?>/images/products/passion.png"
                                data-image="<?= Yii::$app->homeUrl ?>/images/products/passion.png?scale.height=400"
                                >
                                <img srcset="<?= Yii::$app->homeUrl ?>/images/products/passion.png?scale.width=112 2x" src="<?= Yii::$app->homeUrl ?>/images/products/3thumb.png?scale.width=56"/>
                            </a>
                            <a
                                data-zoom-id="Zoom-1"
                                href="<?= Yii::$app->homeUrl ?>/images/products/passion.png"
                                data-image="<?= Yii::$app->homeUrl ?>/images/products/passion.png?scale.height=400"
                                >
                                <img srcset="<?= Yii::$app->homeUrl ?>/images/products/passion.png?scale.width=112 2x" src="<?= Yii::$app->homeUrl ?>/images/products/1thumb.png?scale.width=56"/>
                            </a>
                            <a
                                data-zoom-id="Zoom-1"
                                href="<?= Yii::$app->homeUrl ?>/images/products/passion.png"
                                data-image="<?= Yii::$app->homeUrl ?>/images/products/passion.png?scale.height=400"
                                >
                                <img srcset="<?= Yii::$app->homeUrl ?>/images/products/passion.png?scale.width=112 2x" src="<?= Yii::$app->homeUrl ?>/images/products/1thumb.png?scale.width=56"/>
                            </a>
                            <a
                                data-zoom-id="Zoom-1"
                                href="<?= Yii::$app->homeUrl ?>/images/products/passion.png"
                                data-image="<?= Yii::$app->homeUrl ?>/images/products/passion.png?scale.height=400"
                                >
                                <img srcset="<?= Yii::$app->homeUrl ?>/images/products/passion.png?scale.width=112 2x" src="<?= Yii::$app->homeUrl ?>/images/products/1thumb.png?scale.width=56"/>
                            </a>
                        </div>
                        <div class="function-btn">
                            <?= Html::a('add to cart', '#', ['class' => 'start-shopping add_to_cart', 'id' => $product_details->canonical_name]) ?>
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

                <h4 class="product-heading">OPPO F3 (BLACK,64 GB) (4 GB RAM)</h4>
                <div class="rating">
                    <input type="number" class="rating" id="test" name="test" data-min="1" data-max="5" value="0">
                </div>
                <p class="price">200.00 AED  <span>318.00 AED</span> </p>
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
                            <ul>
                                <li>4 GB RAM | 64 GB ROM | Expandable Upto 128 GB</li>
                                <li>5.5 inch Full HD Display</li>
                                <li>13MP Rear Camera | 16MP + 8MP Dual Front Camera</li>
                                <li>3200 mAh Battery</li>
                            </ul>
                        </span>
                    </div>
                    <div class="product-detailed-points availability">
                        <h5>seller:</h5>
                        <span class="message">RetailNet (4.1)</span>
                    </div>
                    <div class="product-detailed-points availability">
                        <h5>availability:</h5>
                        <span class="message">many in stock</span>
                    </div>
                </div>
                <div class="message">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt  nisi ut aliquip ex ea commodo consequat.
                </div>

                <div class="product-info-tab">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#info" aria-expanded="true">Product Description</a></li>
                        <li class=""><a data-toggle="tab" href="#spec" aria-expanded="false">Specifications</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="info" class="tab-pane fade active in">
                            <div class="pro-dis-img">
                                <img class="left" src="<?= Yii::$app->homeUrl ?>/images/products/pro-description/1.png"/>
                                <h5>Impressive Rear Camera</h5>
                                <p>The 13-MP rear camera of the Oppo F3 lets you take some pretty sweet shots, thanks to the many features it offers. There’s even an option to take pictures in Ultra HD.</p>
                            </div>
                            <div class="pro-dis-img">
                                <img class="right" src="<?= Yii::$app->homeUrl ?>/images/products/pro-description/2.png"/>
                                <h5>Impressive Rear Camera</h5>
                                <p>The 13-MP rear camera of the Oppo F3 lets you take some pretty sweet shots, thanks to the many features it offers. There’s even an option to take pictures in Ultra HD.</p>
                            </div>
                        </div>
                        <div id="spec" class="tab-pane fade">
                            <table cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <tr><td class="label"> OS </td><td class="value">Android</td></tr>
                                    <tr><td class="label"> RAM </td><td class="value">6 GB</td></tr>
                                    <tr class="size-weight"><td class="label">Item Weight</td><td class="value">159 g</td></tr>
                                    <tr class="size-weight"><td class="label">Product Dimensions</td><td class="value">15.3 x 0.7 x 7.5 cm</td></tr>
                                    <tr class="item-model-number"><td class="label">Item model number</td><td class="value">3T</td></tr>
                                    <tr><td class="label"> Wireless communication technologies </td><td class="value">Bluetooth;WiFi Hotspot</td></tr>
                                    <tr><td class="label"> Connectivity technologies </td><td class="value">4G, GSM;(1900/1800/850/900 MHz);HSPA+;3G;(2100/1900/850/900 MHz);(2100/1800/2600/900/800 MHz);GPRS;EDGE;WiFi 802.11 b/g/n; WCDMA: Bands 1/2/5/8; FDD-LTE: Bands 1/3/5/7/8/20; TDD-LTE: Bands 38/40</td></tr>
                                    <tr><td class="label"> Special features </td><td class="value">;;Dual SIM;GPS;Music Player;Video Player;;Fingerprint sensor;Hall sensor;Accelerometor;Gyroscope;Proximity sensor;Ambient light sensor;Electronic compass;E-mail</td></tr>
                                    <tr><td class="label"> Other camera features </td><td class="value">16MP</td></tr>
                                    <tr><td class="label"> Form factor</td><td class="value">Touchscreen Phone</td></tr>
                                    <tr><td class="label"> Weight </td><td class="value">160 Grams</td></tr>
                                    <tr><td class="label"> Colour </td><td class="value">Gunmetal</td></tr>
                                    <tr><td class="label"> Battery Power Rating </td><td class="value">3400</td></tr>
                                    <tr><td class="label"> Whats in the box </td><td class="value">Handset, Dash Type-C Cable, Dash Power Adapter, SIM Tray Ejector, Screen Protector (pre-applied), Safety Information and Quick Start Guide</td></tr>
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
                                    <button id = "buttonreview" onclick = "displayLoginBox()" href="cart.php" class="add-review">add review</button>
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
