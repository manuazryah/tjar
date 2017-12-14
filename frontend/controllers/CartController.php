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
			$condition = Cart::usercheck();
			$user_id = isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : '';
			$cart = Cart::find()->where(['product_id' => $prdct_vendor->id])->andWhere($condition)->one();
			if (!empty($cart)) {
				$quantity = ($cart->quantity) + $qty;
				$cart->quantity = $quantity > $prdct_vendor->qty ? $prdct_vendor->qty : $quantity;
				if ($cart->save()) {
					echo json_encode(array('msg' => 'success'));
					exit;
				}
			} else {
				if (Cart::add_to_cart($user_id, Yii::$app->session['temp_user'], $prdct_vendor->id, $qty)) {
					echo json_encode(array('msg' => 'success'));
					exit;
				}
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
			$payment_type = Yii::$app->request->post()['OrderMaster']['payment_type'];
			$ship_address = Yii::$app->request->post()['OrderMaster']['ship_address_id'];
			$bill_address = Yii::$app->request->post()['OrderMaster']['bill_address_id'];
			$check = Cart::CheckTempsession(Yii::$app->request->post());
			if ($check == 0)
				$order_id = Cart::checkout($ship_address, $bill_address, $payment_type);
			$total = Cart::total($cart_items);
			$net_amount = Cart::net_amount($total, $cart_items);

			if ($payment_type == 3) {

				$this->redirect(['myaccounts/wallet/money-from-wallet',
				    'net_amount' => $net_amount,
				    'ship_address' => $ship_address,
				    'bill_address' => $bill_address,
				    'order_id' => $order_id,
				]);
			} elseif ($payment_type == 2) {
				$this->redirect(['checkout/payment', 'id' => $order_id]);
			} elseif ($payment_type == 1) {
				$this->redirect(['checkout/payment', 'id' => $order_id]);
			}
		}
		if (!empty($cart_items)) {
			if (isset(Yii::$app->user->identity->id)) {
				\common\models\TempSession::deleteAll(['user_id' => Yii::$app->user->identity->id]);
			}
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
					Cart::check_cart($condition);
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
					$condition = Cart::usercheck();
					Cart::check_cart($condition);
//                    $this->check_cart($condition);
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
					/*					 * *******Change tempuser cart to login user********* */
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

	public function actionUseraddress() {
		if (yii::$app->request->isAjax) {
			$condition = Cart::usercheck();
			$cart_items = Cart::find()->where($condition)->all();
			if (count($cart_items) != Yii::$app->request->post()['count']) {
				$this->redirect(array('cart/mycart'));
			}
			if (isset(Yii::$app->user->identity->id)) {
				$addresses = UserAddress::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
				$addres_field = "<option value=''>Select</option>";
				foreach ($addresses as $address) {
					$selected = $address->default_address == '1' ? 'selected=selected' : '';
					$addres_field .= "<option value = '$address->id' $selected>$address->first_name, $address->address , $address->landmark</option>";
				}
				echo json_encode(array('msg' => 'success', 'addres_field' => $addres_field));
			} else {
				echo json_encode(array('msg' => 'failed'));
			}
		}
	}

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
				if (empty($promotion_total_amount) && $promotion_total_amount == '')
					$promotion_total_amount = 0;
				$code_exists = \common\models\Promotions::find()->where(['promotion_code' => $code, 'status' => 1])->one();
				$cart_products = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
				$cart_promotions = \common\models\TempSession::find()->where(['user_id' => Yii::$app->user->identity->id, 'type_id' => 3])->all();
				$cart_amount = Cart::total($cart_products);
				if (count($cart_promotions) < 1) {
					if (!empty($code_exists)) {
						$used_code = Cart::UsedCode($_POST['code']); /* check if code used in this order */
						if ($used_code == 0) {
							$date_check = Cart::CheckDate($code_exists); /* check code expiry date */
							if ($date_check == 1) {
								$used = Cart::CodeUsed($code_exists); /* check code is used or not (in case of single use) */
								if ($used == 0) {
									$exist = Cart::PromotionProduct($code_exists, $code); /* check if that product or user is in this order */
									if ($exist == 1) {
										$amount_range = Cart::AmountRange($code_exists, $cart_amount); /* check the amount range with order total amount */
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
					$arr_variable = array('msg' => '9');
				}
			} else {
				$arr_variable = array('msg' => '6');
			}
			$data['result'] = $arr_variable;
			echo json_encode($data);
		}
	}

	/*
	 * Promotion amount cahnge when quanity change
	 */

	public function actionPromotionQuantityChange() {

		if (Yii::$app->request->isAjax && isset(Yii::$app->user->identity->id)) {
			$promo_codes = $_POST['promo_codes'];
			if ($promo_codes) {
				$cart_products = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
				$cart_amount = Cart::total($cart_products);
				$codes = explode(',', $promo_codes);
				$applied_codes = array();
				$promocodes = '';
				$promotion_total_discount = 0;
				\common\models\TempSession::deleteAll(['user_id' => Yii::$app->user->identity->id, 'type_id' => 3]);
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
				$data = array('promotion' => $applied_codes, 'code' => $promocodes, 'total_promotion_amount' => sprintf("%0.2f", $promotion_discount), 'overall_grand_total' => sprintf("%0.2f", $overall_grand_total), 'promotion_total_discount' => sprintf("%0.2f", $promotion_total_discount), 'cart_amount' => $cart_amount);
//  $data = array('promotion' => $applied_codes);
				echo json_encode($data);
			}
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
			$promotion_discount = 0;
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
