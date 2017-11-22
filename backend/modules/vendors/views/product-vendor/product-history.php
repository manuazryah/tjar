<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\ProductVendor */

$this->title = 'Product History';
$this->params['breadcrumbs'][] = ['label' => 'Product Vendors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .sell-pro-div-right p{
        border-bottom: 1px solid #e8e5e5;
        padding-bottom: 5px;
        font-size: 12px;
    }
    .sell-pro-div-right p span{
        color: #4a4949;
        font-size: 12px;
    }
    .outer {
        width: 257px;
        border: 1px solid #312e2e59;
        overflow: hidden;
        height: 250px;
        position: relative;
        background-color: white;
    }
    .inner {
        float: left;
        position: relative;
        left: 50%;
    }
    .inner img {
        display: block;
        position: relative;
        left: -50%;
        height: 250px;
        padding: 12px;
    }
    .manage {
        position: relative;
        /*display: inline-block;*/
    }
    .manage:hover .tooltiptext {
        visibility: visible;
    }

    .manage .tooltiptext {
        padding-left: 0px !important;
        padding-right:  0px !important;
        visibility: hidden;
        width: 55px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        position: absolute;
        z-index: 1;
        font-size: 14px;

        /* Position the tooltip */
        position: absolute;
        z-index: 1;
    }
    .sale-count-left{
        color: #0a0a0a;
        font-weight: 600;
    }
    .sale-count-right{
        padding-left: 20px;
        color: #333131;
    }
    .search-history .product-vew-pop{
        padding-left: 0px;
    }
</style>
<?php yii\widgets\Pjax::begin(['id' => 'vendor_product_history']); ?>
<div class="row">

    <div class="panel panel-default">
        <div class="panel-heading" style="border-bottom: none;">
            <div>
                <h3 class="panel-title" style="font-size: 17px;font-weight: 600;"><?= Html::encode($this->title) ?></h3>
                <!--<span class="product_venode_view_span"><?= !empty($model->sku) ? '<br>EAN:' . $model->sku : '' ?></span>-->
            </div>


            <div style="float:left;padding-top: 13px;">
                <?= Html::a('<i class="fa-th-list manage"><span class="tooltiptext">List All</span></i>', ['index', 'vendor_status' => 1], ['class' => 'btn btn-icon product_venode_view_btns']) ?>
            </div>
            <div style="float:right">

            </div>

        </div>
        <div class="panel-body search-history" style="padding-top:0px;">
            <?= Html::beginForm(['product-history', 'id' => $id], 'post') ?>
            <div class="col-md-2 col-lg-2 col-sm-3 product-vew-pop">
                <?php
                echo DatePicker::widget([
                    'name' => from_date,
                    'value' => $from,
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => ['placeholder' => 'Select from date'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
                ?>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-3 product-vew-pop">
                <?php
                echo DatePicker::widget([
                    'name' => to_date,
                    'value' => $to,
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => ['placeholder' => 'Select to date'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
                ?>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-3 product-vew-pop">
                <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true" style="padding: 6px;font-size: 16px;"></i>', ['style' => 'border: 1px solid #d0cdcd;background: #f9f9f9;']) ?>
            </div>
            <?= Html::endForm() ?>
        </div>
        <div class="panel-body" style="border: 1px solid #d2cdcd; margin-top: 21px;padding: 19px 0px;padding-top: 0px;">
            <div style="text-align: right; padding-right: 21px;border-bottom: 1px solid #d2cdcd;">
                <p style="padding: 8px 0px;
                   font-size: 11px;"><?= $model->product->mainCategory->name . ' > ' . $model->product->categoryName->category_name . ' > ' . $model->product->subCategoryName->subcategory_name . '><b style="color:black;">' . $model->product->product_name ?></b></p>
            </div>
            <?php
            $sale_count = \common\models\OrderDetails::getSalecount($from, $to, $model->id);
            $amount_paid_total = \common\models\OrderDetails::getTotalAmount($from, $to, $model->id, 'amount');
            ?>
            <div class="col-md-12 col-lg-12 col-sm-12 product-vew-pop" style="padding-top: 20px;">
                <div class="col-md-4 col-lg-4 col-sm-12 product-vew-pop">
                    <span class="sale-count-left">Total Sale:</span>
                    <span class="sale-count-right">
                        <?= $sale_count ?>
                    </span>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-12 product-vew-pop">
                    <span class="sale-count-left">Sale Amount:</span>
                    <span class="sale-count-right">
                        <?= $amount_paid_total = '' ? sprintf('%0.2f', 0) : sprintf('%0.2f', $amount_paid_total); ?>
                    </span>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-12 product-vew-pop">
                    <span class="sale-count-left">Total View:</span>
                    <span class="sale-count-right">
                        1
                    </span>
                </div>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12 product-vew-pop">
                <div class="col-md-12 col-lg-12 col-sm-12 product-vew-pop"  style="padding-top: 25px;color: #403e3e;">
                    <h5 style="font-size: 14px;font-weight: bold;text-decoration: underline;">The same product is also sell following vendors</h5>
                </div>
                <?php
                if (!empty($other_vendors)) {
                    ?>
                    <div class="col-md-12 col-lg-12 col-sm-12 product-vew-pop"  style="padding-top: 25px;color: #403e3e;">
                        <table class="table">
                            <tr>
                                <th>Vendor Name</th>
                                <th> Product Price</th>
                            </tr>
                            <?php
                            foreach ($other_vendors as $other_vendor) {
                                ?>
                                <tr>
                                    <td><?= \common\models\Vendors::findOne($other_vendor->vendor_id)->first_name ?></td>
                                    <td><?= sprintf('%0.2f', $other_vendor->price) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                <?php } else {
                    ?>
                    <div class="col-md-12 col-lg-12 col-sm-12 product-vew-pop"  style="padding-top: 25px;color: #403e3e;">
                        <p>No more vendors sell this product</p>
                    </div>
                <?php }
                ?>
            </div>
        </div>

    </div>

</div>
<?php yii\widgets\Pjax::end(); ?>
<script>
    $(document).ready(function () {
        $('.status_pause').click(function (e) {
            e.preventDefault();
            var data = this.id;
            var dat = data.split('_');
            $.ajax({
                url: homeUrl + 'vendors/product-vendor/change-vendor-status',
                type: "post",
                data: {status: dat[1], id: dat[0]},
                success: function (data) {
                    alert('Status Changed Sucessfully');
                    $.pjax.reload({container: '#vendor_product_view'});
                }, error: function () {
                }
            });

        });
    });
</script>



