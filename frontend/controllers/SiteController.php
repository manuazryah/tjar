<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\ContactForm;
use common\models\User;
use common\models\Slider;
use common\models\HomeManagement;

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
                        'only' => ['logout', 'signup', 'new-password'],
                        'rules' => [
                                [
                                'actions' => ['signup', 'new-password'],
                                'allow' => true,
                                'roles' => ['?'],
                            ],
                                [
                                'actions' => ['logout'],
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
                    'captcha' => [
                        'class' => 'yii\captcha\CaptchaAction',
                        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                    ],
                ];
        }

        /**
         * Displays homepage.
         *
         * @return mixed
         */
        public function actionIndex() {
                $sliders = Slider::find()->where(['status' => 1])->all();
                $deals = HomeManagement::find()->where(['id' => 1])->one();
                $home_datas = HomeManagement::find()->where(['<>', 'id', 1])->andWhere(['status' => 1])->orderBy(['sort_order' => SORT_ASC])->all();
                return $this->render('index', [
                            'sliders' => $sliders,
                            'deals' => $deals,
                            'home_datas' => $home_datas,
                ]);
        }

        /**
         * Logs in a user.
         *
         * @return mixed
         */
        public function actionLogin($go = null) {
                if (!Yii::$app->user->isGuest) {
                        return $this->goHome();
                }
                $modellogin = new LoginForm();
                if ($modellogin->load(Yii::$app->request->post()) && $modellogin->login()) {
                        $user = User::findOne(Yii::$app->user->identity->id);
                        $user->online_status = 1;
                        $user->update();
                        return $this->redirect($go);
                } else {
                        Yii::$app->session['log-return'] = 1;
                        return $this->redirect(Yii::$app->request->referrer);
                }
        }

        /**
         * Logs out the current user.
         *
         * @return mixed
         */
        public function actionLogout() {
                $user = User::findOne(Yii::$app->user->identity->id);
                if (Yii::$app->user->logout()) {
                        unset(Yii::$app->session['log-return']);
                        $user->online_status = 0;
                        $user->update();
                }
                return $this->goHome();
        }

        /**
         * Displays contact page.
         *
         * @return mixed
         */
        public function actionContact() {
                $model = new ContactForm();
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                        if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
                        } else {
                                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
                        }

                        return $this->refresh();
                } else {
                        return $this->render('contact', [
                                    'model' => $model,
                        ]);
                }
        }

        /**
         * Displays about page.
         *
         * @return mixed
         */
        public function actionAbout() {
                return $this->render('about');
        }

        /**
         * Signs user up.
         *
         * @return mixed
         */
        public function actionRegister($go = null) {
                $modelregister = new User();
                if ($modelregister->load(Yii::$app->request->post())) {
                        if ($user = $modelregister->signup()) {
                                if (Yii::$app->getUser()->login($user)) {
                                        $user = User::findOne(Yii::$app->user->identity->id);
                                        $user->online_status = 1;
                                        $user->update();
                                        $message = $this->renderPartial('response-mail', ['model' => $user]);
                                        Yii::$app->SetValues->Email($user->email, 'Welcome to Tjar', $message);
                                        return $this->redirect($go);
//                    return $this->goHome();
                                }
                        }
                }

                return $this->render('signup', [
                            'model' => $model,
                ]);
        }

        /**
         * Requests password reset.
         *
         * @return mixed
         */
        public function actionRequestPasswordReset() {
                $model = new PasswordResetRequestForm();
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                        if ($model->sendEmail()) {
                                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                                return $this->goHome();
                        } else {
                                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
                        }
                }

                return $this->render('requestPasswordResetToken', [
                            'model' => $model,
                ]);
        }

        /**
         * Resets password.
         *
         * @param string $token
         * @return mixed
         * @throws BadRequestHttpException
         */
        public function actionResetPassword($token) {
                try {
                        $model = new ResetPasswordForm($token);
                } catch (InvalidParamException $e) {
                        throw new BadRequestHttpException($e->getMessage());
                }

                if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
                        Yii::$app->session->setFlash('success', 'New password saved.');

                        return $this->goHome();
                }

                return $this->render('resetPassword', [
                            'model' => $model,
                ]);
        }

        /**
         * Resets password.
         *
         * @param string $token
         * @return mixed
         * @throws BadRequestHttpException
         */
        public function actionNewPassword() {
                $token = \common\models\ForgotPassword::find()->where(['token' => Yii::$app->request->post('forgot_otp')])->one();
                $user = User::find()->where(['id' => $token->user_id])->one();
                $user->password_hash = Yii::$app->security->generatePasswordHash(Yii::$app->request->post('reset_passwd'));
                if ($user->update()) {
                        $token->delete();
                        $modellogin = new LoginForm();
                        $modellogin->username = $user->email;
                        $modellogin->password = Yii::$app->request->post('reset_passwd');
                        if ($modellogin->login()) {
                                return $this->redirect(Yii::$app->request->referrer);
                        } else {
                                Yii::$app->session['log-return'] = 1;
                                return $this->redirect(Yii::$app->request->referrer);
                        }
                }
        }

        public function sendResponseMail($model) {

                $message = Yii::$app->mailer->compose('response-mail', ['model' => $model]) // a view rendering result becomes the message body here
                        ->setFrom('no-replay@tjar.com')
                        ->setTo($model->email)
                        ->setSubject('Welcome to Tjar');
                $message->send();
                return TRUE;
        }

        public function actionMail() {
                return $this->renderPartial('mail');
        }

        public function actionLoginstatus() {
                if (yii::$app->request->isAjax) {
                        if (isset(Yii::$app->user->identity->id)) {
                                echo '1';
                                exit;
                        } else {
                                echo '0';
                                exit;
                        }
                }
        }

}
