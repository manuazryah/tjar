<?php

namespace backend\modules\user\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

        public function beforeAction($action) {
                if (!parent::beforeAction($action)) {
                        return false;
                }
                if (Yii::$app->user->isGuest) {
                        $this->redirect(['/site/index']);
                        return false;
                }
                if (Yii::$app->session['post']['users'] != 1) {
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
         * Lists all User models.
         * @return mixed
         */
        public function actionIndex() {
                $searchModel = new UserSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->query->orderBy(['online_status' => SORT_DESC]);

                return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Displays a single User model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id = null, $order_status = NULL) {
                $searchModel = new \common\models\OrderMasterSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//                if ($order_status == 1) {
//                        $dataProvider->query->andWhere(['admin_status' => 0]);
//                } elseif ($order_status == 2) {
//                        $dataProvider->query->andWhere(['admin_status' => 1]);
//                }
                $dataProvider->query->andWhere(['user_id' => $id]);

                return $this->render('view', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'id' => $id,
                            'order_status' => $order_status,
                ]);
        }

        public function actionOrderDetails($id) {
                $order_master = \common\models\OrderMaster::findOne($id);
                $searchModel = new \common\models\OrderDetailsSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->query->andWhere(['master_id' => $id]);

                return $this->render('order-details', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'id' => $id,
                            'user' => $order_master->user_id,
                ]);
        }

        /**
         * Creates a new User model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate() {
                $model = new User();
                $model->setScenario('adduser');
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                        $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
                        $model->dob = date('Y-m-d', strtotime($model->dob));
                        $model->save();
                        return $this->redirect(['index']);
                }
                return $this->render('create', [
                            'model' => $model,
                ]);
        }

        /**
         * Updates an existing User model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actionUpdate($id) {
                $model = $this->findModel($id);
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                        $model->dob = date('Y-m-d', strtotime($model->dob));
                        $model->save();
                        return $this->redirect(['index']);
                }
                return $this->render('update', [
                            'model' => $model,
                ]);
        }

        /**
         * Deletes an existing User model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDelete($id) {
                $this->findModel($id)->delete();

                return $this->redirect(['index']);
        }

        /**
         * Finds the User model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return User the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id) {
                if (($model = User::findOne($id)) !== null) {
                        return $model;
                } else {
                        throw new NotFoundHttpException('The requested page does not exist.');
                }
        }

        public function actionStatusUpdate() {
                $user_id = $_POST['id'];
                $user_details = User::findOne($user_id);
                if ($user_details->status == 1)
                        $user_details->status = 0;
                else
                        $user_details->status = 1;
                $user_details->save();
        }

        /**
         * Active User
         * @param integer $id
         * @return mixed
         */
        public function actionApprove($id) {
                $model = $this->findModel($id);
                $model->status = 1;
                $model->save();
                return $this->redirect(['index']);
        }

        /**
         * Disable User .
         * @param integer $id
         * @return mixed
         */
        public function actionDisable($id) {
                $model = $this->findModel($id);
                $model->status = 0;
                $model->save();
                return $this->redirect(['index']);
        }

}
