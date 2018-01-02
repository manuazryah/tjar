<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>css/invoice.css">
        <style>
            footer {
                padding-top: 20px;
                padding-bottom: 20px;
                font-size: 9px;
                color: #f00;
                text-align: center;
                border-top: 2px solid #5a5959;
                width: 100%;
            }
            table th{
                text-align: left;
            }
            @page {
                size: A4;
                margin: 11mm 17mm 17mm 17mm;
            }

            @media print {
                /*                footer {
                                    position: fixed;
                                    bottom: 0;
                                }*/

                .content-block, p {
                    page-break-inside: avoid;
                }

                html, body {
                    width: 210mm;
                    height: 297mm;
                }
            }
        </style>
    </head>
    <body>
        <div class="container" style="border: 1px solid #5a5959;">
            <div class="header" style="border-bottom: 2px solid #5a5959;">
                <div class="main-left" style="width: 10%;padding-bottom: 10px;padding-left: 10px;">
                    <img src="<?= Yii::$app->homeUrl ?>../images/logo.png" style="height: 85px;"/>

                </div>
                <div class="main-left" style="width: 75%;padding-left: 70px;padding-top: 12px;">
                    <div>
                        <span style="font-size: 15px;font-weight: 500;">Contact Us :  +971 (0)4 3217 112 || info@tjar.com</span>
                    </div>
                    <!--                    <div>
                                            <span style="font-size: 22px;font-weight: 600;">Coral Perfume Industry LLC</span> , <span style="font-style: italic;font-size: 14px;">Address : Coral Perfume Industry LLC Door No. 9, Warehouse No: 13, 18th Street, Near Al Ahil Driving school, Industrial Area-4, Al Quoz, Dubai. UAE</span>
                                        </div>-->
                </div>
                <br/>
            </div>

            <div class="header" style="border-bottom: 2px solid #5a5959;">
                <div class="main-left" style="width: 30%;padding-right: 20px;padding-left: 10px;">
                    <p style="font-weight: 600;">Order ID : <?= $order_master->order_id ?></p>
                    <p style="font-weight: 600;">Order Date : <span style="font-weight: 100;font-size: 15px;"><?= $order_master->order_date ?></span></p>
                    <p style="font-weight: 600;">Invoice Date : <span style="font-weight: 100;font-size: 15px;"><?= date('d-m-Y') ?></span></p>
                </div>
                <div class="main-left" style="width: 30%;padding-right: 20px;">
                    <p style="font-weight: 600;">Billing Address</p>
                    <?php
                    $bill_address = \common\models\UserAddress::findOne($order_master->bill_address_id);
                    ?>
                    <p><?= $bill_address->address . '<br/> ' . $bill_address->landmark ?></p>
                    <p>Phone: <?= $bill_address->phone ?></p>
                </div>
                <div class="main-left" style="width: 30%;padding-right: 20px;">
                    <p style="font-weight: 600;">Shipping Address</p>
                    <?php
                    $ship_address = \common\models\UserAddress::findOne($order_master->ship_address_id);
                    ?>
                    <p><?= $ship_address->address . '<br/> ' . $ship_address->landmark ?></p>
                    <p>Phone: <?= $ship_address->phone ?></p>
                </div>
                <br/>
            </div>

            <div>
                <table style="width: 100%;padding-bottom: 10px;border-bottom: 2px solid #5a5959;padding-left: 10px;">
                    <tr>
                        <th style="width:50%">Product</th>
                        <th style="width:15%"><span style="float: right;padding-right: 20px;">Qty</span></th>
                        <th style="width:15%"><span style="float: right;padding-right: 20px;">Price</span></th>
                        <th style="width:20%"><span style="float: right;padding-right: 20px;">Total</span></th>
                    </tr>
                </table>
                <table style="width: 100%;padding-bottom: 10px;border-bottom: 2px solid #5a5959;padding-left: 10px;">
                    <?php
                    $qty_total = 0;
                    $amount_total = 0;
                    foreach ($order_details as $value) {
                        $product_vendor = common\models\ProductVendor::find()->where(['id' => $value->product_id, 'full_fill' => '1'])->one();
                        if ($product_vendor) {
                            $product = common\models\Products::findOne($product_vendor->product_id);
                            ?>
                            <tr>
                                <td style="width:50%"><?= $product->product_name ?></td>
                                <td style="width:15%"><span style="float: right;padding-right: 20px;"><?= $value->quantity ?></span></td>
                                <td style="width:15%"><span style="float: right;padding-right: 20px;"><?= sprintf('%0.2f', $value->amount) ?></span></td>
                                <td style="width:20%"><span style="float: right;padding-right: 20px;"><?= sprintf('%0.2f', $value->sub_total) ?></span></td>
                            </tr>
                            <?php
                            $qty_total += $value->quantity;
                            $amount_total += ($value->quantity * $value->amount);
                        }
                    }
//                    $shiplimit = \common\models\Settings::findOne('1')->value;
//                    if ($shiplimit > $amount_total) {
//                        $delivary_charge = \common\models\Settings::findOne('2')->value;
//                    }
                    $delivary_charge = common\models\Cart::shipping_charge($order_details);
                    ?>
                </table>
                <table style="width: 100%;padding-bottom: 10px;border-bottom: 2px solid #5a5959;">
                    <tr>
                        <td style="width:50%"><span style="float: right;font-weight: 600;padding-right: 20px;">Total</span></td>
                        <td style="width:15%"><span style="float: right;font-weight: 600;padding-right: 20px;"><?= $qty_total ?></span></td>
                        <td style="width:15%"></td>
                        <td style="width:20%"><span style="float: right;font-weight: 600;padding-right: 20px;"><?= sprintf('%0.2f', $amount_total); ?></span></td>
                    </tr>
                    <?php
                    $promotion_disvount = 0;
                    if (isset($promotions) && $promotions > 0) {
                        $promotion_disvount = $promotions;
                        ?>
                        <tr>
                            <td style="width:50%"><span style="float: right;font-weight: 600;padding-right: 20px;">Coupon Code Added</span></td>
                            <td style="width:15%"></td>
                            <td style="width:15%"></td>
                            <td style="width:20%"><span style="float: right;font-weight: 600;padding-right: 20px;"><?= sprintf('%0.2f', $promotions); ?></span></td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <td style="width:50%"><span style="float: right;font-weight: 600;padding-right: 20px;">Delivery Charges</span></td>
                        <td style="width:15%"></td>
                        <td style="width:15%"></td>
                        <td style="width:20%"><span style="float: right;font-weight: 600;padding-right: 20px;"><?= sprintf('%0.2f', $delivary_charge); ?></span></td>
                    </tr>
                </table>
                <?php $grand_total = $amount_total + $delivary_charge - $promotion_disvount; ?>
                <table style="width: 100%;padding-bottom: 10px;">
                    <tr>
                        <td style="width:65%"><span style="float: right;font-weight: 600;padding-right: 20px;"> Grand Total</span></td>
                        <td style="width:15%"></td>
                        <td style="width:20%"><span style="float: right;font-weight: 600;padding-right: 20px;"><?= sprintf('%0.2f', $grand_total); ?></span></td>
                    </tr>
                </table>
            </div>
            <footer>
                This is computer generated invoice.
            </footer>
        </div>
    </body>
</html>
<!--<script type="text/javascript">

        window.print();
        setTimeout(function () {
                window.close();
        }, 500);
</script>-->