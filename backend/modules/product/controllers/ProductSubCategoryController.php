<?php

namespace backend\modules\product\controllers;

use Yii;
use common\models\ProductSubCategory;
use common\models\ProductSubCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * ProductSubCategoryController implements the CRUD actions for ProductSubCategory model.
 */
class ProductSubCategoryController extends Controller {

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
     * Lists all ProductSubCategory models.
     * @return mixed
     */
    public function actionIndex($id = NULL) {
        $searchModel = new ProductSubCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductSubCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductSubCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ProductSubCategory();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Subcategory Created Successfully');
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductSubCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Subcategory Updated Successfully');
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductSubCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDel($id) {
        if ($this->findModel($id)->delete()) {
            Yii::$app->getSession()->setFlash('error', 'Subcategory Removed Successfully');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductSubCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductSubCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProductSubCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSubcat() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $cat_id = empty($ids[0]) ? null : $ids[0];
            $subcat_id = empty($ids[1]) ? null : $ids[1];
            if ($cat_id != null) {
                $out = ProductSubCategory::getSubcatList($cat_id, $subcat_id);
                /**
                 * the getProdList function will query the database based on the
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

    public function actionSubcategories() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = ProductSubCategory::getSubCategoryList($cat_id);
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionSubcategory() {
        if (yii::$app->request->isAjax) {
            $category = Yii::$app->request->post()['category'];
            if (isset($category)) {
                $categories = ProductSubCategory::find()->where(['category_id' => $category])->all();
                $val .= "<option value=''>Select Sub Category</option>";
                if ($categories) {
                    foreach ($categories as $catgry) {
                        $val .= "<option value='" . $catgry->id . "'>" . $catgry->subcategory_name . "</option>";
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
        $model = new ProductSubCategory();
        if (Yii::$app->request->post()) {
//            main_category_id: , main_catname: , category_id: , cat_name: , subcategory_name: , canonical_name: , subcategory_name_arabic: , status: , comments: 
            $model->main_category_id = Yii::$app->request->post()['main_category_id'];
            $model->category_id = Yii::$app->request->post()['category_id'];
            $model->subcategory_name = Yii::$app->request->post()['subcategory_name'];
            $model->canonical_name = Yii::$app->request->post()['canonical_name'];
            $model->subcategory_name_arabic = Yii::$app->request->post()['subcategory_name_arabic'];
            $model->comments = Yii::$app->request->post()['comments'];
            $model->status = Yii::$app->request->post()['status'];
            $category = \common\models\ProductCategory::find()->where(['category_id' => $model->main_category_id])->all();
            $subcategory = ProductSubCategory::find()->where(['category_id' => $model->category_id])->all();
            foreach ($subcategory as $categry) {
                $subcat .= '<option value="' . $categry->id . '">' . $categry->subcategory_name . '</option>';
            }
            foreach ($category as $categry) {
                $cat .= '<option value="' . $categry->id . '">' . $categry->category_name . '</option>';
            }
            if (Yii::$app->SetValues->Attributes($model) && $model->save()) {
                echo json_encode(array("con" => "1", 'id' => $model->id, 'field' => $subcat, 'field_category' => $cat, 'name' => $model->subcategory_name)); //Success
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

    public function actionCanonical() {
        if (yii::$app->request->isAjax) {
            $canonical = Yii::$app->request->post()['canonical'];
            $model = ProductSubCategory::find()->where(['canonical_name' => $canonical])->one();
            if ($model) {
                echo json_encode(array("con" => "2", 'error' => 'Canonical Name "'.$canonical.'" has already been taken.')); //Failed
                exit;
            } else {
                echo json_encode(array("con" => "1", 'error' => 'Success')); //Success
                exit;
            }
        }
    }

}
