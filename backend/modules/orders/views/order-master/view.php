<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Products;
use common\models\ProductVendor;
use common\models\OrderDetails;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Details of ' . $id;
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .album-image{
        position: relative;
        padding: 10px;
        background: #dad4d4;
        margin-bottom: 20px;
        width: 100%;
    }
    .album-image img{
        float: left;
    }
    .order_product{
        margin-left: 130px;
    }
</style>
<div class="order-master-index">
    <?php
    yii\bootstrap\Modal::begin([
        'headerOptions' => ['id' => 'modalHeader'],
        'id' => 'modal',
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
    ]);
    $subtotal = $ordermaster->total_amount;
    ?>
    <div id='modalContent'></div>;
    <?php yii\bootstrap\Modal::end(); ?>
    <div class="row">
        <div class="col-md-12">
            <?= Html::a('<i class="fa-th-list"></i><span> Manage Order </span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Buyer Information</h3>
                    <div style="float: right">
                        <?=
                        Html::a('Print<span><i class="fa fa-print" aria-hidden="true"></i></span>', Url::to(['print-all', 'id' => $id]), [
                            'title' => Yii::t('app', 'print'),
                            'label' => 'Print',
                            'class' => '',
                            'target' => '_blank',]);
                        ?>
                    </div>


                </div>
                <div class="panel-body">


                    <?php echo $this->render('_detail_header', ['model' => $ordermaster]) ?>

                    <div style="clear: both"></div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="order-master-index">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="panel-body  border_bgd">
                    <div class="col-md-12 col-lg-12 col-sm-12 product-vew-pop" style="margin-top: 18px;">
                        <div class="col-md-5" >

                            <div class="clearfix"></div>
                            <?php
                            $i = '1';
                            foreach ($orderdetails as $orderdtl) {
                                $prdctvendor = ProductVendor::findone($orderdtl->product_id);
                                $product = Products::findone($prdctvendor->product_id);
                                $vendor = common\models\Vendors::findOne($prdctvendor->vendor_id);
                                $product_specifications = \common\models\ProductSpecifications::find()->where(['product_id' => $product->id])->andWhere(['not', ['product_feature_id' => null]])->all();
                                ?>
                                <div style="padding: 11px;">
                                    <a href="javascript:void(0)" class="order_detail" id="<?= $i; ?>">
                                        <div class=" order_detail_image album-image">

                                            <?php
                                            $profile_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '.' . $product->gallery_images;
                                            if (file_exists($profile_image)) {
                                                $image = '<img src="' . Yii::$app->homeUrl . '../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '_thumb.' . $product->gallery_images . '" width="95px" class="img-responsive">';
                                            } else {
                                                $image = '<img src="' . yii::$app->homeUrl . '../uploads/products/gallery_dummy.png" width="95px" class="img-responsive">';
                                            }
                                            ?>

                                            <?= $image; ?>
                                            <div class="order_product">
                                                <?php if ($prdctvendor->full_fill == '1') { ?> <span style="color:blue">Full Fill by Tjar</span><br><?php } ?>
                                                <label><?= substr($product->product_name, 0, 34) . '..'; ?></label><br>
                                                                         <!--<label><? Html::tag('button', Html::encode(substr($product->product_name, 0, 15)), ['title' => $product->product_name, 'class' => 'username color edit-btn']); ?> </label>-->
                                                <Label>AED :</label><span><?= sprintf("%0.2f", $orderdtl->sub_total); ?> for <?= $orderdtl->quantity ?> Product</span><br>
                                                <label>EAN : </label><span><?= $product->item_ean ?></span><br>
                                                <label> Vendor : </label><span><?= $vendor->first_name . ' ' . $vendor->last_name ?></span>
                                            </div>

                                            <div class="specification_view">
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
                                                                <tr><td class="specfic_label"> <?= $specification_model->filter_tittle . ':'; ?> </td><td class="value"><?= $specification->Product_feature_text ?></td></tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </a>

                                                                                                                                                                    <!--<p>Rs:2550.00</p> EAN : 545856 <p>Vendor : Vendor Name</p>-->
                                </div>
                                </a>
                                <?php
                                $i++;
                            }
                            ?>



                        </div>
                        <div class="col-md-7">

                            <?php
                            $i = '1';
                            foreach ($orderdetails as $orderdtl) {
                                $prdctvendor = ProductVendor::findone($orderdtl->product_id);
                                $product = Products::findone($prdctvendor->product_id);
                                $hide = $i != '1' ? 'hide' : '';
                                ?>
                                <div class="row detail_row <?= $hide ?>" id="row_<?= $i ?>">
                                    <table id="w1" class="table table-striped table-bordered detail-view">
                                        <tbody>
                                            <tr>
                                                <th>Product Name</th>
                                                <td><?= $product->product_name ?></td>
                                            </tr>
                                            <tr>
                                                <th>Price</th>
                                                <td><?= $prdctvendor->price ?></td>
                                            </tr>
                                            <tr>
                                                <th>Offer Price</th>
                                                <td><?= $prdctvendor->offer_price ?></td>
                                            </tr>
                                            <tr>
                                                <th>Quantity</th>
                                                <td><?= $orderdtl->quantity ?></td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <?php
                                                if ($orderdtl->status == '0')
                                                    $status = 'Order Pending';
                                                if ($orderdtl->status == '1')
                                                    $status = 'Order Placed';
                                                if ($orderdtl->status == '2')
                                                    $status = 'Order Dispatched';
                                                if ($orderdtl->status == '3')
                                                    $status = 'Order Delivered';
                                                ?>
                                                <?php if ($prdctvendor->full_fill != '1') { ?>
                                                    <td><?= $status ?></td>
                                                    <?php
                                                } else {
                                                    if ($orderdtl->status == '0') {
                                                        $filter = ['0' => 'Pending', '1' => 'Placed', '2' => 'Dispatched', '3' => 'Delivered'];
                                                    } else {
                                                        $filter = ['1' => 'Placed', '2' => 'Dispatched', '3' => 'Delivered'];
                                                    }
                                                    ?>
                                                    <td>
                                                        <?= \yii\helpers\Html::dropDownList('status', null, $filter, ['options' => [$orderdtl->status => ['Selected' => 'selected']], 'class' => 'form-control status_field', 'id' => 'order_admin_status-' . $orderdtl->id,]); ?>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <th>Commission</th>
                                                <td><?= OrderDetails::commission_product($orderdtl)?></td>
                                            </tr>
                                            <tr>
                                                <th>Comment</th>
                                                <td>
                                                    <?php if ($prdctvendor->full_fill == '1') { ?>
                                                        <div class="cbp_tmlabel" style="float: right" >
                                                            <textarea rows="3" cols="30" class="comment_box" id="comment_box_<?= $orderdtl->id ?>"></textarea><br>
                                                            <button class="btn btn-info comment_submit" type="button" id="<?= $orderdtl->id ?>">Add Comment</button>

                                                        </div>
                                                    <?php } ?>
                                                    <ol>
                                                        <?php
                                                        $comments = \common\models\OrderHistory::find()->where(['order_id' => $orderdtl->order_id, 'product_id' => $orderdtl->product_id])->all();
                                                        foreach ($comments as $comment) {
                                                            if (!empty($comment->comment)) {
                                                                ?>
                                                                <li><?= $comment->comment ?></li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ol>
                                                </td>
                                            </tr>
                                        </tbody></table>


                                </div>
                                <?php
                                $i++;
                            }
                            ?>
                        </div>



                    </div>
                    <div class="col-md-8">

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="order-master-index">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Conclusion</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="shipping-wrap">
                                <table cellspacing="0" class="table">
                                    <?php
                                    $commission = OrderDetails::commission($orderdetails);//commission for order details
                                    ?>
                                    <tbody>
                                        <tr class="cart-subtotal">
                                            <th>Subtotal</th>
                                            <td data-title="Subtotal"><span class="woocommerce-Price-amount amount cart_subtotal"><?= sprintf("%0.2f", $ordermaster->total_amount); ?><span class="woocommerce-Price-currencySymbol"> AED</span></span></td>
                                        </tr>
                                        <tr class="cart-subtotal">
                                            <th>Shipping charge</th>
                                            <td data-title="Subtotal"><span class="woocommerce-Price-amount amount shipping-cost"><?= sprintf("%0.2f", $ordermaster->shipment_amount); ?><span class="woocommerce-Price-currencySymbol"> AED</span></span></td>
                                        </tr>

                                        <tr class="cart-promotion">
                                            <th>Promotion Discount</th>
                                            <td data-title="Subtotal"><span class="woocommerce-Price-amount amount"><spn class="promotion_discount"></spn><?= sprintf("%0.2f", $ordermaster->promotion_discount); ?><span class="woocommerce-Price-currencySymbol"> AED</span></span></td>
                                        </tr>
                                        <tr class="order-total">
                                            <th>Grand Total</th>
                                            <td data-title="Total"><strong><span class="woocommerce-Price-amount amount grand_total"><?= sprintf("%0.2f", $ordermaster->net_amount); ?><span class="woocommerce-Price-currencySymbol"> AED</span></span></strong> </td>
                                        </tr>
                                        <tr class="commission">
                                            <th>Commission</th>
                                            <td data-title="Subtotal"><span class="woocommerce-Price-amount amount"><spn class="promotion_discount"></spn><?= sprintf("%0.2f", $commission); ?><span class="woocommerce-Price-currencySymbol"> AED</span></span></td>
                                        </tr>

                                    </tbody></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
    });
</script>

