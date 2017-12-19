<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use common\models\LoginForm;
use yii\helpers\Url;
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
                <?php
                if (!empty($deals)) {
                    ?>
                    <div class='col-md-12' style="padding: 0px">
                        <div class="hot-deals-heading">
                            <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>images/hot-deals-strip.png"/>
                            <h3 class="home_deal_transform"><?= $deals->tittle ?></h3>
                        </div>
                        <div class="carousel slide media-carousel" id="media">
                            <div class="carousel-inner">
                                <?php
                                $prod_data_id = explode(',', $deals->product_id);
                                $product_datas = common\models\ProductVendor::find()->where(['vendor_status' => 1])->andWhere(['admin_status' => 2])->andWhere(['in', 'product_id', $prod_data_id])->all();
                                $i = 0;
                                foreach ($product_datas as $product_data) {
                                    ?>
                                    <div class="item <?= $i == 0 ? 'active' : '' ?>"  >
                                        <div class="" >
                                            <div class="col-md-4 product">
                                                <a href="#">
                                                    <div class="thumbnail">
                                                        <?php
                                                        $product_details_deals = \common\models\Products::findOne($product_data->product_id);
                                                        $split_folder = Yii::$app->UploadFile->folderName(0, 1000, $product_details_deals->id);
                                                        $product_name = common\models\Products::findOne($product_data->product_id);
                                                        ?>
                                                        <div class="deal_img_box">
                                                            <?= Html::a(Html::img(Yii::$app->homeUrl . "uploads/products/" . $split_folder . '/' . $product_details_deals->id . '/profile/' . $product_details_deals->canonical_name . '_medium.' . $product_details_deals->gallery_images, ['class' => 'img-responsive mainimg']), ['/product-detail/' . $product_name->canonical_name . '/' . yii::$app->EncryptDecrypt->Encrypt('encrypt', $product_data->id)], ['title' => $product_name->product_name, 'class' => 'username color']);
                                                            ?>
                                                            <?php // echo Html::img(Yii::$app->homeUrl . "uploads/products/" . $split_folder . '/' . $product_details_deals->id . '/profile/' . $product_details_deals->canonical_name . '_medium.' . $product_details_deals->gallery_images, ['class' => 'img-responsive mainimg']); ?>
                                                        </div>
                                                        <div class="hot-deals-details">
                                                            <h3 class="product-name">
                                                                <?php
                                                                $count = strlen($product_name->product_name);
                                                                if ($count > 42)
                                                                    echo Html::a(Html::encode(substr($product_name->product_name, 0, 42) . '.....'), ['/product-detail/' . $product_name->canonical_name . '/' . yii::$app->EncryptDecrypt->Encrypt('encrypt', $product_data->id)], ['title' => $product_name->product_name, 'class' => 'username color']);
                                                                else {
                                                                    echo Html::a(Html::encode($product_name->product_name), ['/product-detail/' . $product_name->canonical_name . '/' . yii::$app->EncryptDecrypt->Encrypt('encrypt', $product_data->id)], ['title' => $product_name->product_name, 'class' => 'username color']);
                                                                }
                                                                ?>
                                                                <?php // common\models\Products::findOne($product_data->product_id)->product_name ?>
                                                            </h3>
                                                            <!--                                                        <div class="rating">
                                                                                                                        <input type="number" class="rating" id="test" name="test" data-min="1" data-max="5" value="0">
                                                                                                                    </div>-->
                                                            <?php
                                                            $offer_price = $product_data->price - $product_data->offer_price;
                                                            ?>
                                                            <?php /* if (isset($product_data->offer_price) && $product_data->offer_price != "0") */if ($offer_price != 0 && $product_data->offer != NULL) { ?>
                                                                <h6 class="actual-price">$&nbsp;<?= $product_data->offer_price ?>
                                                                    <span class="old-price">/ <strike>$&nbsp;<?= $product_data->price ?></strike></span>
                                                                </h6>
                                                            <?php } else { ?>
                                                                <h6 class="actual-price">$&nbsp;<?= $product_data->price ?>
                                                                    <span class="old-price"></span>
                                                                </h6>
                                                            <?php } ?>

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
                    <?php
                }
                ?>
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
                        <a href="<?= $home_data->link_1 ?>" arget="_blank">
                            <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>uploads/cms/home_management/<?= $home_data->id ?>/image1.<?= $home_data->image_1 ?>">
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <a href="<?= $home_data->link_2 ?>" arget="_blank">
                            <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>uploads/cms/home_management/<?= $home_data->id ?>/image2.<?= $home_data->image_2 ?>">
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <a href="<?= $home_data->link_3 ?>" arget="_blank">
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
                            $product1_datas = common\models\ProductVendor::find()->where(['vendor_status' => 1])->andWhere(['admin_status' => 2])->andWhere(['in', 'product_id', $prod_data_idd])->all();
                            foreach ($product1_datas as $product1_data) {
                                $product_details = \common\models\Products::findOne($product1_data->product_id);
                                ?>
                                <div class="item">
                                    <div class="pad25">
                                        <a href="<?= Yii::$app->homeUrl ?>product-detail/<?= $product_details->canonical_name . '/' . yii::$app->EncryptDecrypt->Encrypt('encrypt', $product1_data->id) ?>">
                                            <div class="product-img">
                                                <?php
                                                $split_folder = Yii::$app->UploadFile->folderName(0, 1000, $product_details->id);
                                                ?>
                                                <?php echo Html::img(Yii::$app->homeUrl . "uploads/products/" . $split_folder . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '_medium.' . $product_details->gallery_images, ['class' => 'img-responsive mainimg']); ?>
                                            </div>
                                            <h3 class="product-name">
                                                <?php
                                                $product_name = common\models\Products::findOne($product1_data->product_id);
                                                $count = strlen($product_name->product_name);
                                                if ($count > 42)
                                                    echo Html::a(Html::encode(substr($product_name->product_name, 0, 42) . '.....'), ['/product-detail/' . $product_name->canonical_name . '/' . yii::$app->EncryptDecrypt->Encrypt('encrypt', $product_data->id)], ['title' => $product_name->product_name, 'class' => 'username color']);
                                                else {
                                                    echo Html::a(Html::encode($product_name->product_name), ['/product-detail/' . $product_name->canonical_name . '/' . yii::$app->EncryptDecrypt->Encrypt('encrypt', $product_data->id)], ['title' => $product_name->product_name, 'class' => 'username color']);
                                                }
                                                ?>
                                                <?php // common\models\Products::findOne($product1_data->product_id)->product_name ?>
                                            </h3>

                                            <?php
                                            if (isset($product1_data->offer_price)) {
                                                $price1 = $product1_data->offer_price;
                                                $price2 = $product1_data->price;
                                            } else {
                                                $price1 = $product1_data->price;
                                                $price2 = "";
                                            }
                                            $offer_price = $product1_data->price - $product1_data->offer_price;
                                            if ($offer_price != 0 && $product1_data->offer != Null) {
                                                ?>
                                                <h5 class="product-discount">Upto <?= $product1_data->offer ?>% off</h5>
                                            <?php } ?>
                                            <?php /* if (isset($model->offer_price) && $model->offer_price != "0") */if ($offer_price != 0 && $product1_data->offer != Null) { ?>
                                                <h6 class="actual-price">$&nbsp;<?= sprintf('%0.2f', $price1) ?>
                                                    <span class="old-price">/ <strike>$&nbsp;<?= sprintf('%0.2f', $price2) ?></strike></span>
                                                </h6>
                                            <?php } else { ?>
                                                <h6 class="actual-price">$&nbsp;<?= sprintf('%0.2f', $price1) ?>
                                                    <span class="old-price"></span>
                                                </h6>
                                            <?php } ?>

                                                                                                                                                                                                                                <!--<h6 class="actual-price">$<?= $price1 ?><span class="old-price">/ <strike>$130.00</strike></span></h6>-->
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