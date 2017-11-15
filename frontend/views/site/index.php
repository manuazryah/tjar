<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use common\models\LoginForm;
?>
<section>
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 sm-pad-right0 xs-pad-right0" id="slider">
        <!-- Add this css File in head tag-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="all">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet" media="all">


        <!--
               If you want to change #bootstrap-touch-slider id then you have to change Carousel-indicators and Carousel-Control  #bootstrap-touch-slider slide as well
               Slide effect: slide, fade
               Text Align: slide_style_center, slide_style_left, slide_style_right
               Add Text Animation: https://daneden.github.io/animate.css/
        -->


        <div id="bootstrap-touch-slider" class="carousel bs-slider fade  control-round indicators-line" data-ride="carousel" data-pause="hover" data-interval="5000" >

            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php
                $j = 0;
                foreach ($sliders as $value) {
                    ?>
                    <li data-target="#bootstrap-touch-slider" data-slide-to="<?= $j ?>" class="<?= $j == 0 ? 'active' : '' ?>"></li>
                    <?php
                    $j++;
                }
                ?>
            </ol>

            <!-- Wrapper For Slides -->
            <div class="carousel-inner" role="listbox">

                <?php
                $k = 0;
                foreach ($sliders as $value) {
                    $link = '';
                    if (isset($value->slider_link) && $value->slider_link != '') {
                        $link = $value->slider_link;
                    }
                    ?>
                    <div class="item <?= $k == 0 ? 'active' : '' ?>">

                        <!-- Slide Background -->
                        <a href="<?= $link ?>" arget="_blank"><img src="<?= Yii::$app->homeUrl; ?>uploads/cms/slider/<?= $value->canonical_name ?>.<?= $value->slider_image ?>" alt="Bootstrap Touch Slider"  class="slide-image"/></a>
                        <!--<div class="bs-slider-overlay"></div>-->

                    </div>
                    <?php
                    $k++;
                }
                ?>


            </div><!-- End of Wrapper For Slides -->

            <!-- Left Control -->
            <a class="left carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="prev">
                <span class="fa fa-angle-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <!-- Right Control -->
            <a class="right carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="next">
                <span class="fa fa-angle-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div> <!-- End  bootstrap-touch-slider Slider -->
    </div>



    <div class="col-lg-2 col-md-2 hidden-sm hidden-xs" id="top-product-slider">
        <div class="container" style="min-width: 100%; max-width: 100%; padding: 0px;">
            <div>
                <div class='col-md-12' style="padding: 0px">
                    <div class="hot-deals-heading">
                        <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>images/hot-deals-strip.png"/>
                        <h3><?= $deals->tittle ?></h3>
                    </div>
                    <div class="carousel slide media-carousel" id="media">
                        <div class="carousel-inner">
                            <?php
                            $prod_data_id = explode(',', $deals->product_id);
                            $product_datas = common\models\ProductVendor::find()->where(['status' => 1])->andWhere(['in', 'id', $prod_data_id])->all();
                            $i = 0;
                            foreach ($product_datas as $product_data) {
                                ?>
                                <div class="item <?= $i == 0 ? 'active' : '' ?>"  >
                                    <div class="" >
                                        <div class="col-md-4 product">
                                            <a href="#">
                                                <div class="thumbnail">
                                                    <img alt="" src="<?= Yii::$app->homeUrl ?>images/hot-deals/img-1.png">
                                                    <div class="hot-deals-details">
                                                        <h3 class="product-name"><?= common\models\Products::findOne($product_data->product_id)->product_name ?></h3>
                                                        <!--                                                        <div class="rating">
                                                                                                                    <input type="number" class="rating" id="test" name="test" data-min="1" data-max="5" value="0">
                                                                                                                </div>-->
                                                        <h6 class="actual-price">$<?= $product_data->price ?><span class="old-price">/ <strike>$130.00</strike></span></h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $i++;
                            }
                            ?>
                        </div>
                        <a data-slide="prev" href="#media" class="left carousel-control">‹</a>
                        <a data-slide="next" href="#media" class="right carousel-control">›</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>
<?php
foreach ($home_datas as $home_data) {
    if ($home_data->type == 1) {
        ?>
        <section id="col-3-specialoff">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <a href="#">
                            <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>uploads/cms/home_management/<?= $home_data->id ?>/image1.<?= $home_data->image_1 ?>">
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <a href="#">
                            <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>uploads/cms/home_management/<?= $home_data->id ?>/image2.<?= $home_data->image_2 ?>">
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <a href="#">
                            <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>uploads/cms/home_management/<?= $home_data->id ?>/image3.<?= $home_data->image_3 ?>">
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php } elseif ($home_data->type == 0) {
        ?>
        <section id="product-slider">
            <div class="container">
                <div class="category-heading"><?= $home_data->tittle ?></div>
                <div class="row">
                    <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
                        <div class="MultiCarousel-inner">
                            <?php
                            $prod_data_idd = explode(',', $home_data->product_id);
                            $product1_datas = common\models\ProductVendor::find()->where(['status' => 1])->andWhere(['in', 'id', $prod_data_idd])->all();
                            foreach ($product1_datas as $product1_data) {
                                ?>
                                <div class="item">
                                    <div class="pad25">
                                        <a href="#">
                                            <div class="product-img">
                                                <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>images/products/featured/product1.png"/>
                                            </div>
                                            <h3 class="product-name"><?= common\models\Products::findOne($product1_data->product_id)->canonical_name ?></h3>
                                            <h5 class="product-discount">Upto 50% off</h5>
                                            <h6 class="actual-price">$<?= $product1_data->price ?><span class="old-price">/ <strike>$130.00</strike></span></h6>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <button class="btn btn-primary leftLst"><</button>
                        <button class="btn btn-primary rightLst">></button>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}
?>
<section id="special-features">
    <div class="container">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 feature">
            <h4><span><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>FREE SHIPPING ON ORDER OVER $99</h4>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 feature">
            <h4><span><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>24/7 CUSTOMER SUPPORT SERVICE</h4>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 feature">
            <h4><span><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>5% DISCOUNT ON ORDER OVER $200</h4>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 feature">
            <h4><span><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>30 DAYS MONEY BACK GUARANTEE</h4>
        </div>
    </div>
</section>