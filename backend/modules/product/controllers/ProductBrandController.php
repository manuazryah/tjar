<?php

namespace backend\modules\product\controllers;

use Yii;
use common\models\ProductBrand;
use common\models\ProductBrandSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * ProductBrandController implements the CRUD actions for ProductBrand model.
 */
class ProductBrandController extends Controller {

	public function beforeAction($action) {
		if (!parent::beforeAction($action)) {
			return false;
		}
		if (Yii::$app->user->isGuest) {
			$this->redirect(['/site/index']);
			return false;
		}
		if (Yii::$app->session['post']['product_reviews'] != 1) {
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
	 * Lists all ProductBrand models.
	 * @return mixed
	 */
	public function actionIndex($id = NULL) {
		$searchModel = new ProductBrandSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			    'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single ProductBrand model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render('view', [
			    'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new ProductBrand model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new ProductBrand();

		if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate() && $model->save()) {
			Yii::$app->getSession()->setFlash('success', 'Brands Created Successfully');
			return $this->redirect(['index']);
		} else {
			return $this->renderAjax('create', [
				    'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing ProductBrand model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate() && $model->save()) {
			Yii::$app->getSession()->setFlash('success', 'Brands Updated Successfully');
			return $this->redirect(['index']);
		} else {
			return $this->renderAjax('update', [
				    'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing ProductBrand model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDel($id) {
		if ($this->findModel($id)->delete()) {
			Yii::$app->getSession()->setFlash('error', 'Brand Removed Successfully');
		}

		return $this->redirect(['index']);
	}

	/**
	 * Finds the ProductBrand model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return ProductBrand the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = ProductBrand::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionBrandCategory() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$ids = $_POST['depdrop_parents'];
			$cat_id = empty($ids[0]) ? null : $ids[0];
			$subcat_id = empty($ids[1]) ? null : $ids[1];

			if ($cat_id != null) {
				$out = ProductBrand::getBrandList($cat_id, $subcat_id);

				/**
				 * the getbrandList function will query the database based on the
				 * cat_id and sub_cat_id and return an array like below:
				 *  [
				 *      'out'=>[
				 *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
				 *          ['id'=>'<prod_id_2>', 'name'=>'<prod-name2>']
				 *       ],
				 *       'selected'=>'<prod-id-1>'
				 *  ]
				 */
				echo Json::encode(['output' => $out, 'selected' => '']);
//                echo Json::encode(['output' => $data['out'], 'selected' => $data['selected']]);
				return;
			}
		}
		echo Json::encode(['output' => '', 'selected' => '']);
	}

	public function actionBrand() {
		if (yii::$app->request->isAjax) {
			$val = 0;
			$category = Yii::$app->request->post()['category'];
			if (isset($category)) {
				$brands = ProductBrand::find()->where(['subcategory' => $category])->all();
				$val .= "<option value=''>Select Brand</option>";
				if ($brands) {
					foreach ($brands as $brand) {
						$val .= "<option value='" . $brand->id . "'>" . $brand->brand_name . "</option>";
					}
					echo json_encode(array("con" => "1", 'val' => $val)); //Success
					exit;
				} else {
					echo json_encode(array("con" => "1", 'val' => $val)); //No Return
					exit;
				}
			} else {
				echo 1; //Value Not Setted
				exit;
			}
		}
	}

	public function actionAjaxcreate() {
		$model = new ProductBrand();
		$subcat = '';
		$cat = '';
		$field = '';
		if (Yii::$app->request->post()) {
			$model->main_category = Yii::$app->request->post()['main_category'];
			$model->category = Yii::$app->request->post()['category'];
			$model->subcategory = Yii::$app->request->post()['subcategory'];
			$model->brand_name = Yii::$app->request->post()['brand_name'];
			$model->brand_name_arabic = Yii::$app->request->post()['brand_name_arabic'];
			$model->comments = Yii::$app->request->post()['comments'];
			$model->status = Yii::$app->request->post()['status'];
			$category = \common\models\ProductCategory::find()->where(['category_id' => $model->main_category])->all();
			$subcategory = \common\models\ProductSubCategory::find()->where(['category_id' => $model->category])->all();
			$brands = ProductBrand::find()->where(['subcategory' => $model->subcategory])->all();
			foreach ($subcategory as $subcategry) {
				$subcat .= '<option value="' . $subcategry->id . '">' . $subcategry->subcategory_name . '</option>';
			}
			foreach ($category as $categry) {
				$cat .= '<option value="' . $categry->id . '">' . $categry->category_name . '</option>';
			}
			foreach ($brands as $brand) {
				$field .= '<option value="' . $brand->id . '">' . $brand->brand_name . '</option>';
			}
			if (Yii::$app->SetValues->Attributes($model) && $model->save()) {
				echo json_encode(array("con" => "1", 'id' => $model->id, 'field' => $field, 'field_subcat' => $subcat, 'field_category' => $cat, 'name' => $model->brand_name)); //Success
				exit;
			} else {
				$array = $model->getErrors();
				$error = isset($array['canonical_name']['0']) ? $array['canonical_name']['0'] : 'Internal error';

//                                    var_dump($model->getErrors());
				echo json_encode(array("con" => "2", 'error' => $error));
//                echo '2';
				exit;
			}
		}
		return $this->renderAjax('ajaxcreate', [
			    'model' => $model,
		]);
	}

}
