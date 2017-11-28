<?php

namespace frontend\controllers;

use yii;
use common\models\Products;
use common\models\Cart;
use common\models\User;
use common\models\ProductVendor;
use common\models\UserAddress;
use common\models\OrderMaster;
use common\models\OrderDetails;
use common\models\Settings;

class CartController extends \yii\web\Controller {

    public function init() {
        date_default_timezone_set('Asia/Kolkata');
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionBuynow() {
        if (yii::$app->request->isAjax) {
            $vendor_prdct = Yii::$app->request->post()['vendor_prdct'];
            $qty = Yii::$app->request->post()['qty'];
            $prdct_vendor = ProductVendor::findOne(yii::$app->EncryptDecrypt->Encrypt('decrypt', $vendor_prdct));
            $condition = Cart::usercheck();
            $user_id = isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : '';


            $cart = Cart::find()->where(['product_id' => $prdct_vendor->id])->andWhere($condition)->one();
            if (!empty($cart)) {
                $quantity = ($cart->quantity) + $qty;
                $cart->quantity = $quantity > $prdct_vendor->qty ? $prdct_vendor->qty : $quantity;
                $cart->save();
                Cart::cart_content();
            } else {
                Cart::add_to_cart($user_id, Yii::$app->session['temp_user'], $prdct_vendor->id, $qty);
                Cart::cart_content();
            }
        }
    }

    public function actionBuycart() {
        if (yii::$app->request->isAjax) {
            $vendor_prdct = Yii::$app->request->post()['vendor_prdct'];
            $qty = Yii::$app->request->post()['qty'];
            $prdct_vendor = ProductVendor::findOne(yii::$app->EncryptDecrypt->Encrypt('decrypt', $vendor_prdct));
            $user_id = isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : '';

            if (Cart::add_to_cart($user_id, Yii::$app->session['temp_user'], $prdct_vendor->id, $qty)) {
                echo json_encode(array('msg' => 'success'));
                exit;
            }
        }
    }

    public function actionMycart() {
        if (isset(Yii::$app->user->identity->id)) {
            if (isset(Yii::$app->session['temp_user'])) {
                Cart::changecart(Yii::$app->session['temp_user']);
            }
        }
        $condition = Cart::usercheck();
        $cart_items = Cart::find()->where($condition)->all();
        $model = new UserAddress();
        $order = new OrderMaster();
        if ($order->load(Yii::$app->request->post())) {
//            $this->check_product($cart_items);
            $ship_address = Yii::$app->request->post()['OrderMaster']['ship_address_id'];
            $bill_address = Yii::$app->request->post()['OrderMaster']['bill_address_id'];
            $check = Cart::CheckTempsession(Yii::$app->request->post());
            if ($check == 0)
                Cart::checkout($ship_address, $bill_address);
        }


        if (!empty($cart_items)) {
            \common\models\TempSession::deleteAll(['user_id' => Yii::$app->user->identity->id]);
//            $this->check_product($cart_items);
            $subtotal = Cart::total($cart_items);
            $shippinng_limit = Settings::findOne(2)->value;
            $shipping = $shippinng_limit > $subtotal ? Cart::shipping_charge($cart_items) : '0';
            $grand_total = $shipping + $subtotal;
//            $grand_total = $this->net_amount($subtotal, $cart_items);
            return $this->render('cart', ['cart_items' => $cart_items, 'subtotal' => $subtotal, 'model' => $model, 'order' => $order, 'shipping' => $shipping, 'grand_total' => $grand_total]);
        } else {
            return $this->render('emptycart');
        }
    }

    /*
     * check temp session value and post value
     */

//    public function CheckTempsession($post) {
//        $check = 0;
//        $temp = \common\models\TempSession::find()->where(['user_id' => Yii::$app->user->identity->id, 'type_id' => 3])->select('value')->all();
//        $temp_coupons = '';
//        $t = 0;
//        foreach ($temp as $value) {
//            $t++;
//            if ($t != 1) {
//                $temp_coupons .= ',';
//            }
//            $temp_coupons .= $value->value;
//        }
//        $coupons = $post['promotion_codes'];
//        if ($coupons != $temp_coupons) {
//            $check = 1;
//        }
//        $ship_address = \common\models\TempSession::find()->where(['user_id' => Yii::$app->user->identity->id, 'type_id' => 1])->one();
//        $bill_address = \common\models\TempSession::find()->where(['user_id' => Yii::$app->user->identity->id, 'type_id' => 2])->one();
//        if ($post['OrderMaster']['ship_address_id'] != $ship_address->value) {
//            $check = 1;
//        } if ($post['OrderMaster']['bill_address_id'] != $bill_address->value) {
//            $check = 1;
//        }
//        return $check;
//    }
//    public function Checkout($ship_address, $bill_address) {
//        if (isset(Yii::$app->user->identity->id)) {
//            $this->check_product();
//            $cart = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
//            $orders = $this->addOrder($cart, $ship_address, $bill_address);
//            if ($this->orderProducts($orders, $cart)) {
//                $this->Addpromotions($orders);
//                $this->clearcart($cart);
//                $this->stock_clear($orders);
//                $this->redirect(['checkout/payment', 'id' => $orders['order_id']]);
//            } else {
//                $this->redirect('mycart');
//            }
//        } else {
//            $this->redirect(array('site/login'));
//        }
//    }

    public function actionAddShipping() {
        if (yii::$app->request->isAjax) {
            $delivery = '';
            if (isset(Yii::$app->request->post()['UserAddress']['delivery'])) {
                $delivery = Yii::$app->request->post()['UserAddress']['delivery'];
            }
            if (isset(Yii::$app->request->post()['UserAddress']['billing'])) {
                Cart::SaveTemp(1, Yii::$app->request->post()['UserAddress']['billing']);
                !empty($delivery) ? Cart::SaveTemp(2, Yii::$app->request->post()['UserAddress']['billing']) : '';
                echo json_encode(array('msg' => 'success', 'id' => Yii::$app->request->post()['UserAddress']['billing'], 'delivery' => $delivery));
                exit;
            } else {
                $address_id = Cart::adduseraddress();
                Cart::SaveTemp(1, $address_id);
                !empty($delivery) ? Cart::SaveTemp(2, $address_id) : '';

                echo json_encode(array('msg' => 'success', 'id' => $address_id, 'delivery' => $delivery));
                exit;
            }
        }
    }

    public function actionAddBilling() {
        if (yii::$app->request->isAjax) {
            if (isset(Yii::$app->request->post()['UserAddress']['billing'])) {
                Cart::SaveTemp(2, Yii::$app->request->post()['UserAddress']['billing']);
                echo json_encode(array('msg' => 'success', 'id' => Yii::$app->request->post()['UserAddress']['billing']));
                exit;
            } else {
                $address_id = Cart::adduseraddress();
                Cart::SaveTemp(2, $address_id);
                echo json_encode(array('msg' => 'success', 'id' => $address_id));
                exit;
            }
        }
    }

//    function adduseraddress() {
//        $model = new UserAddress();
//        $model->user_id = Yii::$app->user->identity->id;
//        $model->first_name = Yii::$app->request->post()['UserAddress']['first_name'];
//        $model->last_name = Yii::$app->request->post()['UserAddress']['last_name'];
//        $model->address = Yii::$app->request->post()['UserAddress']['address'];
//        $model->city_id = Yii::$app->request->post()['UserAddress']['city_id'];
//        $model->landmark = Yii::$app->request->post()['UserAddress']['landmark'];
//        $model->country_id = Yii::$app->request->post()['UserAddress']['country_id'];
//        $model->street_id = Yii::$app->request->post()['UserAddress']['street_id'];
//        $model->phone = Yii::$app->request->post()['UserAddress']['phone'];
//        $model->pincode = Yii::$app->request->post()['UserAddress']['pincode'];
//        $model->address = Yii::$app->request->post()['UserAddress']['address'];
//        if ($model->validate() && $model->save()) {
//            return $model->id;
//        }
//    }
//    public function orderProducts($orders, $carts) {
//        foreach ($carts as $cart) {
//            $prod_details = ProductVendor::findOne($cart->product_id);
//
//            $model_prod = new OrderDetails;
//            $model_prod->master_id = $orders['master_id'];
//            $model_prod->order_id = $orders['order_id'];
//            $model_prod->user_id = Yii::$app->user->identity->id;
//            $model_prod->product_id = $cart->product_id;
//            $model_prod->vendor_id = $prod_details->vendor_id;
//            $model_prod->quantity = $cart->quantity;
//            if ($prod_details->offer_price == '0' || $prod_details->offer_price == '') {
//                $price = $prod_details->price;
//            } else {
//                $price = $prod_details->offer_price;
//            }
//            $model_prod->amount = $price;
//            $model_prod->sub_total = ($cart->quantity) * ($price);
//            $model_prod->status = '0';
//            $model_prod->DOC = date('Y-m-d');
//            if ($model_prod->save()) {
//                
//            }
//        }
//        return TRUE;
//    }
//    function addOrder($cart, $ship_address, $bill_address) {
//        $serial_no = Settings::findOne(1)->value;
//        $prefix = Settings::findOne(1)->prefix;
//        $model = new OrderMaster;
//        $model->order_id = $this->generateProductEan($prefix, $serial_no);
//        $model->user_id = Yii::$app->user->identity->id;
//        $model->total_amount = Cart::total($cart);
//        $model->net_amount = Cart::net_amount($model->total_amount, $cart);
//        $model->order_date = date('Y-m-d H:i:s');
//        $model->DOC = date('Y-m-d');
//        $model->ship_address_id = $ship_address;
//        $model->bill_address_id = $bill_address;
//        $model->status = '1';
//        if ($model->save()) {
//            return ['master_id' => $model->id, 'order_id' => $model->order_id];
//        }
//    }
//    function stock_clear($orders) {
//        $order_details = OrderDetails::find()->where(['order_id' => $orders['order_id']])->all();
//        foreach ($order_details as $order) {
//            $product = ProductVendor::findOne($order->product_id);
//            $product->qty = $product->qty - $order->quantity;
//            $product->save();
//        }
//    }

    /*
     * Add promotion value to db
     */

//    public function Addpromotions($orders) {
//
//        $coupons = \common\models\TempSession::find()->where(['user_id' => Yii::$app->user->identity->id, 'type_id' => 3])->all();
//        $cart_products = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
//        $cart_amount = Cart::total($cart_products);
//        foreach ($coupons as $coupons) {
//            $add_promption = new \common\models\OrderPromotions();
//            $add_promption->order_master_id = $orders['master_id'];
//            $add_promption->promotion_id = $coupons->value;
//            $promotion = \common\models\Promotions::findOne($coupons->value);
//            if ($promotion->type == 1) {
//                $promotion_discount = ($cart_amount * $promotion->price) / 100;
//            } else {
//                $promotion_discount = $promotion->price;
//            }
//            $add_promption->promotion_discount = $promotion_discount;
//            $add_promption->save();
//            if ($promotion->code_usage == 1) {
//                $this->AddUsed($promotion);
//            }
//        }
//    }
//    public function generateProductEan($prefix, $serial_no) {
//        $orderid_exist = OrderMaster::find()->where(['order_id' => $prefix . $serial_no])->one();
//        if (!empty($orderid_exist)) {
//            return $this->generateProductEan($prefix, $serial_no + 1);
//        } else {
//            $this->Updateorderid($serial_no);
//            return $prefix . $serial_no;
//        }
//    }

    public function Updateorderid($id) {
        $orderid = Settings::findOne(1);
        $orderid->value = $id;
        $orderid->save();
        return;
    }

    public function actionCart_remove() {
        if (yii::$app->request->isAjax) {
            $id = Yii::$app->request->post()['id'];
            $condition = Cart::usercheck();
            $cart_items = Cart::find()->where($condition)->all();
            $cart = Cart::find()->where(['id' => $id])->andWhere($condition)->one();
            if ($cart) {
                $cart->delete();
            } else {
                echo json_encode(array('msg' => 'failed', 'reason' => 'Cannot find.'));
                exit;
            }
            $contents = Cart::find()->where($condition)->all();
            if (!empty($contents)) {
                if (count($cart_items) != Yii::$app->request->post()['count']) {
                    $this->redirect(array('cart/mycart'));
                } else {
                    $this->check_cart();
                    $subtotal = Cart::total($contents);
                    $shippinng_limit = Settings::findOne(2)->value;
                    $shipping = $shippinng_limit > $subtotal ? Cart::shipping_charge($contents) : '0';
                    $grandtotal = $shipping + $subtotal;
//                    $grandtotal = $this->net_amount($subtotal, $contents);
                    echo json_encode(array('msg' => 'success', 'subtotal' => sprintf('%0.2f', $subtotal), 'grandtotal' => sprintf('%0.2f', $grandtotal), 'shipping' => sprintf('%0.2f', $shipping)));
                    exit;
                }
            } else {
                return $this->redirect('mycart');
            }
        }
    }

    public function actionFindstock() {
        if (yii::$app->request->isAjax) {
            $cart_id = Yii::$app->request->post()['cartid'];
            $qty = Yii::$app->request->post()['quantity'];
            if (isset($cart_id)) {
                $cart = Cart::findOne(yii::$app->EncryptDecrypt->Encrypt('decrypt', $cart_id));
                if ($qty == 0 || $qty == "") {
                    $qty = 1;
                }
                $product = ProductVendor::find()->where(['id' => $cart->product_id, 'vendor_status' => '1'])->one();
//                $product = ProductVendor::findOne($cart->product_id);
                $check_product = Products::find()->where(['id' => $product->product_id, 'status' => '1'])->one();
                if (!empty($product) && !empty($check_product)) {
                    $quantity = $qty > $product->qty ? $product->qty : $qty;
                    if ($product->offer_price == '0' || $product->offer_price == '') {
                        $price = $product->price;
                    } else {
                        $price = $product->offer_price;
                    }
                    $total = $price * $quantity;
                    echo json_encode(array('msg' => 'success', 'quantity' => $quantity, 'total' => sprintf('%0.2f', $total)));
                } else {
                    echo json_encode(array('msg' => 'error', 'quantity' => '', 'total' => sprintf('%0.2f', '0')));
                }
            }
        }
    }

    public function actionUpdatecart() {
        if (yii::$app->request->isAjax) {
            $cart_id = Yii::$app->request->post()['cartid'];
            $qty = Yii::$app->request->post()['quantity'];
            if (isset($cart_id)) {
                $cart = Cart::findone(yii::$app->EncryptDecrypt->Encrypt('decrypt', $cart_id));
                $product = ProductVendor::findOne($cart->product_id);
//                $check_product = Products::find()->where(['id' => $product->product_id, 'status' => '1'])->one();
                if ($qty == 0 || $qty == "") {
                    $qty = 1;
                }
                $cart->quantity = $qty > $product->qty ? $product->qty : $qty;
                if ($cart->save()) {
                    $this->check_cart();
                    $condition = Cart::usercheck();
                    $cart_items = Cart::find()->where($condition)->all();
                    if (!empty($cart_items)) {
                        if (count($cart_items) != Yii::$app->request->post()['count']) {
                            $this->redirect(array('cart/mycart'));
                        }
                        $subtotal = Cart::total($cart_items);
                        $shippinng_limit = Settings::findOne(2)->value;
                        $shipping = $shippinng_limit > $subtotal ? Cart::shipping_charge($cart_items) : '0';
                        $grandtotal = $shipping + $subtotal;
//                        $grandtotal = $this->net_amount($subtotal, $cart_items);
                    }
                    echo json_encode(array('msg' => 'success', 'subtotal' => sprintf('%0.2f', $subtotal), 'grandtotal' => sprintf('%0.2f', $grandtotal), 'shipping' => sprintf('%0.2f', $shipping)));
                } else {
                    echo json_encode(array('msg' => 'error', 'content' => 'Cannot be Changed'));
                }
            }
        }
    }

    public function actionGetcartcount() {
        if (yii::$app->request->isAjax) {
            $date = $this->date();
            Cart::deleteAll('date <= :date', ['date' => $date]);
            if (isset(Yii::$app->user->identity->id)) {
                if (isset(Yii::$app->session['temp_user'])) {
                    /*                     * *******Change tempuser cart to login user********* */
                    Cart::changecart(Yii::$app->session['temp_user']);
//
                }
            }
            $condition = Cart::usercheck();
            $cart_items = Cart::find()->where($condition)->all();
            if (!empty($cart_items)) {
//                $this->check_product($cart_items);
                $cart_items = Cart::find()->where($condition)->all();
                echo count($cart_items);
                exit;
            } else {
                echo "0";
                exit;
            }
        }
    }

//    function check_product() {
//        $cart_items = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
//        foreach ($cart_items as $cart) {
//            $check_product_vendor = ProductVendor::find()->where(['id' => $cart->product_id, 'vendor_status' => '1'])->one();
//            $check_product = Products::find()->where(['id' => $check_product_vendor->product_id, 'status' => '1'])->one();
//            if (empty($check_product) || empty($check_product_vendor)) {
//                $cart->delete();
////                $this->redirect('mycart');
//            }
//        }
//    }

    function check_cart() {
        $cart_items = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        foreach ($cart_items as $cart) {
            $check_product_vendor = ProductVendor::find()->where(['id' => $cart->product_id, 'vendor_status' => '1'])->one();
            $check_product = Products::find()->where(['id' => $check_product_vendor->product_id, 'status' => '1'])->one();

            if (empty($check_product) || empty($check_product_vendor)) {
                $this->redirect(array('cart/mycart'));
            }
        }
    }

    public function actionGetcarttotal() {
        if (yii::$app->request->isAjax) {
            $condition = Cart::usercheck();
            $cart_items = Cart::find()->where($condition)->all();
            if (!empty($cart_items)) {
                echo sprintf('%0.2f', Cart::total($cart_items));
            } else {
                echo '0';
            }
        }
    }

    public function actionSelectcart() {
        Cart::cart_content();
    }

//    public function total($cart) {
//        $subtotal = '0';
//        foreach ($cart as $cart_item) {
//            $product = ProductVendor::find()->where(['id' => $cart_item->product_id, 'vendor_status' => '1'])->one();
////            $product = ProductVendor::findOne($cart_item->product_id);
//            if ($product->offer_price == '0' || $product->offer_price == '') {
//                $price = $product->price;
//            } else {
//                $price = $product->offer_price;
//            }
//            $subtotal += ($price * $cart_item->quantity);
//        }
//        return $subtotal;
//    }
//    function net_amount($subtotal, $cart) {
//        $grandtotal = $subtotal > '0' ? $subtotal : '0';
//        if ($grandtotal > 0) {
//            $shippinng_limit = Settings::findOne(2)->value;
//            if ($shippinng_limit > $subtotal) {
//                $shipping_charge = Cart::shipping_charge($cart);
////                $extra = Settings::findOne(3)->value;
//                $grandtotal = $shipping_charge + $subtotal;
//            }
//        }
//
//        return $grandtotal;
//    }
//    function shipping_charge($cart) {
//        $shipping_charge = '0';
//        foreach ($cart as $cart_item) {
//            $product = ProductVendor::find()->where(['id' => $cart_item->product_id])->andWhere(['<>', 'free_shipping', '1'])->one();
//            if ($product) {
//                $shipping_charge = Settings::findOne(3)->value;
//                return $shipping_charge;
//            }
//        }
//        return $shipping_charge;
//    }

    public function actionUseraddress() {
        if (yii::$app->request->isAjax) {
            $condition = Cart::usercheck();
            $cart_items = Cart::find()->where($condition)->all();
            if (count($cart_items) != Yii::$app->request->post()['count']) {
                $this->redirect(array('cart/mycart'));
            }
            if (isset(Yii::$app->user->identity->id)) {
                $addresses = UserAddress::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
                $addres_field .= "<option value=''>Select</option>";
                foreach ($addresses as $address) {
                    $selected = $address->default_address=='1'? 'selected=selected':'';
                    $addres_field .= "<option value = '$address->id' $selected>$address->first_name, $address->address , $address->landmark</option>";
                }
                echo json_encode(array('msg' => 'success', 'addres_field' => $addres_field));
            } else {
                echo json_encode(array('msg' => 'failed'));
            }
        }
    }

//    function cart_table($cart_content) {
//        $content = '';
//        foreach ($cart_content as $cart_item) {
//            $prod_details = ProductVendor::findOne($cart_item->product_id);
//            $product = Products::findOne($prod_details->product_id);
//            if ($prod_details->offer_price == '0' || $prod_details->offer_price == '') {
//                $price = $prod_details->price;
//            } else {
//                $price = $prod_details->offer_price;
//            }
//            $total = $price * $cart_item->quantity;
//            $content .= '<tr class="cart_item tr_' . $cart_item->id . '">
//
//                       <td class="product-item" data-title="Product">
//                       <a href="#"><img  height="60" src="' . Yii::$app->homeUrl . '/uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '_thumb.' . $product->gallery_images . '" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="product-women-01" srcset="" sizes="(max-width: 180px) 100vw, 180px"></a><a class="product-discrp" href="">' . $product->product_name . '</a></td>
//                       <td class="product-price" data-title="Price">
//                         <span class="woocommerce-Price-amount amount">' . sprintf("%0.2f", $price) . '<span class="woocommerce-Price-currencySymbol"> AED</span></span>
//                       </td>
//
//                       <td class="product-quantity" data-title="Quantity">
//                        <div class="quantity">
//                        <input type="number" step="1" min="1" max="' . $prod_details->qty . '" name="" value="' . $cart_item->quantity . '" title="Qty" class="input-text qty text cart_qty" id="' . yii::$app->EncryptDecrypt->Encrypt('encrypt', $cart_item->id) . '" size="4" pattern="[0-9]*" inputmode="numeric">
//                        </div>
//                       </td>
//                       <td class="product-subtotal" data-title="Total">
//                       <span class="woocommerce-Price-amount amount total_' . yii::$app->EncryptDecrypt->Encrypt('encrypt', $cart_item->id) . '">' . sprintf("%0.2f", $total) . '<span class="woocommerce-Price-currencySymbol"> AED</span></span></td>
//
//                       <td class="product-remove">
//
//                <a  class="remove remove_cart" title="Remove this item" data-product_id="' . $cart_item->id . '" data-product_sku=""><i class="fa fa-trash-o"></i></a>
//                <span class="error_' . $cart_item->id . '" style="color:red"></span>
//                       </td>
//
//                    </tr>';
//        }
//        return $content;
//    }
//    function usercheck() {
//        if (isset(Yii::$app->user->identity->id)) {
//            $user_id = Yii::$app->user->identity->id;
//            $condition = ['user_id' => $user_id];
//        } else {
//            if (!isset(Yii::$app->session['temp_user'])) {
//                $milliseconds = round(microtime(true) * 1000);
//                Yii::$app->session['temp_user'] = $milliseconds;
//            }
//            $sessonid = Yii::$app->session['temp_user'];
//            $condition = ['session_id' => $sessonid];
//        }
//        return $condition;
//    }
//    function changecart($tempuser) {
//        if (isset($tempuser)) {
//            $models = Cart::find()->where(['session_id' => Yii::$app->session['temp_user']])->all();
//            foreach ($models as $msd) {
//                $product_allready = Cart::find()->where(['user_id' => Yii::$app->user->identity->id, 'product_id' => $msd->product_id])
//                        ->andWhere(['<>', 'session_id', Yii::$app->session['temp_user']])
//                        ->orWhere(['session_id' => 'NULL'])
//                        ->one();
//
//                if ($product_allready) {
//                    $product_allready->quantity = $product_allready->quantity + $msd->quantity;
//                    $product_allready->save();
//                    $msd->delete();
//                    unset($product_allready);
//                } else {
//                    $msd->user_id = Yii::$app->user->identity->id;
//                    $msd->save();
//                }
//            }
//            unset(Yii::$app->session['temp_user']);
//        }
//    }
//    function clearcart($models) {
//        foreach ($models as $model) {
//            $model->delete();
//        }
//    }

    function cart_content() {
        $condition = Cart::usercheck();
        $cart_contents = Cart::find()->where($condition)->all();
        if (!empty($cart_contents)) {
            foreach ($cart_contents as $cart_content) {
                $prod_details = ProductVendor::findOne($cart_content->product_id);
                $product = Products::findOne($prod_details->product_id);
                if ($prod_details->offer_price == '0' || $prod_details->offer_price == '') {
                    $price = $prod_details->price;
                } else {
                    $price = $prod_details->offer_price;
                }
                $product_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '_thumb.' . $product->gallery_images;
                if (file_exists($product_image)) {
                    $image = '<img src="' . Yii::$app->homeUrl . '/uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product->id) . '/' . $product->id . '/profile/' . $product->canonical_name . '_thumb.' . $product->gallery_images . '" alt="item1" />';
                }
                $product_name = $product->product_name;
                if (strlen($product_name) > 25) {
                    $str = substr($product_name, 0, 25) . '...';
                } else {
                    $str = $product_name;
                }
                echo '<li class="clearfix">
    ' . $image . '
    <span class="item-name" title="' . $product_name . '">' . $str . '</span>
    <span class="item-price">' . sprintf("%0.2f", $price) . '</span>
    <span class="item-quantity">Quantity: ' . $cart_content->quantity . '</span>
</li>';
            }
        } else {
            echo '<div style="padding: 25px 0px; display: flow-root;">
    <a href="' . yii::$app->homeUrl . '"><div class="col-md-12 empty-img text-center" >
            <img style="margin: 0 auto; float: none; left: 0px; right: 0px; vertical-align: middle; margin-bottom: 10px;" class="img-responsive" src="' . Yii::$app->homeUrl . 'images/empty-cart.jpg"/>
        </div>
        <span class="col-md-12 text-center">Cart is Empty. Start Shopping.</span></a>
</div>';
        }
    }

    function date() {
        $date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' - 8 days'));
        return $date;
    }

    public function actionRemoveWishlist() {
        if (yii::$app->request->isAjax) {
            $id = Yii::$app->request->post()['wish_list_id'];
            $model = \common\models\WishList::findOne($id);
            $model->delete();
            echo 1;
            exit;
        }
    }

    /*
     * Add promotion code
     */

    public function actionPromotionCheck() {
        if (Yii::$app->request->isAjax) {
            if (isset(Yii::$app->user->identity->id)) {

                $code = $_POST['code'];
                $promotion_total_amount = $_POST['promotion_amount'];
                $code_exists = \common\models\Promotions::find()->where(['promotion_code' => $code])->one();

                $cart_products = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
                $cart_amount = Cart::total($cart_products);
                if (!empty($code_exists)) {
                    $used_code = Cart::UsedCode($_POST['code']);
                    if ($used_code == 0) {
                        $date_check = Cart::CheckDate($code_exists);
                        if ($date_check == 1) {
                            $used = Cart::CodeUsed($code_exists);
                            if ($used == 0) {
                                $exist = Cart::PromotionProduct($code_exists, $code);
                                if ($exist == 1) {
                                    $amount_range = Cart::AmountRange($code_exists, $cart_amount);
                                    if ($amount_range == 0) {
                                        if ($code_exists->type == 1) {
                                            $promotion_discount = ($cart_amount * $code_exists->price) / 100;
                                        } else {
                                            $promotion_discount = $code_exists->price;
                                        }
                                        $promotion_total_amount = $promotion_total_amount + $promotion_discount;
                                        $grand_total = Cart::net_amount($cart_amount, $cart_products);
                                        $overall_grand_total = $grand_total - $promotion_total_amount;
                                        $temp_promotion = Cart::SaveTemp(3, $code_exists->id);
                                        $arr_variable = array('msg' => '7', 'discount_id' => $code_exists->id, 'code' => $code, 'amount' => sprintf("%0.2f", $promotion_discount), 'total_promotion_amount' => sprintf("%0.2f", $promotion_total_amount), 'overall_grand_total' => sprintf("%0.2f", $overall_grand_total), 'temp_session' => $temp_promotion->id);
                                    } else {
                                        $arr_variable = array('msg' => '5', 'amount' => $code_exists->amount_range);
                                    }
                                } else {
                                    $arr_variable = array('msg' => '4');
                                }
                            } else {
                                $arr_variable = array('msg' => '3');
                            }
                        } else {
                            $arr_variable = array('msg' => '2');
                        }
                    } else {
                        $arr_variable = array('msg' => '8');
                    }
                } else {
                    $arr_variable = array('msg' => '1');
                }
            } else {
                $arr_variable = array('msg' => '6');
            }
            $data['result'] = $arr_variable;
            echo json_encode($data);
        }
    }

    /*
     * Check code is used in this purchase
     */

