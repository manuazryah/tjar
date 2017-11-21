<?php

namespace backend\modules\product\controllers;

use Yii;
use common\models\ProductMainCategory;
use common\models\ProductMainCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;
/**
 * ProductMainCategoryController implements the CRUD actions for ProductMainCategory model.
 */
class ProductMainCategoryController extends Controller {

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
     * Lists all ProductMainCategory models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProductMainCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductMainCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductMainCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ProductMainCategory();

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
     * Updates an existing ProductMainCategory model.
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
     * Deletes an existing ProductMainCategory model.
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

    public function actionAjaxcreate() {
        $model = new ProductMainCategory();
        if (Yii::$app->request->post()) {
            $model->name = Yii::$app->request->post()['name'];
            $model->canonical_name = Yii::$app->request->post()['canonical_name'];
            $model->name_arabic = Yii::$app->request->post()['name_arabic'];
            $model->comments = Yii::$app->request->post()['comments'];
            $model->status = Yii::$app->request->post()['status'];
            if (Yii::$app->SetValues->Attributes($model) && $model->save()) {
                echo json_encode(array("con" => "1", 'id' => $model->id, 'name' => $model->name)); //Success
                exit;
            } else {
                $array = $model->getErrors();
                $error = isset($array['canonical_name']['0']) ? $array['canonical_name']['0'] : 'Internal error';

                //                    var_dump($model->getErrors());
                echo json_encode(array("con" => "2", 'error' => $error));
//                echo '2';
                exit;
            }
        }
        return $this->renderAjax('ajaxcreate', [
                    'model' => $model,
        ]);
    }

    /**
     * Finds the ProductMainCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductMainCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProductMainCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

//    public function actionCanonical() {
//        if (yii::$app->request->isAjax) {
//            $canonical = Yii::$app->request->post()['canonical'];
//            $model = ProductMainCategory::find()->where(['canonical_name' => $canonical])->one();
//            if ($model) {
//                echo json_encode(array("con" => "2", 'error' => 'Canonical Name "' . $canonical . '" has already been taken.')); //Failed
//                exit;
//            } else {
//                echo json_encode(array("con" => "1", 'error' => 'Success')); //Success
//                exit;
//            }
//        }
//    }

    public function actionValidate() {
        $model = new ProductMainCategory();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

}
