<?php

namespace backend\modules\product\controllers;

use Yii;
use common\models\SearchTag;
use common\models\SearchTagSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SearchTagController implements the CRUD actions for SearchTag model.
 */
class SearchTagController extends Controller {

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
         * Lists all SearchTag models.
         * @return mixed
         */
        public function actionIndex() {
                $searchModel = new SearchTagSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'model' => $model,
                ]);
        }

        /**
         * Displays a single SearchTag model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id) {
                return $this->render('view', [
                            'model' => $this->findModel($id),
                ]);
        }

        /**
         * Creates a new SearchTag model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate() {
                $model = new SearchTag();

                if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate() && $model->save()) {
                        Yii::$app->getSession()->setFlash('success', 'Search Tag Created Successfully');
                        return $this->redirect(['index']);
                } else {
                        return $this->renderAjax('create', [
                                    'model' => $model,
                        ]);
                }
        }

        /**
         * Updates an existing SearchTag model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actionUpdate($id) {
                $model = $this->findModel($id);

                if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate() && $model->save()) {
                        Yii::$app->getSession()->setFlash('success', 'Searc Tag Updated Successfully');
                        return $this->redirect(['index']);
                } else {
                        return $this->renderAjax('update', [
                                    'model' => $model,
                        ]);
                }
        }

        /**
         * Deletes an existing SearchTag model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDel($id) {
                if ($this->findModel($id)->delete()) {
                        Yii::$app->getSession()->setFlash('error', 'Search Tag Removed Successfully');
                }

                return $this->redirect(['index']);
        }

        public function actionAjaxcreate() {
                $model = new SearchTag();
                if (Yii::$app->request->post()) {
                        $model->category = Yii::$app->request->post()['category'];
                        $model->subcategory = Yii::$app->request->post()['subcat'];
                        $model->tag_name = Yii::$app->request->post()['tag_name'];
                        $model->tag_name_arabic = Yii::$app->request->post()['tag_name_arabic'];
                        $model->status = Yii::$app->request->post()['status'];
                        $model->canonical_name = Yii::$app->request->post()['canonical_name'];
                        if (Yii::$app->SetValues->Attributes($model) && $model->save()) {
                                echo json_encode(array("con" => "1", 'id' => $model->id, 'tag' => $model->tag_name)); //Success
                                exit;
                        } else {
//                    var_dump($model->getErrors());
                                echo '2';
                                exit;
                        }
                }
                return $this->renderAjax('ajaxcreate', [
                            'model' => $model,
                ]);
        }

        /**
         * Finds the SearchTag model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return SearchTag the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id) {
                if (($model = SearchTag::findOne($id)) !== null) {
                        return $model;
                } else {
                        throw new NotFoundHttpException('The requested page does not exist.');
                }
        }

        public function actionCanonical() {
                if (yii::$app->request->isAjax) {
                        $canonical = Yii::$app->request->post()['canonical'];
                        $model = SearchTag::find()->where(['canonical_name' => $canonical])->one();
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
