<?php

namespace backend\modules\vendors\controllers;

use Yii;
use common\models\ProductVendor;
use common\models\ProductVendorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Products;
use common\models\UserComplaintsSearch;
use common\models\Vendors;
use common\models\StockHistory;

/**
 * ProductVendorController implements the CRUD actions for ProductVendor model.
 */
class ProductVendorController extends Controller {

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
         * Lists all ProductVendor models.
         * @return mixed
         */
        public function actionIndex($vendor_status = NULL, $admin_status = NULL, $expiry = NULL, $soldout = NULL) {
                $searchModel = new ProductVendorSearch();
//		var_dump(Yii::$app->request->queryParams);
//		exit;
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
                $query = explode('&', $_SERVER['QUERY_STRING']);
                unset(Yii::$app->session['urls']);
                Yii::$app->session->set('urls', $query[1]);
                $dataProvider->query->andWhere(['full_fill' => 0]);
                return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'vendor_status' => $vendor_status,
                            'admin_status' => $admin_status,
                            'expiry' => $expiry,
                            'soldout' => $soldout,
                ]);
        }

        public function actionProductView($id) {

                $product_model = Products::findOne(['id' => $id]);

                return $this->renderAjax('product-view', [
                            'model' => $product_model,
                ]);
        }

        public function actionProductComplaints($id) {
                $searchModel = new UserComplaintsSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->query->andWhere(['product_id' => $id]);
//		$complaints = UserComplaints::find()->where(['product_id' => $id])->all();

                return $this->render('_complaints', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'id' => $id,
                ]);
        }

        public function actionView($id) {

                $product_model = $this->findModel($id);
                $vendor_address = \common\models\Locations::find()->where(['vendor_id' => $product_model->vendor_id])->orderBy(['(dafault_address)' => SORT_DESC])->all();
                $product_specifications = \common\models\ProductSpecifications::find()->where(['product_id' => $product_model->product_id])->all();
                return $this->render('view', [
                            'model' => $product_model,
                            'product_specifications' => $product_specifications,
                            'vendor_address' => $vendor_address,
                            'id' => $id,
                ]);
        }

        public function actionProductHistory($id) {

                $product_model = $this->findModel($id);
                if (!empty($product_model)) {
                        $other_vendors = ProductVendor::find()->where(['<>', 'id', $id])->andWhere(['product_id' => $product_model->product_id])->all();
                } else {
                        $other_vendors = '';
                }
                $from = '';
                $to = '';
                if (Yii::$app->request->post()) {
                        if (Yii::$app->request->post('from_date') != '') {
                                $from = Yii::$app->request->post('from_date');
                        }
                        if (Yii::$app->request->post('to_date') != '') {
                                $to = Yii::$app->request->post('to_date');
                        }
                }
                return $this->render('product-history', [
                            'model' => $product_model,
                            'id' => $id,
                            'from' => $from,
                            'to' => $to,
                            'other_vendors' => $other_vendors,
                ]);
        }

        public function actionVendorView($id) {

                $product_model = vendors::findOne(['id' => $id]);

                return $this->renderAjax('vendor-view', [
                            'model' => $product_model,
                ]);
        }

        public function actionUserView($id) {

                $product_model = \common\models\User::findOne(['id' => $id]);
//		var_dump($product_model);
//		exit;
                return $this->renderAjax('user-view', [
                            'model' => $product_model,
                ]);
        }

        /**
         * Displays a single ProductVendor model.
         * @param integer $id
         * @return mixed
         */
//	public function actionView($id) {
//		return $this->render('view', [
//			    'model' => $this->findModel($id),
//		]);
//	}

        /**
         * Creates a new ProductVendor model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate() {
                $model = new ProductVendor();

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                } else {
                        return $this->render('create', [
                                    'model' => $model,
                        ]);
                }
        }

        /**
         * Updates an existing ProductVendor model.
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
         * Deletes an existing ProductVendor model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDelete($id) {
                $this->findModel($id)->delete();

                return $this->redirect(['index']);
        }

        /**
         * Finds the ProductVendor model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return ProductVendor the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id) {
                if (($model = ProductVendor::findOne($id)) !== null) {
                        return $model;
                } else {
                        throw new NotFoundHttpException('The requested page does not exist.');
                }
        }

        /**
         * This function change admin status
         * @return mixed
         */
        public function actionChangeAdminStatus() {
                if (yii::$app->request->isAjax) {
                        $id = Yii::$app->request->post()['id'];
                        $admin_status = Yii::$app->request->post()['status'];
                        $model = $this->findModel($id);
                        $model->admin_status = $admin_status;
                        if ($admin_status == 2)
                                $model->vendor_status = 1;
                        if ($model->save()) {
                                if ($model->admin_status != 1) {
                                        $history_id = Yii::$app->SetValues->History($model->id, $admin_status, $model->id, 2, Yii::$app->user->identity->id); //params : reference id, history type, product id, user type, user id
                                        if (isset($history_id))
                                                Yii::$app->SetValues->Notifications($model->id, $history_id, Yii::$app->user->identity->id); //params : reference id, history id, user id
                                }

                                echo 1;
                        } else {
                                echo 0;
                        }
                }
        }

        public function actionChangeVendorStatus() {
                if (yii::$app->request->isAjax) {

                        $id = Yii::$app->request->post()['id'];
                        $vendor_status = Yii::$app->request->post()['status'];
                        $model = $this->findModel($id);
                        $model->vendor_status = $vendor_status;
                        if ($model->save()) {
                                echo 1;
                        } else {
                                echo 0;
                        }
                }
        }

        public function actionAjaxChangeData() {
                if (yii::$app->request->isAjax) {
                        $qty = Yii::$app->request->post()['qty'];
                        $price = Yii::$app->request->post()['price'];
                        $id = Yii::$app->request->post()['id'];
                        if ($id) {
                                $model = $this->findModel($id);
                                $old_qty = $model->qty;
                                $model->qty = $qty;
                                $model->price = $price;
                                if ($model->save()) {
                                        if ($qty != $old_qty) {
                                                StockHistory::stockhistory($model->qty, '2', $model->id, '1', $old_qty);
                                        }
                                        echo json_encode(array('msg' => 'success', 'title' => 'succesfully changed'));
                                } else {

                                        echo json_encode(array('msg' => 'error', 'title' => 'Internal error '));
                                }
                        } else {
                                echo json_encode(array('msg' => 'error', 'title' => 'Product cannot be find'));
                        }
                }
        }

}
