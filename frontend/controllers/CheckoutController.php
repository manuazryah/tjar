<?php

namespace frontend\controllers;

use yii;
use common\models\OrderDetails;
use common\models\Cart;

class CheckoutController extends \yii\web\Controller {

	public function init() {
		date_default_timezone_set('Asia/Kolkata');
	}

	public function actionPayment($id) {
		$details = OrderDetails::find()->where(['order_id' => $id])->all();

		foreach ($details as $detail) {
			$detail->payment_status = '1';
			$detail->save();
		}

		$oreder_master = \common\models\OrderMaster::findOne(['order_id' => $id]);

		if (!empty($oreder_master)) {
			$oreder_master->payment_status = 1;
			$oreder_master->update();
			Cart::commissionManagement($id);
			return $this->redirect('success');
		} else {
			return $this->redirect('failed');
		}
	}

	public function actionSuccess() {
		return $this->render('success');
	}

}
