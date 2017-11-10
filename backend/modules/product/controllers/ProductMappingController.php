<?php

namespace backend\modules\product\controllers;

use Yii;
use common\models\ProductMapping;
use common\models\ProductMappingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductMappingController implements the CRUD actions for ProductMapping model.
 */
class ProductMappingController extends Controller {

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
     * Lists all ProductMapping models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProductMappingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductMapping model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductMapping model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ProductMapping();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate()) {
            $model->product_id = implode(',', $model->product_id);
            $model->variants = implode(',', $model->variants);
            $model->save();
            return $this->redirect(['index']);
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductMapping model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate()) {
            $model->product_id = implode(',', $model->product_id);
            $model->variants = implode(',', $model->variants);
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductMapping model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductMapping model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductMapping the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProductMapping::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * This function select sub category and products based on category
     * return result to the view
     */

    public function actionChangeCategory() {
        if (Yii::$app->request->isAjax) {
            $category = $_POST['category'];
            $subcategories = \common\models\ProductSubCategory::findAll(['category_id' => $category, 'status' => 1]);
            $product_datas = \common\models\Products::findAll(['category' => $category, 'status' => 1]);
            $options = '<option value="">-Choose Subcategory-</option>';
            $options1 = '<option value="">-Choose Products-</option>';
            if (!empty($subcategories)) {
                foreach ($subcategories as $subcategory) {
                    $options .= "<option value='" . $subcategory->id . "'>" . $subcategory->subcategory_name . "</option>";
                }
            }
            if (!empty($product_datas)) {
                foreach ($product_datas as $product_data) {
                    $options1 .= "<option value='" . $product_data->id . "'>" . $product_data->product_name . "</option>";
                }
            }
            $arr_variable = array('subcategory' => $options, 'products' => $options1);
            $data['result'] = $arr_variable;
            echo json_encode($data);
        }
    }

    /*
     * This function select sub category and products based on category
     * return result to the view
     */

    public function actionChangeSubcategory() {
        if (Yii::$app->request->isAjax) {
            $category = $_POST['category'];
            $subcategory = $_POST['subcategory'];
            $product_datas = \common\models\Products::findAll(['subcategory' => $subcategory, 'status' => 1]);
            if (empty($product_datas)) {
                $product_datas = \common\models\Products::findAll(['category' => $category, 'status' => 1]);
            }
            $options = '<option value="">-Choose Product-</option>';
            if (!empty($product_datas)) {
                foreach ($product_datas as $product_data) {
                    $options .= "<option value='" . $product_data->id . "'>" . $product_data->product_name . "</option>";
                }
            }
            echo $options;
        }
    }

}
