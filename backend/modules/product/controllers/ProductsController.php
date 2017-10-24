<?php

namespace backend\modules\product\controllers;

use Yii;
use common\models\Products;
use common\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use common\models\ProductSpecifications;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller {

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
	 * Lists all Products models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new ProductsSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			    'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Products model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render('view', [
			    'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Products model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {


		$model = new Products();

		if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
			if ($model->validate() && $model->save()) {
				$specfctns = Yii::$app->request->post()['specifications'];
				if (!empty($specfctns)) {

					foreach ($specfctns as $key => $value) {
//						$feature_details = \common\models\ProductFeatures::findOne($key);
//						if ($feature_details->specification_type == 0) {
//							$field_value = explode('_', $value);
//							$product_specfctn_model->product_feature_value = $field_value[0];
//							$product_specfctn_model->Product_feature_text = $field_value[1];
//						} else {
//							$product_specfctn_model->product_feature_value = $value;
//						}
						$product_specfctn_model = new ProductSpecifications();
						$product_specfctn_model->product_id = $model->id;
						$product_specfctn_model->product_feature_id = $key;
						$product_specfctn_model->product_feature_value = $value;
						$product_specfctn_model->save();
					}
					exit;
				}
			}
			return $this->redirect(['index']);
		}
		return $this->render('create', [
			    'model' => $model,
		]);
	}

	function recursiveRemoveDirectory($directory) {
		foreach (glob("{$directory}/*") as $file) {
			if (is_dir($file)) {
				recursiveRemoveDirectory($file);
			} else {
				unlink($file);
			}
		}
		FileHelper::removeDirectory($directory);
	}

	/**
	 * Updates an existing Products model.
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
	 * Deletes an existing Products model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Products model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Products the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Products::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionFileUpload() {
		$dir = \Yii::$app->basePath . '/../uploads/temp/' . Yii::$app->session['tempfolder'];
		if (isset(Yii::$app->session['tempfolder']) && file_exists($dir)) {

			$result = $this->ImageUpload($_FILES, Yii::$app->session['tempfolder']);
			if ($result == 1) {
				return '{}';
			}
		} else {
			$uniqueId = time() . '-' . mt_rand();
			Yii::$app->session['tempfolder'] = $uniqueId;
			if (!is_dir(\Yii::$app->basePath . '/../uploads/temp/' . $uniqueId)) {
				mkdir(\Yii::$app->basePath . '/../uploads/temp/' . $uniqueId);
				chmod(\Yii::$app->basePath . '/../uploads/temp/' . $uniqueId, 0777);
			}
			$result = $this->ImageUpload($_FILES, Yii::$app->session['tempfolder']);
			if ($result == 1) {
				return '{}';
			}
		}





//
//		$file->saveAs(Yii::$app->basePath . '/../uploads/product/' . $uniqueId . '/' . 'profile.' . $file->extension);
//		return TRUE;
	}

	public function ImageUpload($data, $uniqueId) {
		$uploaddir = \Yii::$app->basePath . '/../uploads/temp/' . $uniqueId;
		if (file_exists($uploaddir . '/profile.' . Yii::$app->session['profile_extnsn'])) {

			$temp = explode(".", $data["galleryiamges"]["name"]);
			basename($data['galleryiamges']['name']);
			if (move_uploaded_file($data['galleryiamges']['tmp_name'], $uploaddir . '/' . $temp[0] . '.' . end($temp))) {
				return 1;
			} else {
				return 0;
			}
		} else {

			$temp = explode(".", $data["galleryiamges"]["name"]);
			Yii::$app->session['profile_extnsn'] = end($temp);
			basename($data['galleryiamges']['name']);
			if (move_uploaded_file($data['galleryiamges']['tmp_name'], $uploaddir . '/profile.' . end($temp))) {
				return 1;
			} else {
				return 0;
			}
		}
	}

	public function actionProductFeatures() {
		if (Yii::$app->request->isAjax) {
//			var_dump($_POST);
//			exit;
			if (!empty($_POST['category_id'])) {

				$features = \common\models\ProductFeatures::find()->where(['category' => $_POST['category_id']])->all();
			} elseif (!empty($_POST['sub_category_id']) && !empty($_POST['category_id'])) {
				$features = \common\models\ProductFeatures::find()->where(['category' => $_POST['category_id'], 'subcategory' => $_POST['sub_category_id']])->all();
			}

			$value = $this->renderPartial('product-specifications', [
			    'features' => $features,
			]);

			echo $value;
		}
	}

}
