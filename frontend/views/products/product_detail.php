<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\RecentlyViewedWidget;
use common\components\RelatedProductWidget;
use common\components\ModalViewWidget;
use yii\db\Expression;
use yii\helpers\Url;

if (isset($product_details->meta_title) && $product_details->meta_title != '')
    $this->title = $product_details->meta_title;
else
    $this->title = $product_details->canonical_name;
?>
<style>
    .out_of_stock{
        font-size: 26px;
        color: white;
        padding-left: 87px;
    }
    .disabledbutton {
        pointer-events: none;
        opacity: 0.4;
    }
</style>
<div id="product-detail">
    <div class="container">
        <div class="row">
            <?= ModalViewWidget::widget() ?>
            <?php yii\widgets\Pjax::begin(['id' => 'product-views']); ?>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 product-img-view-box">

                <div id="affix">
                    <div class="app-figure showloader disabledbutton" id="zoom-fig">

                        <?php
                        /* show profile image */
                        $product_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images;
                        if (file_exists($product_image)) {
                            ?>
                            <a id="Zoom-1" class="MagicZoom" title="" href="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images ?>">
                                <img src="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '_large.' . $product_details->gallery_images ?>?scale.height=400" alt=""/>
                                <?php
                                if (isset($vendor_product->offer_price) && $vendor_product->offer_price != "0") {
                                    $percentage = round(100 - (($vendor_product->offer_price / $vendor_product->price) * 100));
                                    ?>
                                    <div class="offer-tag">
                                        <img src="<?= Yii::$app->homeUrl ?>/images/offer-tag-bg.png"/><span><?= $percentage ?>% <?= Yii::$app->session['words']->Off ?></span>
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

                        <div class="function-btn" style="background: transparent">
                            <?php if ($vendor_product->qty > 0) { ?>
                                <?= Html::a('<button class="start-shopping start-shopping-ylw">' . Yii::$app->session['words']->add_to_cart . '</button>', '#', ['class' => 'add_to_cart', 'id' => yii::$app->EncryptDecrypt->Encrypt('encrypt', $vendor_product->id)]) ?>
                                <?= Html::a('<button class="start-shopping start-shopping-blu">' . Yii::$app->session['words']->buy_now . '</button>', '#', ['class' => 'buy_now', 'id' => yii::$app->EncryptDecrypt->Encrypt('encrypt', $vendor_product->id)]) ?>
                                <!--<a href="cart.php"><button class="start-shopping">add to cart</button></a>-->
                                <!--<a href="#"><button class="start-shopping"><? Yii::$app->session['words']->buy_now ?></button></a>-->
                            <?php } else { ?>
                                <label class="out_of_stock">Out Of Stock</label>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 product-details-right">
                <div class="breadcrumb">
                    <ol class="path">
                        <li><a href="<?= Yii::$app->homeUrl ?>">Home</a></li>
                        <?php
                        $product_main_category = '';
                        $product_category = '';
                        $product_subcategory = '';
                        if (isset($product_details)) {
                            if (isset($product_details->main_category)) {
                                $product_main_category = common\models\ProductMainCategory::findOne($product_details->main_category);
                                ?>
                                <li><a href="<?= Yii::$app->homeUrl ?>"><?= Yii::$app->SetLanguage->ViewData($product_main_category, 'name'); ?></a></li>
                                <?php
                            }
                            if (isset($product_details->category) && $product_details->category != '') {
                                $product_category = common\models\ProductCategory::findOne($product_details->category);
                                ?>
                                <li><a href="<?= Yii::$app->homeUrl ?>products/index?main_categ=<?= $product_main_category->canonical_name ?>&categ=<?= $product_category->canonical_name ?>"><?= Yii::$app->SetLanguage->ViewData($product_category, 'category_name'); ?></a></li>
                                <?php
                            }
                            if (isset($product_details->subcategory) && $product_details->subcategory != '') {
                                $product_subcategory = common\models\ProductSubCategory::findOne($product_details->subcategory);
                                ?>
                                <li><a href="<?= Yii::$app->homeUrl ?>products/index?main_categ=<?= $product_main_category->canonical_name ?>&sub_categ=<?= $product_subcategory->canonical_name ?>"><?= Yii::$app->SetLanguage->ViewData($product_subcategory, 'subcategory_name'); ?></a></li>
                            <?php } ?>

                        <?php } ?>
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
                $offer_price = $vendor_product->price - $vendor_product->offer_price;
                ?>
                <p class="price"><?= sprintf('%0.2f', $price1) ?> <?= Yii::$app->session['words']->AED ?>  <?= $offer_price != '' ? '<span>' . sprintf("%0.2f", $price2) . " " . Yii::$app->session['words']->AED . '  </span>' : ''; ?> </p>
                <p class="message"><?= Yii::$app->session['words']->free_shipping ?> 150.00 <?= Yii::$app->session['words']->AED ?></p>
                <?php
                $product_mappping = \common\models\ProductMapping::find()->where(new Expression('FIND_IN_SET(:product_id, product_id)'))->addParams([':product_id' => $product_details->id])->one();
                if (isset($product_mappping)) {
                    $variants = explode(",", $product_mappping->variants);
                    foreach ($variants as $variant) {
                        ?>
                        <div class="product-detailed-points">
                            <h5 style="width: 100%;"><?= \common\models\Features::findOne($variant)->filter_tittle ?></h5>
                        </div>
                        <?php
                        $query_features = \common\models\ProductFeatures::find()->where(['category' => $product_details->category, 'subcategory' => $product_details->subcategory, 'specification' => $variant])->orderBy(['id' => SORT_DESC])->all();
                        $items = array();
                        foreach ($query_features as $query_feature) {
                            $items[] = $query_feature->id;
                        }
                        $query_specifications = \common\models\ProductSpecifications::find()->where(['IN', 'product_feature_id', $items])->orderBy(['id' => SORT_DESC])->all();
                        $count = count($query_specifications) - 1;
                        ?>
                        <select class="form-control variant-url" style="background: #e8e8e8;width: 50%;"><?php
                            foreach ($query_specifications as $query_specification) {
                                ?>
                                <option value="<?= Yii::$app->homeUrl ?>product-detail/<?= common\models\Products::findOne($query_specification->product_id)->canonical_name ?>" <?= $query_specification->product_id == $product_details->id ? 'selected' : '' ?>><?= $query_specification->Product_feature_text ?></option>>
                            <?php }
                            ?>
                        </select>
                        <?php
                    }
                }
                ?>
                <div class="product-detailed-points">
                    <h5><?= Yii::$app->session['words']->Highlights ?>: </h5>
                    <span class="message">
                        <?= Yii::$app->SetLanguage->ViewData($product_details, 'highlights'); ?>
                    </span>
                </div>
                <div class="product-specifications">
                    <?php if (isset($vendor_product->warranty) && $vendor_product->warranty != '') { ?>
                        <div class="product-detailed-points">
                            <h5><?= Yii::$app->session['words']->Warranty ?>: </h5>
                            <span class="message"><?= $vendor_product->warranty ?></span>
                        </div>
                    <?php } ?>

                    <div class="product-detailed-points">
                        <h5> <?= Yii::$app->session['words']->Notes ?>:</h5>
                        <p class="important-notes"> <?= Yii::$app->SetLanguage->ViewData($product_details, 'important_notes'); ?></p>
                    </div>

                    <div class="product-detailed-points availability">
                        <h5><?= Yii::$app->session['words']->seller ?>:</h5>
                        <span class="message"><?= $vendor_product->vendor->first_name ?></span>
                    </div>
                    <div class="product-detailed-points availability">
                        <h5><?= Yii::$app->session['words']->availability ?>:</h5>
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
                        <li class="active"><a data-toggle="tab" href="#info" aria-expanded="true"><?= Yii::$app->session['words']->product_description ?></a></li>
                        <!--<li class=""><a data-toggle="tab" href="#spec" aria-expanded="false">Specifications</a></li>-->
                    </ul>

                    <div class="tab-content">
                        <div id="info" class="tab-pane fade active in">
                            <div class="pro-dis-img">
                                <p>
                                    <?= Yii::$app->SetLanguage->ViewData($product_details, 'main_description'); ?>
                                </p>

                                <label><?= Yii::$app->session['words']->Specifications ?></label>
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
                                                                                                                                <tr><td class="label"> <?php // Yii::$app->SetLanguage->ViewData($specification_model, 'filter_tittle');                                                                                                                                                                                                                                                                                                                                                                                            ?> </td><td class="value"><?php // $specification->Product_feature_text                                                                                                                                                                                                                                                                                                                                                                                            ?></td></tr>
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
                                <?php
                                $rating_entered = '0';
                                $rating_average = '0.0';
                                $rating_entered = common\models\CustomerReviews::find()->where(['product_id' => $vendor_product->id, 'status' => 1])->count();
                                $rating_sum = common\models\CustomerReviews::find()->where(['product_id' => $vendor_product->id, 'status' => 1])->sum('rating');
                                if (isset($rating_entered)) {
                                    $rating_entered = number_format($rating_entered);
                                }
                                if ($rating_entered > 0) {
                                    $rating_average = $rating_sum / $rating_entered;
                                    $rating_average = round($rating_average, 2);
                                    $rating_average_dowm = floor($rating_average);
                                }
                                ?>
                                <div class="review-success"><i class="fa fa-check" aria-hidden="true" style="color:#FFF;margin-right: 5px;"></i>Review Added Succesfully</div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h5><?= Yii::$app->session['words']->reviews ?></h5>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 text-center">
                                    <h1 class="rating-num"><?= $rating_average ?></h1>
                                    <div class="rating">
                                        <div class="rating-input">

                                            <?php
                                            for ($i = 1; $i <= 5; $i += 1) {
                                                $star_class = '';
                                                if (isset($rating_average_dowm)) {
                                                    if ($i > $rating_average_dowm) {
                                                        $star_class = '-empty';
                                                    }
                                                }
                                                ?>
                                                <span class="glyphicon glyphicon-star<?= $star_class ?>" data-value="<?= $i ?>"></span>
                                            <?php } ?>
<!--                                                                                        <span class="glyphicon glyphicon-star" data-value="1"></span>
<span class="glyphicon glyphicon-star" data-value="2"></span>
<span class="glyphicon glyphicon-star" data-value="3"></span>
<span class="glyphicon glyphicon-star-empty" data-value="4"></span>
<span class="glyphicon glyphicon-star-empty" data-value="5"></span>-->
                                            <input type="hidden" name="test" value="0" id="test">
                                        </div>
                                    </div>
                                    <div class="total-rating">
                                        <span><?= $rating_entered ?> Total</span>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
                                    <div class="row rating-desc">

                                        <?php
                                        $tot_stars = 0;
                                        for ($i = 5; $i > 0; $i -= 1) {
                                            $var = 'star' . + $i;
                                            $$var = common\models\CustomerReviews::find()->where(['product_id' => $vendor_product->id, 'rating' => $i, 'status' => 1])->count();
                                            $tot_stars += $$var;
                                        }
                                        ?>

                                        <?php
                                        for ($i = 5; $i > 0; $i -= 1) {
                                            $percent = 0;
                                            $rating_count_of_nxt = common\models\CustomerReviews::find()->where(['product_id' => $vendor_product->id, 'rating' => $i, 'status' => 1])->count();
                                            if ($rating_count_of_nxt > 0) {
                                                $var = "star$i";
                                                $count = $$var;
                                                $percent = $count * 100 / $tot_stars;
                                                $percent = round($percent, 2);
                                            }
                                            if ($i == 5) {
                                                $color = 'progress-bar-success';
                                            } else if ($i == 4) {
                                                $color = 'progress-bar-success"';
                                            } else if ($i == 3) {
                                                $color = 'progress-bar-info';
                                            } else if ($i == 2) {
                                                $color = 'progress-bar-warning';
                                            } else if ($i == 1) {
                                                $color = 'progress-bar-danger';
                                            }
                                            ?>

                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left ratings">
                                                <span class="glyphicon glyphicon-star-empty"></span><?= $i ?>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 progressbar">
                                                <div class="progress  <?= $i == 5 ? 'progress-striped' : '' ?> ">
                                                    <div class="progress-bar <?= $color ?>" role="progressbar" aria-valuenow="20"
                                                         aria-valuemin="0" aria-valuemax="100" style="width: <?= $percent ?>%">
                                                        <span class="sr-only"><?= $percent ?>%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>



                                    </div>


                                    <!-- end row -->
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 review-add-btn">
                                        <!--<button id = "buttonreview" <?php if (isset(Yii::$app->user->identity->id)) { ?> onclick = "displayLoginBox()" <?php } ?> href="cart.php" class="add-review <?php if (!isset(Yii::$app->user->identity->id)) { ?> log-sign <?php } ?>"><?= Yii::$app->session['words']->add_review ?></button>-->
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
                    <?php if (isset(Yii::$app->user->identity->id)) { ?>

                        <div class="alert alert-success"id="message" role="alert">
                            <i class="fa fa-close"></i>
                        </div>


                        <a href="" class="report_pblm add-complaint" id="<?= $vendor_product->id ?>" style="margin-top:10px;" vendor="<?= $vendor_product->vendor_id ?>">Report a problem</a>
                    <?php } ?>
                    <!--					<a class="report_pblm">Report a problem</a>-->



                </div>
            </div>

            <?php yii\widgets\Pjax::end(); ?>
            <!-----------------------------------------List Related Products--------------------------------------------->
            <?= RelatedProductWidget::widget(['id' => $product_details->related_products]) ?>

            <!-----------------------------------------List Recently Viewed--------------------------------------------->
            <?= RecentlyViewedWidget::widget(['id' => $user_id]) ?>
        </div>
    </div>
</div>
<script>
    $(window).load(function () {
        $(".showloader").removeClass("disabledbutton");
//        alert('1');
    });
    </script>
<script>
    $(document).ready(function () {
        $('#message').hide();
        $(document).on('change', '.variant-url', function (e) {
            var url = $(this).val();
            $.pjax({container: '#product-views', url: url});
        });
        $(document).on('click', '.add-complaint', function (e) {
            e.preventDefault();
            var product = $(this).attr('id');
            var vendor = $(this).attr('vendor');

            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {product_id: product},
                url: '<?= Yii::$app->homeUrl; ?>products/complaints',
                success: function (data) {
                    $("#modal-pop-up").html(data);
                    $('#modal-6').modal('show', {backdrop: 'static'});
                    $('#usercomplaints-product_id').val(product);
                    $('#usercomplaints-vendor_id').val(vendor);
                    e.preventDefault();
                }
            });
        });
        $(document).on('submit', '#submit-complaint', function (e) {
            var str = $('#usercomplaints-complaint').val();
            var dat = $(this).serialize();

            $.ajax({
                url: '<?= Yii::$app->homeUrl; ?>products/save-complaint',
                type: "POST",
                data: dat,
//				data: {complaint: str, data: dat},
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.dat == 1) {
                        $('#message').show();
                        $('#message').text(data.msg);

                    } else {
                        alert(data.msg);
                    }
                    $('#modal-6').modal('hide');
                }
            });
            return false;

        });
    });
</script>