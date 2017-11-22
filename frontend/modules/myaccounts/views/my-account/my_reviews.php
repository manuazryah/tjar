<?php

use yii\helpers\Html;

$product_details = \common\models\ProductVendor::findOne($model->product_id);
$product_master_details = common\models\Products::findOne($product_details->product_id);
?>

<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="border: 1px solid #eee;margin-bottom:10px;">
        <table class="review-table">
                <tr class="">
                        <td class="" data-title="Order" style='width:20%'>
                                <div class="media">
                                        <a style="margin: 0 auto; float: none;" class="thumbnail col-lg-5 col-md-6 col-sm-6 col-xs-6" href="#">
                                                <?php
                                                $product_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_master_details->id) . '/' . $product_master_details->id . '/profile/' . $product_master_details->canonical_name . '_thumb.' . $product_master_details->gallery_images;
                                                if (file_exists($product_image)) {
                                                        ?>
                                                        <img src="<?= Yii::$app->homeUrl . '/uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_master_details->id) . '/' . $product_master_details->id . '/profile/' . $product_master_details->canonical_name . '_thumb.' . $product_master_details->gallery_images ?>" height="100%" alt="1" />

                                                <?php } else { ?>
                                                        <img src="<?= Yii::$app->homeUrl . 'uploads/products/gallery_dummy.png' ?>?scale.height=400" alt=""/>
                                                <?php } ?>
                                        </a>
                                </div>
                        </td>

                        <td>
                                <p class=""> <b><?= $model->title ?></b></p>
                                <p class=""><?= $model->description ?></p>
                        </td>

                        <td style='width:20%;padding: 20px;'>
                                <i><?= date("M d , Y", strtotime($model->review_date)) ?></i>
                        </td>

                </tr>
                </tbody>
        </table>

</div>

