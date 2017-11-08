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
//            $id = products::findOne(['canonical_name' => $prdct_vendor->product_id])->id;
            $condition = $this->usercheck();
            $user_id = isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : '';


            $cart = Cart::find()->where(['product_id' => $prdct_vendor->id])->andWhere($condition)->one();
            if (!empty($cart)) {
                $quantity = ($cart->quantity) + $qty;
                $cart->quantity = $quantity > $prdct_vendor->qty ? $prdct_vendor->qty : $quantity;
//            $cart->quantity = $qty;
                $cart->save();
                $this->cart_content();
            } else {
                $model = new cart;
                $model->user_id = $user_id;
                $model->session_id = Yii::$app->session['temp_user'];
                $model->product_id = $prdct_vendor->id;
                $model->quantity = $qty;
                $model->date = date('Y-m-d H:i:s');
                if ($model->save()) {
                    $this->cart_content();
                }
            }
        }
    }

    public function actionMycart() {
        if (isset(Yii::$app->user->identity->id)) {
            if (isset(Yii::$app->session['temp_user'])) {
                $this->changecart(Yii::$app->session['temp_user']);
            }
        }
        $model = new UserAddress();
//        if ($model->load(Yii::$app->request->post())) {
//            if (!isset(Yii::$app->request->post()['UserAddress']['billing'])) {
//                $address_id = $this->addnewuser($model);
//            } else {
//                $address_id = Yii::$app->request->post()['UserAddress']['billing'];
//            }
//            $cart = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
//            $orders = $this->addOrder($cart, $address_id);
//            $this->orderProducts($orders, $cart);
////            $this->clearcart($cart);
//            return $this->redirect('mycart');
//        }
//        $address = UserAddress::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        $condition = $this->usercheck();
        $cart_items = Cart::find()->where($condition)->all();
        if (!empty($cart_items)) {
            $subtotal = $this->total($cart_items);
            return $this->render('cart', ['cart_items' => $cart_items, 'subtotal' => $subtotal, 'model' => $model]);
        } else {
            return $this->render('emptycart');
        }
    }

    public function actionAddAddress() {
        if (yii::$app->request->isAjax) {
            $model = new UserAddress();
            $model->user_id = Yii::$app->user->identity->id;
            $model->first_name = Yii::$app->request->post()['first_name'];
            $model->last_name = Yii::$app->request->post()['last_name'];
            $model->address = Yii::$app->request->post()['address'];
            $model->city_id = Yii::$app->request->post()['city_id'];
            $model->landmark = Yii::$app->request->post()['landmark'];
            $model->country_id = Yii::$app->request->post()['country_id'];
            $model->street_id = Yii::$app->request->post()['street_id'];
            $model->phone = Yii::$app->request->post()['phone'];
            $model->pincode = Yii::$app->request->post()['pincode'];
            $model->address = Yii::$app->request->post()['address'];
            if($model->save()){
                echo json_encode(array('msg' => 'success', 'id' => $model->id));exit;
            }
        }
    }

    public function orderProducts($orders, $carts) {
        foreach ($carts as $cart) {
            $prod_details = ProductVendor::findOne($cart->product_id);

            $model_prod = new OrderDetails;
            $model_prod->master_id = $orders['master_id'];
            $model_prod->order_id = $orders['order_id'];
            $model_prod->product_id = $cart->product_id;
            $model_prod->quantity = $cart->quantity;
            if ($prod_details->offer_price == '0' || $prod_details->offer_price == '') {
                $price = $prod_details->price;
            } else {
                $price = $prod_details->offer_price;
            }
            $model_prod->amount = $price;
            $model_prod->sub_total = ($cart->quantity) * ($price);
            $model_prod->status = '0';
            if ($model_prod->save()) {
//                    return TRUE;
            }
//                 else {
//                var_dump($model_prod->getErrors());
//                exit;
//            }
        }
    }

    function addOrder($cart, $address_id) {
        $serial_no = Settings::findOne(1)->value;
        $prefix = Settings::findOne(1)->prefix;
        $model = new OrderMaster;
        $model->order_id = $this->generateProductEan($prefix, $serial_no);
        $model->user_id = Yii::$app->user->identity->id;
        $model->total_amount = $this->total($cart);
        $model->net_amount = $this->net_amount($model->total_amount);
        $model->order_date = date('Y-m-d H:i:s');
        $model->DOC = date('Y-m-d');
        $model->ship_address_id = $address_id;
        if ($model->save()) {

            return ['master_id' => $model->id, 'order_id' => $model->order_id];
        }
    }

    public function generateProductEan($prefix, $serial_no) {
        $orderid_exist = OrderMaster::find()->where(['order_id' => $prefix . $serial_no])->one();
        if (!empty($orderid_exist)) {
            return $this->generateProductEan($prefix, $serial_no + 1);
        } else {
            $this->Updateorderid($serial_no);
            return $prefix . $serial_no;
        }
    }

    public function Updateorderid($id) {
        $orderid = Settings::findOne(1);
        $orderid->value = $id;
        $orderid->save();
        return;
    }

    function addnewuser($model) {
        $user_address = UserAddress::find()->where(['user_id' => Yii::$app->user->identity->id, 'default_address' => '1'])->one();
        Yii::$app->SetValues->Attributes($model);
        $model->user_id = Yii::$app->user->identity->id;
        $model->default_address = empty($user_address) ? '1' : '0';
        if ($model->save()) {
            return $model->id;
        }
    }

    public function actionCart_remove($id) {
        $cart = Cart::findone($id);
        if ($cart->delete()) {
            return $this->redirect('mycart');
        } else {
            return $this->redirect('mycart');
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
                $product = ProductVendor::findOne($cart->product_id);
                $quantity = $qty > $product->qty ? $product->qty : $qty;
                if ($product->offer_price == '0' || $product->offer_price == '') {
                    $price = $product->price;
                } else {
                    $price = $product->offer_price;
                }
                $total = $price * $quantity;
                echo json_encode(array('msg' => 'success', 'quantity' => $quantity, 'total' => sprintf('%0.2f', $total)));
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
                if ($qty == 0 || $qty == "") {
                    $qty = 1;
                }
                $cart->quantity = $qty > $product->qty ? $product->qty : $qty;
                if ($cart->save()) {
                    $condition = $this->usercheck();
                    $cart_items = Cart::find()->where($condition)->all();
                    if (!empty($cart_items)) {
                        $subtotal = $this->total($cart_items);
                        $grandtotal = $this->grandtotal($subtotal);
                    }
                    echo json_encode(array('msg' => 'success', 'subtotal' => sprintf('%0.2f', $subtotal), 'grandtotal' => sprintf('%0.2f', $grandtotal)));
                } else {
                    echo json_encode(array('msg' => 'error', 'content' => 'Cannot be Changed'));
                }
            }
//            else {
//                echo json_encode(array('msg' => 'error', 'content' => 'Id cannot be set'));
//            }
        }
    }

    public function actionGetcartcount() {
        if (yii::$app->request->isAjax) {
            $date = $this->date();
            Cart::deleteAll('date <= :date', ['date' => $date]);
            if (isset(Yii::$app->user->identity->id)) {
                if (isset(Yii::$app->session['temp_user'])) {
                    /*                     * *******Change tempuser cart to login user********* */
                    $this->changecart(Yii::$app->session['temp_user']);
//
                }
            }
            $condition = $this->usercheck();
            $cart_items = Cart::find()->where($condition)->all();
            if (!empty($cart_items)) {
                echo count($cart_items);
                exit;
            } else {
                echo "0";
                exit;
            }
        }
    }

    public function actionGetcarttotal() {
        if (yii::$app->request->isAjax) {
            $condition = $this->usercheck();
            $cart_items = Cart::find()->where($condition)->all();
            if (!empty($cart_items)) {
                echo sprintf('%0.2f', $this->total($cart_items));
            } else {
                echo '0';
            }
        }
    }

    public function actionSelectcart() {
        $this->cart_content();
    }

    public function total($cart) {
        $subtotal = '0';
        foreach ($cart as $cart_item) {
            $product = ProductVendor::findOne($cart_item->product_id);
            if ($product->offer_price == '0' || $product->offer_price == '') {
                $price = $product->price;
            } else {
                $price = $product->offer_price;
            }
            $subtotal += ($price * $cart_item->quantity);
        }
        return $subtotal;
    }

    function net_amount($total_amt) {
//        $limit = Settings::findOne(1)->value;
//        $net_amnt = $total_amt;
//        if ($limit > $total_amt) {
//            $extra = Settings::findOne(2)->value;
//            $net_amnt = $extra + $total_amt;
//        }
        return $total_amt;
    }

    function grandtotal($subtotal) {
        $grandtotal = $subtotal;
        return $grandtotal;
    }

    public function actionUseraddress() {
        if (yii::$app->request->isAjax) {
            if (isset(Yii::$app->user->identity->id)) {
                $addresses = UserAddress::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
                $addres_field .= "<option value=''>Select</option>";
                foreach ($addresses as $address) {
                    $addres_field .= "<option value = '$address->id'>$address->first_name, $address->address , $address->landmark</option>";
                }
                echo json_encode(array('msg' => 'success', 'addres_field' => $addres_field));
            } else {
                echo json_encode(array('msg' => 'failed'));
            }
        }
    }

    function usercheck() {
        if (isset(Yii::$app->user->identity->id)) {
            $user_id = Yii::$app->user->identity->id;
            $condition = ['user_id' => $user_id];
        } else {
            if (!isset(Yii::$app->session['temp_user'])) {
                $milliseconds = round(microtime(true) * 1000);
                Yii::$app->session['temp_user'] = $milliseconds;
            }
            $sessonid = Yii::$app->session['temp_user'];
            $condition = ['session_id' => $sessonid];
        }
        return $condition;
    }

    function changecart($tempuser) {
//        echo $tempuser;exit;
        if (isset($tempuser)) {
            $models = Cart::find()->where(['session_id' => Yii::$app->session['temp_user']])->all();
            foreach ($models as $msd) {
                $product_allready = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])
                                ->andWhere(['product_id' => $msd->product_id])
                                ->andWhere(['<>', 'session_id', Yii::$app->session['temp_user']])->one();
//                 $product_allready = Cart::find()->where(['user_id' => Yii::$app->user->identity->id, 'product_id' => $msd->product_id])->one();
                if ($product_allready) {
                    $product_allready->quantity = $product_allready->quantity + $msd->quantity;
                    $product_allready->save();
//                    echo 'aaa'.$msd->id;
                    $msd->delete();
                } else {
                    $msd->user_id = Yii::$app->user->identity->id;
                    $msd->save();
                }
            }
            Yii::$app->session['temp_user'] = '';
        }
    }

    function clearcart($models) {
        foreach ($models as $model) {
            $model->delete();
        }
    }

    function cart_content() {
        $condition = $this->usercheck();
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
//                $str= strlen($product_name) > 25 ?substr($product_name, 0, 25) . '...':'';
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
//                <button title="Remove From Cart" class="remove-cart"><i class="fa fa-times" aria-hidden="true"></i></button>
            }
        } else {
//            echo 'Cart box is Empty';
            echo '<div style="padding: 25px 0px; display: flow-root;">
    <a href="' . yii::$app->homeUrl . '"><div class="col-md-12 empty-img text-center" >
            <img style="margin: 0 auto; float: none; left: 0px; right: 0px; vertical-align: middle; margin-bottom: 10px;" class="img-responsive" src="' . Yii::$app->homeUrl . 'images/empty-cart.jpg"/>
        </div>
        <span class="col-md-12 text-center">Cart is Empty. Start Shopping.</span></a>
</div>';
//                   Html::a ('<button class="green2">Continue shopping</button>,'.['site/index'].','.['class' => 'button']).
//                </div>';
        }
    }

    function date() {
//        $date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
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

}
