<?php

namespace vendorend\modules\product\controllers;

use yii;
use common\models\ProductVendor;
use common\models\ProductVendorSearch;
use common\models\OrderDetailsSearch;
use common\models\OrderDetails;
use common\models\OrderMasterSearch;
use common\models\OrderMaster;

class FullfillController extends \yii\web\Controller {

    public function actionIndex($vendor_status = NULL, $admin_status = NULL, $expiry = NULL, $soldout = NULL) {

        $searchModel = new ProductVendorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (!empty($vendor_status)) {
            $dataProvider->query->andWhere(['vendor_status' => $vendor_status]);
        } elseif (!empty($admin_status)) {
            $dataProvider->query->andWhere(['admin_status' => $admin_status]);
        } elseif ($expiry == 1) {
            $dataProvider->query->andWhere(['and', 'expiry_date<= NOW()']);
        } elseif ($soldout == 1) {
            $dataProvider->query->andWhere(['and', 'qty<= 0']);
        }

        $dataProvider->query->andWhere(['<>', 'full_fill', 0]);
        $dataProvider->query->andWhere(['vendor_id' => \Yii::$app->user->identity->id]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'vendor_status' => $vendor_status,
                    'admin_status' => $admin_status,
                    'expiry' => $expiry,
                    'soldout' => $soldout,
        ]);
    }

    public function actionOrders() {
        $product_array = [];
        $order_array = [];
        $products = \common\models\ProductVendor::find()->where(['full_fill' => '1', 'vendor_id' => Yii::$app->user->identity->id])->all();
        if (!empty($products)) {
            foreach ($products as $value) {
                $product_array[] = $value->id;
            }
            $order_details = OrderDetails::find()->where(['in', 'product_id', $product_array])->all();
            if (!empty($order_details)) {
                foreach ($order_details as $order) {
                    $order_array[] = $order->order_id;
                }
            }
        }
        $searchModel = new OrderMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['in', 'order_id', $order_array]);
        $dataProvider->query->andWhere(['admin_status' => '1']);
        return $this->render('full_fill', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewMore($id) {
        $vendor_id = Yii::$app->user->identity->id;
        $product_array = [];
        $products = \common\models\ProductVendor::find()->where(['full_fill' => '1', 'vendor_id' => $vendor_id])->all();
        if (!empty($products)) {
            foreach ($products as $val) {
                $product_array[] = $val->id;
            }
        }
        $ordermaster = OrderMaster::find()->where(['order_id' => $id, 'admin_status' => '1'])->one();
        $orderdetails = OrderDetails::find()->where(['order_id' => $id, 'admin_status' => '1'])->andWhere(['in', 'product_id', $product_array])->all();

        return $this->render('view_more', [
                    'id' => $id,
                    'ordermaster' => $ordermaster,
                    'orderdetails' => $orderdetails,
        ]);
    }

    public function actionPrintAll($id) {
        $vendor_id = Yii::$app->user->identity->id;
        $order_master = OrderMaster::find()->where(['order_id' => $id])->one();
        $product_array = [];
        $products = ProductVendor::find()->where(['vendor_id' => $vendor_id, 'full_fill' => 1])->all();
        if (!empty($products)) {
            foreach ($products as $val) {
                $product_array[] = $val->id;
            }
        }
        $order_details = OrderDetails::find()->where(['order_id' => $id])->andWhere(['in', 'product_id', $product_array])->andWhere(['vendor_id' => $vendor_id])->all();
//        $promotions = \common\models\OrderPromotions::find()->where(['order_master_id' => $order_master->id])->sum('promotion_discount');
        echo $this->renderPartial('_print', [
            'order_master' => $order_master,
            'order_details' => $order_details,
//            'promotions' => $promotions
        ]);
        exit;
    }

}