//    public function UsedCode($code) {
//        $existss = 0;
//        $code_details = \common\models\Promotions::find()->where(['promotion_code' => $code])->one();
//        $temp_session = \common\models\TempSession::find()->where(['value' => $code_details->id])->exists();
//        if ($temp_session) {
//            $existss = 1;
//        }
//        return $existss;
//    }

    /*
     * check the promotion code validity
     */

//    public function CheckDate($code_exists) {
//        $date_from_user = date('Y-m-d');
//        $start_ts = strtotime($code_exists->starting_date);
//        $end_ts = strtotime($code_exists->expiry_date);
//        $user_ts = strtotime($date_from_user);
//        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
//    }

    /*
     * check the purchased product or user is in this promotion code
     */

//    public function PromotionProduct($code_exists, $code) {
//        $products = explode(',', $code_exists->product_id);
//        $users = explode(',', $code_exists->user_id);
//        $oreder_setails = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
//        $exist = 0;
//        if ($code_exists->promotion_type == 1 || $code_exists->promotion_type == 3) {
//            foreach ($oreder_setails as $value) {
//                if (in_array($value->product_id, $products)) {
//                    $exist = 1;
//                }
//            }
//        }
//        if ($code_exists->promotion_type == 2 || $code_exists->promotion_type == 3) {
//            if (in_array(Yii::$app->user->identity->id, $users))
//                $exist = 1;
//        }
//        return $exist;
//    }

    /*
     * add this user used this code
     */

