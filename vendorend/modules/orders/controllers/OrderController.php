<?php

namespace vendorend\modules\orders\controllers;

use Yii;
use common\models\OrderMaster;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\OrderDetailsSearch;
use common\models\OrderDetails;

class OrderController extends \yii\web\Controller {

    public function actionIndex() {
        $order_array = [];
        $vendor_id = Yii::$app->user->identity->id;
        $order_master = OrderMaster::find()->where(['admin_status' => 1])->all();
        if (!empty($order_master)) {
            foreach ($order_master as $order) {
                $order_array[] = $order->order_id;
            }
        }
        $product_array = [];
        $products = \common\models\ProductVendor::find()->where(['full_fill' => 0])->all();
        if (!empty($products)) {
            foreach ($products as $val) {
                $product_array[] = $val->product_id;
            }
        }
        $searchModel = new OrderDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['vendor_id' => $vendor_id])->andWhere(['in', 'order_id', $order_array])->andWhere(['in', 'product_id', $product_array]);
        $dataProvider1 = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider1->query->andWhere(['vendor_id' => $vendor_id])->andWhere(['in', 'order_id', $order_array])->andWhere(['status' => 1])->andWhere(['in', 'product_id', $product_array]);
        $dataProvider2 = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider2->query->andWhere(['vendor_id' => $vendor_id])->andWhere(['in', 'order_id', $order_array])->andWhere(['status' => 0])->andWhere(['in', 'product_id', $product_array]);
        $dataProvider3 = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider3->query->andWhere(['vendor_id' => $vendor_id])->andWhere(['in', 'order_id', $order_array])->andWhere(['status' => 2])->andWhere(['in', 'product_id', $product_array]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
                    'dataProvider3' => $dataProvider3,
        ]);
    }

    /**
     * This function change order status
     * @return mixed
     */
    public function actionChangeOrderStatus() {
        if (yii::$app->request->isAjax) {
            $id = Yii::$app->request->post()['id'];
            $status = Yii::$app->request->post()['status'];
            $model = OrderDetails::find()->where(['id' => $id])->one();
            $model->status = $status;
            if ($model->save()) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    /**
     * Displays a single OrderMaster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $vendor_id = Yii::$app->user->identity->id;
        $product_array = [];
        $products = \common\models\ProductVendor::find()->where(['full_fill' => 0])->all();
        if (!empty($products)) {
            foreach ($products as $val) {
                $product_array[] = $val->product_id;
            }
        }
        $searchModel = new OrderDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['order_id' => $id])->andWhere(['in', 'product_id', $product_array])->andWhere(['vendor_id' => $vendor_id]);

        return $this->render('view', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'id' => $id,
        ]);
    }

    public function actionPrint($id) {
        $vendor_id = Yii::$app->user->identity->id;
        $order_master = OrderMaster::find()->where(['order_id' => $id])->one();
        $product_array = [];
        $products = \common\models\ProductVendor::find()->where(['full_fill' => 0])->all();
        if (!empty($products)) {
            foreach ($products as $val) {
                $product_array[] = $val->product_id;
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
