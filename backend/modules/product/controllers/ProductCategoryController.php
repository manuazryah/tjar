<?php

namespace backend\modules\product\controllers;

use Yii;
use common\models\ProductCategory;
use common\models\ProductCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * ProductCategoryController implements the CRUD actions for ProductCategory model.
 */
class ProductCategoryController extends Controller {

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
     * Lists all ProductCategory models.
     * @return mixed
     */
    public function actionIndex($id = NULL) {

        $searchModel = new ProductCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ProductCategory();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Category Created Successfully');
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Category Updated Successfully');
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDel($id) {
        if ($this->findModel($id)->delete()) {
            Yii::$app->getSession()->setFlash('error', 'Category Removed Successfully');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProductCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCategories() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = ProductCategory::getCatList($cat_id);
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

    public function actionCategory() {
        if (yii::$app->request->isAjax) {
            $main_cat = Yii::$app->request->post()['main_cat'];
            if (isset($main_cat)) {
                $categories = ProductCategory::find()->where(['category_id' => $main_cat])->all();
                $val .= "<option value=''>Select Category</option>";
                if ($categories) {
                    foreach ($categories as $catgry) {
                        $val .= "<option value='" . $catgry->id . "'>" . $catgry->category_name . "</option>";
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
        $model = new ProductCategory();
        if (Yii::$app->request->post()) {
            $model->category_id = Yii::$app->request->post()['category_id'];
            $model->canonical_name = Yii::$app->request->post()['canonical_name'];
            $model->category_name = Yii::$app->request->post()['category_name'];
            $model->category_name_arabic = Yii::$app->request->post()['category_name_arabic'];
            $model->comments = Yii::$app->request->post()['comments'];
            $model->status = Yii::$app->request->post()['status'];
            $category = ProductCategory::find()->where(['category_id' => $model->category_id])->all();
            foreach ($category as $categry) {
                $cat .= '<option value="' . $categry->id . '">' . $categry->category_name . '</option>';
            }
            if (Yii::$app->SetValues->Attributes($model) && $model->save()) {
                echo json_encode(array("con" => "1", 'id' => $model->id, 'field' => $cat, 'name' => $model->category_name)); //Success
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
            $model = ProductCategory::find()->where(['canonical_name' => $canonical])->one();
            if ($model) {
                echo json_encode(array("con" => "2", 'error' => 'Canonical Name "' . $canonical . '" has already been taken.')); //Failed
                exit;
            } else {
                echo json_encode(array("con" => "1", 'error' => 'Success')); //Success
                exit;
            }
        }
    }

}
