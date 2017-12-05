<?php

namespace common\models;

use Yii;
use common\models\Products;
use common\models\User;
use common\models\ProductVendor;
use common\models\UserAddress;
use common\models\OrderMaster;
use common\models\OrderDetails;
use common\models\Settings;
use common\models\StockHistory;

/**
 * This is the model class for table "cart".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $session_id
 * @property integer $product_id
 * @property integer $quantity
 * @property integer $options
 * @property string $date
 * @property integer $gift_option
 * @property double $rate
 */
class Cart extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cart';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
//            [['user_id', 'product_id', 'quantity', 'options', 'date', 'gift_option', 'rate'], 'required'],
//            [['user_id', 'product_id', 'quantity', 'options', 'gift_option'], 'integer'],
//            [['date'], 'safe'],
//            [['rate'], 'number'],
//            [['session_id'], 'string', 'max' => 225],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'session_id' => 'Session ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
            'options' => 'Options',
            'date' => 'Date',
            'gift_option' => 'Gift Option',
            'rate' => 'Rate',
            'item_type' => 'Item Type',
        ];
    }

    public function add_to_cart($user_id, $temp_session, $product_id, $qty) {
        $model = new cart;
        $model->user_id = $user_id;
        $model->session_id = $temp_session;
        $model->product_id = $product_id;
        $model->quantity = $qty;
        $model->date = date('Y-m-d H:i:s');
        if ($model->save()) {
            return TRUE;
        }
    }

    public function shipping_charge($cart) {
        $shipping_charge = '0';
        foreach ($cart as $cart_item) {
            $product = ProductVendor::find()->where(['id' => $cart_item->product_id])->andWhere(['<>', 'free_shipping', '1'])->one();
            if ($product) {
                $shipping_charge = Settings::findOne(3)->value;
                return $shipping_charge;
            }
        }
        return $shipping_charge;
    }

    public function usercheck() {
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

    public function cart_content() {
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

    public function changecart($tempuser) {
        if (isset($tempuser)) {
            $models = Cart::find()->where(['session_id' => Yii::$app->session['temp_user']])->all();
            foreach ($models as $msd) {
                $product_allready = Cart::find()->where(['user_id' => Yii::$app->user->identity->id, 'product_id' => $msd->product_id])
                        ->andWhere(['<>', 'session_id', Yii::$app->session['temp_user']])
                        ->orWhere(['session_id' => 'NULL'])
                        ->one();

                if ($product_allready) {
                    $product_allready->quantity = $product_allready->quantity + $msd->quantity;
                    $product_allready->save();
                    $msd->delete();
                    unset($product_allready);
                } else {
                    $msd->user_id = Yii::$app->user->identity->id;
                    $msd->save();
                }
            }
            unset(Yii::$app->session['temp_user']);
        }
    }

    public function CheckTempsession($post) {
        $check = 0;
        $temp = \common\models\TempSession::find()->where(['user_id' => Yii::$app->user->identity->id, 'type_id' => 3])->select('value')->all();
        $temp_coupons = '';
        $t = 0;
        foreach ($temp as $value) {
            $t++;
            if ($t != 1) {
                $temp_coupons .= ',';
            }
            $temp_coupons .= $value->value;
        }
        $coupons = $post['promotion_codes'];
        if ($coupons != $temp_coupons) {
            $check = 1;
        }
        $ship_address = \common\models\TempSession::find()->where(['user_id' => Yii::$app->user->identity->id, 'type_id' => 1])->one();
        $bill_address = \common\models\TempSession::find()->where(['user_id' => Yii::$app->user->identity->id, 'type_id' => 2])->one();
        if ($post['OrderMaster']['ship_address_id'] != $ship_address->value) {
            $check = 1;
        } if ($post['OrderMaster']['bill_address_id'] != $bill_address->value) {
            $check = 1;
        }
        return $check;
    }

    public function Checkout($ship_address, $bill_address) {
        if (isset(Yii::$app->user->identity->id)) {
            Cart::check_product();
            $cart = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
            $orders = Cart::addOrder($cart, $ship_address, $bill_address);
            if (Cart::orderProducts($orders, $cart)) {
                Cart::Addpromotions($orders);
                Cart::clearcart($cart);
                Cart::stock_clear($orders);
                $this->redirect(['checkout/payment', 'id' => $orders['order_id']]);
            } else {
                $this->redirect('mycart');
            }
        } else {
            $this->redirect(array('site/login'));
        }
    }

    public function total($cart) {
        $subtotal = '0';
        foreach ($cart as $cart_item) {
            $product = ProductVendor::find()->where(['id' => $cart_item->product_id, 'vendor_status' => '1'])->one();
//            $product = ProductVendor::findOne($cart_item->product_id);
            if ($product->offer_price == '0' || $product->offer_price == '') {
                $price = $product->price;
            } else {
                $price = $product->offer_price;
            }
            $subtotal += ($price * $cart_item->quantity);
        }
        return $subtotal;
    }

    public function net_amount($subtotal, $cart) {
        $grandtotal = $subtotal > '0' ? $subtotal : '0';
        if ($grandtotal > 0) {
            $shippinng_limit = Settings::findOne(2)->value;
            if ($shippinng_limit > $subtotal) {
                $shipping_charge = Cart::shipping_charge($cart);
//                $extra = Settings::findOne(3)->value;
                $grandtotal = $shipping_charge + $subtotal;
            }
        }

        return $grandtotal;
    }

    public function check_product() {
        $cart_items = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        foreach ($cart_items as $cart) {
            $check_product_vendor = ProductVendor::find()->where(['id' => $cart->product_id, 'vendor_status' => '1'])->one();
            $check_product = Products::find()->where(['id' => $check_product_vendor->product_id, 'status' => '1'])->one();
            if (empty($check_product) || empty($check_product_vendor)) {
                $cart->delete();
//                $this->redirect('mycart');
            }
        }
    }

    public function addOrder($cart, $ship_address, $bill_address) {
        $serial_no = Settings::findOne(1)->value;
        $prefix = Settings::findOne(1)->prefix;
        $model = new OrderMaster;
        $model->order_id = Cart::generateProductEan($prefix, $serial_no);
        $model->user_id = Yii::$app->user->identity->id;
        $model->total_amount = Cart::total($cart);
        $model->net_amount = Cart::net_amount($model->total_amount, $cart);
        $model->order_date = date('Y-m-d H:i:s');
        $model->DOC = date('Y-m-d');
        $model->ship_address_id = $ship_address;
        $model->bill_address_id = $bill_address;
        $model->status = '1';
        if ($model->save()) {
            return ['master_id' => $model->id, 'order_id' => $model->order_id];
        }
    }

    public function orderProducts($orders, $carts) {
        foreach ($carts as $cart) {
            $prod_details = ProductVendor::findOne($cart->product_id);

            $model_prod = new OrderDetails;
            $model_prod->master_id = $orders['master_id'];
            $model_prod->order_id = $orders['order_id'];
            $model_prod->user_id = Yii::$app->user->identity->id;
            $model_prod->product_id = $cart->product_id;
            $model_prod->vendor_id = $prod_details->vendor_id;
            $model_prod->quantity = $cart->quantity;
            if ($prod_details->offer_price == '0' || $prod_details->offer_price == '') {
                $price = $prod_details->price;
            } else {
                $price = $prod_details->offer_price;
            }
            $model_prod->amount = $price;
            $model_prod->sub_total = ($cart->quantity) * ($price);
            $model_prod->status = '0';
            $model_prod->DOC = date('Y-m-d');
            if ($model_prod->save()) {
                Cart::commissionManagement($model_prod, $prod_details);
            }
        }
        return TRUE;
    }

    public function commissionManagement($order_details, $prod_details) {
        $model_commission = new CommissionManagement();
        $model_commission->product_id = $prod_details->id;
        $model_commission->vendor_id = $prod_details->vendor_id;
        $model_commission->order_id = $order_details->order_id;
        $model_commission->product_price = $order_details->amount;
        if ($prod_details->offer_price != '0' || $prod_details->offer_price != '') {
            $model_commission->offer_price = $prod_details->offer_price;
        }
        $product = Products::findOne($prod_details->product_id);
        if ($product->commisson != '0' || $product->commisson != '') {
            $model_commission->commission = ($product->commisson / 100) * $order_details->amount;
        }
        $model_commission->DOC = date('Y-m-d');
        $model_commission->save();
        return TRUE;
    }

    public function Addpromotions($orders) {

        $coupons = \common\models\TempSession::find()->where(['user_id' => Yii::$app->user->identity->id, 'type_id' => 3])->all();
        $cart_products = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        $cart_amount = Cart::total($cart_products);
        foreach ($coupons as $coupons) {
            $add_promption = new \common\models\OrderPromotions();
            $add_promption->order_master_id = $orders['master_id'];
            $add_promption->promotion_id = $coupons->value;
            $promotion = \common\models\Promotions::findOne($coupons->value);
            if ($promotion->type == 1) {
                $promotion_discount = ($cart_amount * $promotion->price) / 100;
            } else {
                $promotion_discount = $promotion->price;
            }
            $add_promption->promotion_discount = $promotion_discount;
            $add_promption->save();
            if ($promotion->code_usage == 1) {
                Cart::AddUsed($promotion);
            }
        }
    }

    public function AddUsed($code_exists) {

        $code_exists->code_used = $code_exists->code_used . ',' . Yii::$app->user->identity->id;
        $code_exists->save();
    }

    public function clearcart($models) {
        foreach ($models as $model) {
            $model->delete();
        }
    }

    public function stock_clear($orders) {
        $order_details = OrderDetails::find()->where(['order_id' => $orders['order_id']])->all();
        foreach ($order_details as $order) {
            $product = ProductVendor::findOne($order->product_id);
            $old_qty = $product->qty;
            $product->qty = $product->qty - $order->quantity;
            $product->save();
            StockHistory::stockhistory($product->qty, '3', $product->id, '3', $old_qty);
        }
    }

    public function SaveTemp($type_id, $value) {

        $temp_promotion = new \common\models\TempSession;
        $temp_promotion->user_id = Yii::$app->user->identity->id;
        $temp_promotion->type_id = $type_id;
        $temp_promotion->value = $value;
        $temp_promotion->save();
        return $temp_promotion;
    }

    public function adduseraddress() {
        $model = new UserAddress();
        $model->user_id = Yii::$app->user->identity->id;
        $model->first_name = Yii::$app->request->post()['UserAddress']['first_name'];
        $model->last_name = Yii::$app->request->post()['UserAddress']['last_name'];
        $model->address = Yii::$app->request->post()['UserAddress']['address'];
        $model->city_id = Yii::$app->request->post()['UserAddress']['city_id'];
        $model->landmark = Yii::$app->request->post()['UserAddress']['landmark'];
        $model->country_id = Yii::$app->request->post()['UserAddress']['country_id'];
        $model->street_id = Yii::$app->request->post()['UserAddress']['street_id'];
        $model->phone = Yii::$app->request->post()['UserAddress']['phone'];
        $model->pincode = Yii::$app->request->post()['UserAddress']['pincode'];
        $model->address = Yii::$app->request->post()['UserAddress']['address'];
        if ($model->validate() && $model->save()) {
            return $model->id;
        }
    }

    public function generateProductEan($prefix, $serial_no) {
        $orderid_exist = OrderMaster::find()->where(['order_id' => $prefix . $serial_no])->one();
        if (!empty($orderid_exist)) {
            return Cart::generateProductEan($prefix, $serial_no + 1);
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

    public function AmountRange($code_exists, $cart_amount) {
        $amount_range = 0;
        if (isset($code_exists->amount_range) && $code_exists->amount_range != '') {
            if ($cart_amount > $code_exists->amount_range)
                $amount_range = 0;
            else
                $amount_range = 1;
        }
        return $amount_range;
    }

    public function PromotionProduct($code_exists, $code) {
        $products = explode(',', $code_exists->product_id);
        $users = explode(',', $code_exists->user_id);
        $oreder_setails = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        $exist = 0;
        if ($code_exists->promotion_type == 1 || $code_exists->promotion_type == 3) {
            foreach ($oreder_setails as $value) {
                if (in_array($value->product_id, $products)) {
                    $exist = 1;
                }
            }
        }
        if ($code_exists->promotion_type == 2 || $code_exists->promotion_type == 3) {
            if (in_array(Yii::$app->user->identity->id, $users))
                $exist = 1;
        }
        return $exist;
    }

    public function CodeUsed($code_exists) {
        $code_used_list = explode(',', $code_exists->code_used);
        if (($code_exists->code_usage == 1)) {
            if (!in_array(Yii::$app->user->identity->id, $code_used_list)) {
                $permision = 0;
            } else {
                $permision = 1;
            }
        } else {
            $permision = 0;
        }

        return $permision;
    }

    public function CheckDate($code_exists) {
        $date_from_user = date('Y-m-d');
        $start_ts = strtotime($code_exists->starting_date);
        $end_ts = strtotime($code_exists->expiry_date);
        $user_ts = strtotime($date_from_user);
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }

    public function UsedCode($code) {
        $existss = 0;
        $code_details = \common\models\Promotions::find()->where(['promotion_code' => $code])->one();
        $temp_session = \common\models\TempSession::find()->where(['value' => $code_details->id])->exists();
        if ($temp_session) {
            $existss = 1;
        }
        return $existss;
    }

}
