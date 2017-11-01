<?php

namespace frontend\controllers;

use yii;
use common\models\Products;
use common\models\Cart;
use common\models\User;
use common\models\ProductVendor;

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
            $id = ProductVendor::findOne(yii::$app->EncryptDecrypt->Encrypt('decrypt', $vendor_prdct));
            $id = products::findOne(['canonical_name' => $canonical_name])->id;
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
                $user_id='';
            }
            $cart = Cart::find()->where(['product_id' => $id])->andWhere($condition)->one();
            if (!empty($cart)) {
                $cart->quantity = ($cart->quantity) + $qty;
//                $cart->quantity = $quantity > $stock ? $stock : $quantity;
//            $cart->quantity = $qty;
                $cart->save();
//                $this->cart_content($condition);
            } else {
                $model = new cart;
                $model->user_id = $user_id;
                $model->session_id = Yii::$app->session['temp_user'];
                $model->product_id = $id;
                $model->quantity = $qty;
                date_default_timezone_set('Asia/Kolkata');
                $model->date = date('Y-m-d H:i:s');
                if ($model->save()) {
//                    $this->cart_content($condition);
                }
            }
        }
    }

    public function actionGetcartcount() {
        if (yii::$app->request->isAjax) {

//            $date = $this->date();
//            Cart::deleteAll('date <= :date', ['date' => $date]);
            if (isset(Yii::$app->user->identity->id)) {
                if (isset(Yii::$app->session['temp_user'])) {
                    /*                     * *******Change tempuser cart to login user********* */
                    $this->changecart(Yii::$app->session['temp_user']);
//
                }
                $condition = ['user_id' => Yii::$app->user->identity->id];
            } else {
                if (isset(Yii::$app->session['temp_user'])) {
                    $condition = ['session_id' => Yii::$app->session['temp_user']];
                } else {
                    echo '0';
                    exit;
                }
            }
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
            if (isset(Yii::$app->user->identity->id)) {
                $cart_items = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
                if (!empty($cart_items)) {
                    echo sprintf('%0.2f', $this->total($cart_items));
                } else {
                    echo '0';
                }
            } else {
                if (isset(Yii::$app->session['temp_user'])) {
                    $cart_items = Cart::find()->where(['session_id' => Yii::$app->session['temp_user']])->all();

                    if (!empty($cart_items)) {
                        echo sprintf('%0.2f', $this->total($cart_items));
                    } else {
                        echo '0';
                    }
                } else {
                    echo '0';
                }
            }
        }
    }

   
    function cart_content($cart_contents) {
        if (!empty($cart_contents)) {
            foreach ($cart_contents as $cart_content) {
                    $prod_details = Product::findOne($cart_content->product_id);
                    if ($prod_details->offer_price == '0' || $prod_details->offer_price == '') {
                        $price = $prod_details->price;
                    } else {
                        $price = $prod_details->offer_price;
                    }
                    $product_image = Yii::$app->basePath . '/../uploads/product/' . $prod_details->id . '/profile/' . $prod_details->canonical_name . '.' . $prod_details->profile;
                    if (file_exists($product_image)) {
                        $image = '<img src="' . Yii::$app->homeUrl . 'uploads/product/' . $prod_details->id . '/profile/' . $prod_details->canonical_name . '_thumb.' . $prod_details->profile . '" alt="item1" />';
                    } else {
                        $image = '<img src="' . Yii::$app->homeUrl . 'uploads/product/profile_thumb.png" alt=""/>';
                    }
                $product_name = $cart_content->item_type == 1 ? 'Custom Perfume' : $prod_details->product_name;
                if (strlen($product_name) > 25) {
                    $str = substr($product_name, 0, 25) . '...';
                } else {
                    $str = $product_name;
                }
                echo '<li class="clearfix">
                       ' . $image . '
                       <span class="item-name" title="' . $product_name . '">' . $str . '</span>
                       <span class="item-price">' . $price . '</span>
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

    public function total($cart) {
        $subtotal = '0';
        foreach ($cart as $cart_item) {
            if ($cart_item->item_type == 1) {
                $subtotal += ($cart_item->rate * $cart_item->quantity);
            } else {
                $product = Product::findOne($cart_item->product_id);
                if ($product->offer_price == '0' || $product->offer_price == '') {
                    $price = $product->price;
                } else {
                    $price = $product->offer_price;
                }
                $subtotal += ($price * $cart_item->quantity);
            }
        }
        return $subtotal;
    }

    function net_amount($total_amt) {
        $limit = Settings::findOne(1)->value;
        $net_amnt = $total_amt;
        if ($limit > $total_amt) {
            $extra = Settings::findOne(2)->value;
            $net_amnt = $extra + $total_amt;
        }
        return $net_amnt;
    }

    public function generateProductEan($serial_no) {
        $orderid_exist = OrderMaster::find()->where(['order_id' => $serial_no])->one();
        if (!empty($orderid_exist)) {
            return $this->generateProductEan($serial_no + 1);
        } else {
            return $serial_no;
        }
    }

    public function Updateorderid($id) {
        $orderid = \common\models\Settings::findOne(4);
        $orderid->value = $id;
        $orderid->save();
        return;
    }

    function changecart($temp) {
        $models = Cart::find()->where(['session_id' => Yii::$app->session['temp_user']])->all();
        foreach ($models as $msd) {
            $msd->user_id = Yii::$app->user->identity->id;
            $msd->save();
        }
    }

    function addtocart() {
        $datas = \common\models\CreateYourOwn::find()->where(['session_id' => Yii::$app->session['temp_create_yourown'], 'status' => 0])->orWhere(['user_id' => Yii::$app->user->identity->id, 'status' => 0])->all();
        if (!empty($datas)) {
            foreach ($datas as $msd) {
                $model = new Cart();
                $model->user_id = Yii::$app->user->identity->id;
                $model->product_id = $msd->id;
                $model->quantity = 1;
                $model->date = date('Y-m-d h:m:s');
                $model->rate = $msd->tot_amount;
                $model->item_type = 1;
                if ($model->save()) {
                    $msd->session_id = '';
                    $msd->user_id = Yii::$app->user->identity->id;
                    $msd->status = 1;
                    $msd->save();
                }
            }
        }
        return;
    }

    function clearcart($models) {
        foreach ($models as $model) {
            $model->delete();
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
