<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Products;
use common\models\ProductVendor;
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
        width: fit-content;
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
    ?>
    <div id='modalContent'></div>;
    <?php yii\bootstrap\Modal::end(); ?>
    <div class="row">
        <div class="col-md-12">
            <?= Html::a('<i class="fa-th-list"></i><span> Manage Order </span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">User Information</h3>


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
                <div class="panel-body">
                    <div class="panel-body"><div class="products-view">
                            <div class="product-vendor-view">


                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="panel-body">
                                            <div class="col-md-12 col-lg-12 col-sm-12 product-vew-pop">
                                                <div class="col-md-4" style="padding-top: 15px;">

                                                    <div class="clearfix"></div>
                                                    <?php
                                                    $i = '1';
                                                    foreach ($orderdetails as $orderdtl) {
                                                        $prdctvendor = ProductVendor::findone($orderdtl->product_id);
                                                        $product = Products::findone($prdctvendor->product_id);
                                                        ?>
                                                        <a href="javascript:void(0)" class="order_detail" id="<?= $i; ?>"> 
                                                            <div style="padding: 11px;">
                                                                <div class="album-image">
                                                                    <?php
                                                                    $profile_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '.' . $product->gallery_images;
                                                                    if (file_exists($profile_image)) {
                                                                        ?>
                                                                        <img src="<?= Yii::$app->homeUrl . '../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '_thumb.' . $product->gallery_images ?>" width="120px" class="img-responsive">

                                                                    <?php } else { ?>
                                                                        <img src="<?= yii::$app->homeUrl; ?>../uploads/products/gallery_dummy.png" width="138px" class="img-responsive">

                                                                    <?php } ?>
                                                                    <label><?= Html::tag('button', Html::encode(substr($product->product_name, 0, 15)), ['title' => $product->product_name, 'class' => 'username color edit-btn']); ?> </label>
                                                                    <p>Rs : 2550.00</p><p>EAN : 545856</p> Vendor : Vendor Name
                                                                </div>

                                                                        <!--<p>Rs:2550.00</p> EAN : 545856 <p>Vendor : Vendor Name</p>--> 
                                                            </div>
                                                        </a>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>



                                                </div>
                                                <div class="col-md-8">
                                                    
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
                                                                        <td><?= $status ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Comment</th>
                                                                        <td>
                                                                            <div class="cbp_tmlabel">
                                                                                <p>Tolerably earnestly middleton extremely .</p>
                                                                            </div>
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


                    </div>
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
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


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
        $('.admin_status_field').on('change', function () {
            var change_id = $(this).attr('id').match(/\d+/);
            var vendor_status = $(this).val();
            $.ajax({
                url: homeUrl + 'orders/order-master/change-vendor-status',
                type: "post",
                data: {status: vendor_status, id: change_id},
                success: function (data) {
                    alert('Status Changed Sucessfully');
                }, error: function () {
                }
            });
        });
    });
</script>

