<?php

namespace vendorend\modules\orders\controllers;

use Yii;
use common\models\OrderMaster;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\OrderDetailsSearch;
use common\models\OrderDetails;
use common\models\OrderHistory;
use common\models\OrderMasterSearch;

class OrderController extends \yii\web\Controller {

    public function init() {
        date_default_timezone_set('Asia/Kolkata');
    }

    public function actionIndex() {
        $product_array = [];
        $order_array = [];
        $products = \common\models\ProductVendor::find()->where(['vendor_id' => Yii::$app->user->identity->id])->all();
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
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * This function change order status
     * @return mixed
     */
    public function actionChangeOrderStatus() {
        if (yii::$app->request->isAjax) {
            $id = Yii::$app->request->post()['ids'];
//             echo $id.'id';exit;
            $status = Yii::$app->request->post()['status'];
            $model = OrderDetails::find()->where(['id' => $id])->one();
            $model->status = $status;
            if ($status != '0') {
                $model1 = new OrderHistory();
                $model1->detail_id = $model->id;
                $model1->order_id = $model->order_id;
                $model1->product_id = $model->product_id;
                $model1->status = $status;
                $model1->date = date('Y-m-d H:i:s');
                if ($model1->save()) {
                    
                }
            }

            if ($status == '3') {
                $model->delivered_date = date('Y-m-d H:i:s');
            }
            if ($model->save()) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    public function actionOrderHistoryComment() {
        if (yii::$app->request->isAjax) {
            $comment = Yii::$app->request->post()['comment'];
            $id = Yii::$app->request->post()['id'];
            $details = OrderDetails::find()->where(['id' => $id])->one();
            $model = new OrderHistory();
            $model->detail_id = $id;
            $model->order_id = $details->order_id;
            $model->product_id = $details->product_id;
            $model->status = $details->status;
            $model->date = date('Y-m-d H:i:s');
            $model->comment = $comment;
            if ($model->save()) {
                echo json_encode(array('msg' => 'success'));
                exit;
            } else {
                echo json_encode(array('msg' => 'failed'));
                exit;
            }
        }
    }

    public function actionViewMore($id) {
        $vendor_id = Yii::$app->user->identity->id;
        $product_array = [];
        $products = \common\models\ProductVendor::find()->where(['vendor_id' => $vendor_id])->all();
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

    public function actionTrack($id) {
        return $this->renderAjax('track', [
                    'model' => $this->findModel($id),
                    'history' => OrderHistory::find()->where(['detail_id' => $id])->all(),
        ]);
    }

    protected function findModel($id) {
        if (($model = OrderDetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPrint($id) {
        $vendor_id = Yii::$app->user->identity->id;
        $order_master = OrderMaster::find()->where(['order_id' => $id])->one();
        $product_array = [];
        $products = \common\models\ProductVendor::find()->where(['vendor_id' => $vendor_id])->all();
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
    
    public function actionChangeVendorStatus() {
        if (yii::$app->request->isAjax) {
            $id = Yii::$app->request->post()['id'];
            $status = Yii::$app->request->post()['status'];
            $model = OrderDetails::find()->where(['id' => $id])->one();
            $model->status = $status;
            if ($status != '0') {
                $model1 = new OrderHistory();
                $model1->detail_id = $model->id;
                $model1->order_id = $model->order_id;
                $model1->product_id = $model->product_id;
                $model1->status = $status;
                $model1->date = date('Y-m-d H:i:s');
                if ($model1->save()) {
                    
                }
            }

            if ($status == '3') {
                $model->delivered_date = date('Y-m-d H:i:s');
            }
            if ($model->save()) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

}
