<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\AdminUsers;
use common\models\ForgotPasswordTokens;
use common\models\AdminPost;
use common\models\NotificationViewStatus;

/**
 * Site controller
 */
class SiteController extends Controller {

        /**
         * @inheritdoc
         */
        public function behaviors() {
                return [
                    'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                                [
                                'actions' => ['login', 'error', 'index', 'home', 'forgot', 'new-password', 'exception', 'notifications'],
                                'allow' => true,
                            ],
                                [
                                'actions' => ['logout', 'index', 'forgot'],
                                'allow' => true,
                                'roles' => ['@'],
                            ],
                        ],
                    ],
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'logout' => ['post'],
                        ],
                    ],
                ];
        }

        /**
         * @inheritdoc
         */
        public function actions() {
                return [
                    'error' => [
                        'class' => 'yii\web\ErrorAction',
                    ],
                ];
        }

        /**
         * Displays homepage.
         *
         * @return string
         */
        public function actionIndex() {
                if (!Yii::$app->user->isGuest) {
                        return $this->redirect(array('site/home'));
                }
                $this->layout = 'adminlogin';

                $model = new AdminUsers();
                $model->scenario = 'login';
                if ($model->load(Yii::$app->request->post()) && $model->login() && $this->setSession()) {

                        return $this->redirect(array('site/home'));
                } else {
                        return $this->render('login', [
                                    'model' => $model,
                        ]);
                }
        }

        public function setSession() {
                $post = AdminPost::findOne(Yii::$app->user->identity->post_id);

                Yii::$app->session['post'] = $post->attributes;
                return true;
        }

        public function actionHome() {
                if (isset(Yii::$app->user->identity->id)) {
                        if (Yii::$app->user->isGuest) {
                                return $this->redirect(array('site/index'));
                        }
                        $products = \common\models\ProductVendor::find()->where(['<', 'qty', 3])->all();
                        return $this->render('index', [
                                    'products' => $products]);
                } else {
                        throw new \yii\web\HttpException(2000, 'Session Expired.');
                }
        }

        public function actionLogin() {
                if (!Yii::$app->user->isGuest) {
                        return $this->redirect(array('site/index'));
                }
                $this->layout = 'adminlogin';
                $model = new AdminUsers();
                $model->scenario = 'login';

                if ($model->load(Yii::$app->request->post()) && $model->login() && $this->setSession()) {

                        return $this->redirect(array('site/home'));
                } else {

                        return $this->render('login', [
                                    'model' => $model,
                        ]);
                }
        }

        /**
         * Logout action.
         *
         * @return string
         */
        public function actionLogout() {
                Yii::$app->user->logout();
                unset(Yii::$app->session['post']);
                return $this->redirect('index');
        }

        public function actionForgot() {
                $this->layout = 'adminlogin';
                $model = new AdminUsers();
                $status = 0;
                if ($model->load(Yii::$app->request->post())) {
                        $check_exists = AdminUsers::find()->where("user_name = '" . $model->user_name . "' OR email = '" . $model->user_name . "'")->one();

                        if (!empty($check_exists)) {
                                $token_value = $this->tokenGenerator();
                                $token = $check_exists->id . '_' . $token_value;
                                $val = base64_encode($token);
                                $token_model = new ForgotPasswordTokens();
                                $token_model->user_id = $check_exists->id;
                                $token_model->token = $token_value;
                                $token_model->save();
                                $this->sendMail($val, $check_exists);
                                $status = 1;
                                Yii::$app->getSession()->setFlash('success', 'A mail has been sent');
                        } else {
                                Yii::$app->getSession()->setFlash('error', 'Invalid username');
                        }
                        return $this->render('forgot-password', [
                                    'model' => $model,
                                    'status' => $status,
                        ]);
                } else {
                        return $this->render('forgot-password', [
                                    'model' => $model,
                                    'status' => $status,
                        ]);
                }
        }

        public function tokenGenerator() {

                $length = rand(1, 1000);
                $chars = array_merge(range(0, 9));
                shuffle($chars);
                $token = implode(array_slice($chars, 0, $length));
                return $token;
        }

        public function sendMail($val, $model) {

                $to = $model->email;
                $subject = 'Change password';
                $message = $this->renderPartial('forgot_mail', ['model' => $model, 'val' => $val]);
// To send HTML mail, the Content-type header must be set
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
                        "From: 'info@perfumedunia.com";
                mail($to, $subject, $message, $headers);
        }

        public function actionNewPassword($token) {
                $this->layout = 'adminlogin';
                $data = base64_decode($token);
                $values = explode('_', $data);
                $token_exist = ForgotPasswordTokens::find()->where("user_id = " . $values[0] . " AND token = " . $values[1])->one();
                if (!empty($token_exist)) {
                        $model = AdminUsers::find()->where("id = " . $token_exist->user_id)->one();
                        if (Yii::$app->request->post()) {
                                if (Yii::$app->request->post('new-password') == Yii::$app->request->post('confirm-password')) {
                                        Yii::$app->getSession()->setFlash('success', 'password changed successfully');
                                        $model->password = Yii::$app->security->generatePasswordHash(Yii::$app->request->post('confirm-password'));
                                        $model->update();
                                        $token_exist->delete();
                                        $this->redirect('index');
                                } else {
                                        Yii::$app->getSession()->setFlash('error', 'password mismatch  ');
                                }
                        }
                        return $this->render('new-password', [
                                    'model' => $model
                        ]);
                } else {

                }
        }

        public function actionException() {
                return $this->render('exception');
        }

        public function actionNotifications($id = null) {
                if (!empty($id)) {
                        $new_notifications = NotificationViewStatus::find()->where(['id' => $id])->one();
                        $history_model = \common\models\History::find()->where(['id' => $new_notifications->history_id])->one();
                        $master_history = \common\models\MasterHistoryType::findOne($history_model->history_type);
                        $new_notifications->view_status = 1;
                        $new_notifications->update();
                        if (isset($master_history->link)) {
                                $this->redirect(\Yii::$app->homeUrl . $master_history->link);
                        }
                } else {
                        $new_notifications = NotificationViewStatus::find()->where(['user_type' => 1, 'user_id' => Yii::$app->user->identity->id, 'view_status' => 0])->orderBy(['id' => SORT_DESC])->all();
                        return $this->render('notifications', [
                                    'new_notifications' => $new_notifications,
                        ]);
                }
        }

}
