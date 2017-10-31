<?php

use yii\helpers\Html;
use common\components\LeftMenuWidget;

/* @var $this yii\web\View */
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-t-b-30 bg-white">
            <div class="my-account-sidebar">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <h3 class="MyAccount-title">Wishlist</h3>
                    <?= LeftMenuWidget::widget() ?>
                </div>
            </div>

            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="MyAccount-content">
                    <div class="hidden-lg hidden-md hidden-sm">
                        <div class="payment-cart">
                            <div class="col-xs-12 mob-car-list">

                                <div class="media">
                                    <div class="track">
                                        <div class="col-xs-9 delivery-date">
                                            <a href="" onclick="" rel="nofollow" data-quantity="1" data-product_sku="" class="add_to_cart_button Proceed" style="padding: 10px 15px; font-size: 13px;"> Add to cart</a>
                                        </div>
                                        <div style="float: right" class="product-remove">
                                            <div>
                                                <a href="" class="remove remove_from_wishlist" title="Remove this product">×</a>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="thumbnail pull-left col-xs-3" href="#"> <img class="media-object" src="images/products/1.png"> </a>
                                    <div class="col-xs-8">
                                        <h4 style="margin: 20px 0;" class="product-heading"><a href="#">Oppo F3 (Black,64 GB) (4GB RAM)</a></h4>
                                        <div class="col-xs-4 pad-0">
                                            <p class="price">Price</p>
                                        </div>
                                        <div class="col-xs-7">
                                            <p class="text-center">AED 200</p>
                                        </div>
                                        <div class="col-xs-4 pad-0">
                                            <p class="price">Stock</p>
                                        </div>
                                        <div class="col-xs-7 text-center">
                                            <div class="product-stock-status" data-title="Stock Status">
                                                <span class="wishlist-in-stock" style="color: #297E29;">In Stock</span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <table class="wishlist_table hidden-xs" data-pagination="no" data-per-page="5" data-page="1" data-id="" data-token="">


                        <thead>
                            <tr>

                                <th class="product-remove"></th>

                                <th class="product-thumbnail"></th>

                                <th class="product-name-title">
                                    Product Name
                                </th>


                                <th class="product-price">
                                    <span class="nobr">
                                        Unit Price
                                    </span>
                                </th>



                                <th class="product-stock-status">
                                    <span class="nobr">
                                        Stock Status
                                    </span>
                                </th>
                                <th class="product-add-to-cart">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr id="">

                                <td class="product-remove">
                                    <div>
                                        <a href="" class="remove remove_from_wishlist" title="Remove this product">×</a>
                                    </div>
                                </td>

                                <td class="product-thumbnail">
                                    <a href="">
                                        <img src="<?= yii::$app->homeUrl; ?>images/products/1.png" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="" >                            </a>
                                </td>

                                <td class="product-name" data-title="Product Name">
                                    <a href="">Oppo F3 (Black,64 GB) (4GB RAM)</a>
                                </td>

                                <td class="product-price" data-title="Unit Price">
                                    <span class="woocommerce-Price-amount amount"><span class="currency">AED </span>200.00</span>                            </td>

                                <td class="product-stock-status" data-title="Stock Status">
                                    <span class="wishlist-in-stock">In Stock</span>                            </td>

                                <td class="product-add-to-cart">
                                    <!-- Date added -->

                                    <!-- Add to cart button -->
                                    <a href="" onclick="" rel="nofollow" data-quantity="1" data-product_sku="" class="add_to_cart_button Proceed"> Add to cart</a>
                                    <!-- Change wishlist -->

                                    <!-- Remove from wishlist -->
                                </td>
                            </tr>

                            <tr id="">

                                <td class="product-remove">
                                    <div>
                                        <a href="" class="remove remove_from_wishlist" title="Remove this product">×</a>
                                    </div>
                                </td>

                                <td class="product-thumbnail">
                                    <a href="">
                                        <img src="<?= yii::$app->homeUrl; ?>images/products/1.png" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="" >                            </a>
                                </td>

                                <td class="product-name" data-title="Product Name">
                                    <a href="">Oppo F3 (Black,64 GB) (4GB RAM)</a>
                                </td>

                                <td class="product-price" data-title="Unit Price">
                                    <span class="woocommerce-Price-amount amount"><span class="currency">AED </span>200.00</span>                            </td>

                                <td class="product-stock-status" data-title="Stock Status">
                                    <span class="wishlist-in-stock">In Stock</span>                            </td>

                                <td class="product-add-to-cart">
                                    <!-- Date added -->

                                    <!-- Add to cart button -->
                                    <a href="" onclick="" rel="nofollow" data-quantity="1" data-product_sku="" class="add_to_cart_button Proceed"> Add to cart</a>
                                    <!-- Change wishlist -->

                                    <!-- Remove from wishlist -->
                                </td>
                            </tr>
                        </tbody>

                        <tfoot class="marg-top-20">
                            <tr>
                                <td colspan="6">
                                    <div class="share marg-top-20">
                                        <h4 class="">Share on:</h4>
                                        <ul>
                                            <li style="list-style-type: none; display: inline-block;">
                                                <a href="" target="_blank" class="" title="Facebook"><i class="fa fa-facebook facebook"></i></a>
                                            </li>
                                            <li style="list-style-type: none; display: inline-block;">
                                                <a href="" target="_blank" class="" title="Twiter"><i class="fa fa-twitter twiter"></i></a>
                                            </li>
                                            <li style="list-style-type: none; display: inline-block;">
                                                <a href="" target="_blank" class="" title="Pintrest"><i class="fa fa-pinterest-p pintrest"></i></a>
                                            </li>
                                            <li style="list-style-type: none; display: inline-block;">
                                                <a href="" target="_blank" class="" title="Google+"><i class="fa fa-google-plus googleplus"></i></a>
                                            </li>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>