//    public function AddUsed($code_exists) {
//
//        $code_exists->code_used = $code_exists->code_used . ',' . Yii::$app->user->identity->id;
//        $code_exists->save();
//    }

    /*
     * check the promotion code is already used or not
     */

//    public function CodeUsed($code_exists) {
//        $code_used_list = explode(',', $code_exists->code_used);
//        if (($code_exists->code_usage == 1)) {
//            if (!in_array(Yii::$app->user->identity->id, $code_used_list)) {
//                $permision = 0;
//            } else {
//                $permision = 1;
//            }
//        } else {
//            $permision = 0;
//        }
//
//        return $permision;
//    }

    /*
     * check the promotion code amount range
     */

//    public function AmountRange($code_exists, $cart_amount) {
//        $amount_range = 0;
//        if (isset($code_exists->amount_range) && $code_exists->amount_range != '') {
//            if ($cart_amount > $code_exists->amount_range)
//                $amount_range = 0;
//            else
//                $amount_range = 1;
//        }
//        return $amount_range;
//    }

    /*
     * Save promotion in temporary table
     */

//    public function SaveTemp($type_id, $value) {
//
//        $temp_promotion = new \common\models\TempSession;
//        $temp_promotion->user_id = Yii::$app->user->identity->id;
//        $temp_promotion->type_id = $type_id;
//        $temp_promotion->value = $value;
//        $temp_promotion->save();
//        return $temp_promotion;
//    }

    /*
     * Promotion amount cahnge when quanity change
     */

    public function actionPromotionQuantityChange() {
        if (Yii::$app->request->isAjax) {
            $promo_codes = $_POST['promo_codes'];
            $cart_products = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
            $cart_amount = Cart::total($cart_products);
            $codes = explode(',', $promo_codes);
            $applied_codes = array();
            $promocodes = '';
            $promotion_total_discount = 0;
            \common\models\TempSession::deleteAll(['user_id' => Yii::$app->user->identity->id]);
            $c = 0;
            foreach ($codes as $codes) {
                if (isset($codes) && $codes != '') {
                    $c++;
                    $code_exists = \common\models\Promotions::findOne($codes);
                    $amount_range = Cart::AmountRange($code_exists, $cart_amount);
                    if ($amount_range == 0) {
                        if ($c != 1) {
                            $promocodes .= ',';
                        }
                        $promocodes .= $codes;
                        if ($code_exists->type == 1) {
                            $promotion_discount = ($cart_amount * $code_exists->price) / 100;
                        } else {
                            $promotion_discount = $code_exists->price;
                        }
                        $promotion_total_discount += $promotion_discount;
                        $temp_promotion = Cart::SaveTemp(3, $codes);
                        $applied_codes[] = ['discount_id' => $codes, 'code' => $code_exists->promotion_code, 'amount' => sprintf("%0.2f", $promotion_discount), 'temp_session' => $temp_promotion->id];
                    }
                }
            }

            $grand_total = Cart::net_amount($cart_amount, $cart_products);
            $overall_grand_total = $grand_total - $promotion_total_discount;
            $data = array('promotion' => $applied_codes, 'code' => $promocodes, 'total_promotion_amount' => sprintf("%0.2f", $promotion_discount), 'overall_grand_total' => sprintf("%0.2f", $overall_grand_total), 'promotion_total_discount' => sprintf("%0.2f", $promotion_total_discount));
            echo json_encode($data);
        }
    }

    /*
     * Remove Coupon code
     */

    public function actionPromotionRemove() {
        if (Yii::$app->request->isAjax) {
            $remov_id = $_POST['id'];
            $promo_codes = $_POST['promo_codes'];
            $temp_id = $_POST['temp_id'];

            $codes = explode(',', $promo_codes);
            $cart_products = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
            $cart_amount = Cart::total($cart_products);
            $promocodes = '';
            $promotion_total_discount = 0;
            foreach ($codes as $codes) {

                $code_exists = \common\models\Promotions::findOne($codes);
                if (isset($codes) && $codes != '') {
                    if ($remov_id != $codes) {
                        if ($code_exists->type == 1) {
                            $promotion_discount = ($cart_amount * $code_exists->price) / 100;
                        } else {
                            $promotion_discount = $code_exists->price;
                        }
                        $promotion_total_discount += $promotion_discount;
                        $promocodes .= $codes . ',';
                    }
                }
            }
            $temp_session = \common\models\TempSession::findOne($temp_id);
            $temp_session->delete();
            $grand_total = Cart::net_amount($cart_amount, $cart_products);
            $overall_grand_total = $grand_total - $promotion_total_discount;

            $data = array('code' => $promocodes, 'total_promotion_amount' => sprintf("%0.2f", $promotion_discount), 'overall_grand_total' => sprintf("%0.2f", $overall_grand_total));
            echo json_encode($data);
        }
    }

    public function actionStreet() {
        if (yii::$app->request->isAjax) {
            $city = Yii::$app->request->post()['city'];
            $streets = \common\models\Street::find()->where(['city_id' => $city, 'status' => '1'])->all();
            $field = '<option value="">Select</option>';
            foreach ($streets as $street) {
                $field .= '<option value="' . $street->id . '">' . $street->street_name . '</option>';
            }
            echo json_encode(array('msg' => 'success', 'field' => $field));
            exit;
        }
    }

}
