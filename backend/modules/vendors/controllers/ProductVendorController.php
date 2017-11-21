<?php

namespace backend\modules\vendors\controllers;

use Yii;
use common\models\ProductVendor;
use common\models\ProductVendorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Products;
use common\models\Vendors;

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

	public function actionView($id) {

		$product_model = $this->findModel($id);
		$vendor_address = \common\models\Locations::find()->where(['vendor_id' => $product_model->vendor_id])->orderBy(['(dafault_address)' => SORT_DESC])->all();
		$product_specifications = \common\models\ProductSpecifications::find()->where(['product_id' => $product_model->product_id])->all();
		return $this->render('view', [
			    'model' => $product_model,
			    'product_specifications' => $product_specifications,
			    'vendor_address' => $vendor_address,
		]);
	}

	public function actionVendorView($id) {

		$product_model = vendors::findOne(['id' => $id]);

		return $this->renderAjax('vendor-view', [
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
			if ($model->save()) {
				echo 1;
			} else {
				echo 0;
			}
		}
	}

}
