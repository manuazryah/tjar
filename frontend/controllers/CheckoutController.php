<?php

namespace frontend\controllers;

use yii;
use common\models\OrderDetails;

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
        return $this->render('index');
    }

}
