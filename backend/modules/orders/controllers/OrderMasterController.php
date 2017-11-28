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
        ]);
    }

    /**
     * Displays a single OrderMaster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $searchModel = new OrderDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['order_id' => $id]);

        return $this->render('view', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
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
    public function actionViewMore($id) {
        $product_array = [];
        $products = \common\models\ProductVendor::find()->where(['full_fill' => 1])->all();
        if (!empty($products)) {
            foreach ($products as $val) {
                $product_array[] = $val->id;
            }
        }
        $searchModel = new OrderDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['order_id' => $id])->andWhere(['in', 'product_id', $product_array]);

        return $this->render('view_more', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
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
//        $promotions = \common\models\OrderPromotions::find()->where(['order_master_id' => $order_master->id])->sum('promotion_discount');
        echo $this->renderPartial('_print', [
            'order_master' => $order_master,
            'order_details' => $order_details,
//            'promotions' => $promotions
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
//        $promotions = \common\models\OrderPromotions::find()->where(['order_master_id' => $order_master->id])->sum('promotion_discount');
        echo $this->renderPartial('_print', [
            'order_master' => $order_master,
            'order_details' => $order_details,
//            'promotions' => $promotions
        ]);
        exit;
    }

}
