<?php

use yii\helpers\Html;
use common\models\Fregrance;
use common\components\ProductLinksWidget;
?>

<?php
if (!empty($recently_viewed)) {
    ?>
    <section id="product-slider">
        <div class="container">
            <div class="category-heading"><?= Yii::$app->session['words']->Recently_Viewed ?></div>
            <div class="row">
                <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel1" data-interval="1000">
                    <div class="MultiCarousel-inner" style="transform: translateX(0px); width: 2560px;">

                        <?php
                        foreach ($recently_viewed as $recent) {
                            if (isset($recent->product_id)) {
                                $vendor_product = common\models\ProductVendor::findOne($recent->product_id);
                                if (isset($vendor_product) && $vendor_product->vendor_status == 1 && $vendor_product->admin_status == 2) {
                                    $product_details = common\models\Products::findOne($vendor_product->product_id);
                                    if (!empty($product_details)) {
                                        ?>
                                        <div class="item" style="width: 256px;">
                                            <div class="pad25">
                                                <a href="<?= Yii::$app->homeUrl . 'product-detail/' . $product_details->canonical_name . '/' . yii::$app->EncryptDecrypt->Encrypt('encrypt', $recent->product_id) ?>">
                                                    <div class="product-img">

                                                        <?php
                                                        $product_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '.' . $product_details->gallery_images;
                                                        if (file_exists($product_image)) {
                                                            ?>
                                                            <img src="<?= Yii::$app->homeUrl . 'uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_details->id) . '/' . $product_details->id . '/profile/' . $product_details->canonical_name . '_thumb.' . $product_details->gallery_images ?>" class="img-responsive">

                                                        <?php } else { ?>
                                                            <img src="<?= yii::$app->homeUrl; ?>uploads/products/gallery_dummy.png" class="img-responsive">

                                                        <?php } ?>
                                                    </div>


                                                    <h3 class="product-name"><?= Yii::$app->SetLanguage->ViewData($product_details, 'product_name'); ?></h3>
                                                    <?php
                                                    if (isset($vendor_product->offer_price) && $vendor_product->offer_price != "0") {
                                                        $percentage = round(100 - (($vendor_product->offer_price / $vendor_product->price) * 100));
                                                        ?>
                                                        <h5 class="product-discount">Upto <?= $percentage ?>% <?= Yii::$app->session['words']->Off ?></h5>
                                                    <?php } ?>

                                                    <?php
                                                    if (isset($vendor_product->offer_price)) {
                                                        $price1 = $vendor_product->offer_price;
                                                        $price2 = $vendor_product->price;
                                                    } else {
                                                        $price1 = $vendor_product->price;
                                                        $price2 = "";
                                                    }
                                                    ?>

                                                    <h6 class="actual-price">$<?= sprintf('%0.2f', $price1) ?>  <span class="old-price">/ <strike>$<?= sprintf("%0.2f", $price2) ?></strike></span></h6>
                                                </a>
                                            </div>

                                        </div>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>


                    </div>
                    <button class="btn btn-primary leftLst over">&lt;</button>
                    <button class="btn btn-primary rightLst">&gt;</button>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
