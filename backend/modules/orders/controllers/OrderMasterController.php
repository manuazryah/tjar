<?php

namespace backend\modules\orders\controllers;

use Yii;
use common\models\OrderMaster;
use common\models\OrderMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\OrderDetailsSearch;
use common\models\OrderDetails;
use common\models\OrderHistory;

/**
 * OrderMasterController implements the CRUD actions for OrderMaster model.
 */
class OrderMasterController extends Controller {

    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/site/index']);
            return false;
        }
        if (Yii::$app->session['post']['order'] != 1) {
            $this->redirect(['/site/exception']);
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all OrderMaster models.
     * @return mixed
     */
    public function actionIndex($order_status = NULL) {
        $searchModel = new OrderMasterSearch();
        if (Yii::$app->request->queryParams['OrderMasterSearch']['user_id'] != NULL) {
            $search_status = 1;
        } else {
            $search_status = 0;
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($order_status == 1) {
            $dataProvider->query->andWhere(['admin_status' => 0]);
        } elseif ($order_status == 2) {
            $dataProvider->query->andWhere(['admin_status' => 1]);
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'order_status' => $order_status,
                    'search_status' => $search_status,
        ]);
    }

    /**
     * Displays a single OrderMaster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {

        $searchModel = new OrderDetailsSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->query->andWhere(['order_id' => $id]);
        $ordermaster = OrderMaster::find()->where(['order_id' => $id])->one();
        $orderdetails = OrderDetails::find()->where(['order_id' => $id])->all();


        return $this->render('view', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
                    'id' => $id,
                    'ordermaster' => $ordermaster,
                    'orderdetails' => $orderdetails,
        ]);
    }

    /**
     * Creates a new OrderMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new OrderMaster();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OrderMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing OrderMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionTrack($id) {
        return $this->renderAjax('track', [
                    'model' => OrderDetails::findOne($id),
                    'history' => \common\models\OrderHistory::find()->where(['detail_id' => $id])->all(),
        ]);
    }

    /**
     * Finds the OrderMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = OrderMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Lists all OrderMaster models products full filled by tjar.
     * @return mixed
     */
    public function actionFullFill() {
        $product_array = [];
        $order_array = [];
        $products = \common\models\ProductVendor::find()->where(['full_fill' => 1])->all();
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
        return $this->render('full_fill', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrderMaster model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewMore($id, $order_status = NULL) {
        $product_array = [];
        $products = \common\models\ProductVendor::find()->where(['full_fill' => 1])->all();
        if (!empty($products)) {
            foreach ($products as $val) {
                $product_array[] = $val->id;
            }
        }
        $searchModel = new OrderDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['order_id' => $id, 'admin_status' => '1'])->andWhere(['in', 'product_id', $product_array]);
        if ($order_status == 1) {
            $dataProvider->query->andWhere(['status' => 0]);
        } elseif ($order_status == 2) {
            $dataProvider->query->andWhere(['status' => 1]);
        } elseif ($order_status == 3) {
            $dataProvider->query->andWhere(['status' => 2]);
        } elseif ($order_status == 4) {
            $dataProvider->query->andWhere(['status' => 3]);
        }

        return $this->render('view_more', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'id' => $id,
                    'order_status' => $order_status,
        ]);
    }

    /**
     * This function change admin status
     * @return mixed
     */
    public function actionChangeAdminStatus() {
        if (yii::$app->request->isAjax) {
            $id = Yii::$app->request->post()['id'];
            $admin_status = Yii::$app->request->post()['status'];
            $model = OrderMaster::find()->where(['id' => $id])->one();
            $model->admin_status = $admin_status;
            $details = OrderDetails::find()->where(['order_id' => $model->order_id])->all();
            foreach ($details as $detail) {
                $detail->admin_status = $admin_status;
                $detail->save();
                $product_details = \common\models\ProductVendor::findOne($detail->product_id);
                if ($product_details->full_fill == 1) {
                    $history_id = Yii::$app->SetValues->History($detail->id, 8, $detail->product_id, 1, Yii::$app->user->identity->id); //params : reference id, history type, product id, user type, user id
                } else {
                    $history_id = Yii::$app->SetValues->History($detail->id, 9, $detail->product_id, 2, $product_details->vendor_id); //params : reference id, history type, product id, user type, user id
                }
                if (isset($history_id))
                    Yii::$app->SetValues->Notifications($detail->id, $history_id, Yii::$app->user->identity->id);
            }
            if ($model->save()) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    /**
     * This function change admin status
     * @return mixed
     */
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

    /**
     * This function print order details.
     * @param integer $id
     * @return mixed
     */
    public function actionPrintAll($id) {
        $order_master = OrderMaster::find()->where(['order_id' => $id])->one();
        $order_details = OrderDetails::find()->where(['order_id' => $id])->all();
        $promotions = \common\models\OrderPromotions::find()->where(['order_master_id' => $order_master->id])->sum('promotion_discount');
        echo $this->renderPartial('_print', [
            'order_master' => $order_master,
            'order_details' => $order_details,
            'promotions' => $promotions
        ]);
        exit;
    }

    public function actionPrint($id) {
        $order_master = OrderMaster::find()->where(['order_id' => $id])->one();
        $product_array = [];
        $products = \common\models\ProductVendor::find()->where(['full_fill' => 1])->all();
        if (!empty($products)) {
            foreach ($products as $val) {
                $product_array[] = $val->id;
            }
        }
        $order_details = OrderDetails::find()->where(['order_id' => $id])->andWhere(['in', 'product_id', $product_array])->all();
//        echo '<pre>';print_r($order_details);exit;
//        $promotions = \common\models\OrderPromotions::find()->where(['order_master_id' => $order_master->id])->sum('promotion_discount');
        echo $this->renderPartial('_print', [
            'order_master' => $order_master,
            'order_details' => $order_details,
//            'promotions' => $promotions
        ]);
        exit;
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

    public function actionUserView($id) {
        $product_model = \common\models\User::findOne(['id' => $id]);

        return $this->renderAjax('user-view', [
                    'model' => $product_model,
        ]);
    }

    public function actionProductView($id) {
        $product_vendor = \common\models\ProductVendor::findOne(['id' => $id]);
        $product = \common\models\Products::findOne(['id' => $product_vendor->product_id]);
        return $this->renderAjax('product-view', [
                    'model' => $product,
        ]);
    }

    public function actionVendorView($id) {
        $vendor = \common\models\Vendors::findOne(['id' => $id]);
        return $this->renderAjax('vendor-view', [
                    'model' => $vendor,
        ]);
    }

}
