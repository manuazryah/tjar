<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\SetLanguage;
use common\models\User;
use common\models\ForgotPassword;

/**
 * Site controller
 */
class AjaxController extends Controller {

        public function beforeAction($action) {
                $this->enableCsrfValidation = false;
                return parent::beforeAction($action);
        }

        public function actionLanguage() {
                SetLanguage::SetLanguage($_POST['language']);
        }

        public function actionEmailCheck() {
                if (yii::$app->request->isAjax) {
                        $email = $_POST['email'];
                        $user = User::find()->where(['email' => $email])->one();
                        if (empty($user)) {
                                echo 1;
                        } else {
                                echo 0;
                        }
                }
        }

        public function actionStreets() {
                if (Yii::$app->request->isAjax) {
                        $street_id = $_POST['id'];
                        $street_datas = \common\models\Street::findAll(['id' => $street_id]);
                        $options = '<option value="">-Choose a Street-</option>';
                        foreach ($street_datas as $street_data) {
                                $options .= "<option value='" . $street_data->id . "'>" . $street_data->street_name . "</option>";
                        }

                        echo $options;
                }
        }

        public function actionRemoveLoginSession() {
                if (Yii::$app->request->isAjax) {
                        if (isset(Yii::$app->session['log-return'])) {
                                unset(Yii::$app->session['log-return']);
                        }
                        echo 1;
                }
        }

        public function actionForgot() {
                if (Yii::$app->request->isAjax) {
                        $msg = '';
                        $data_html = '';
                        $check_exists = User::find()->where(['email' => Yii::$app->request->post('email')])->orWhere(['mobile_number' => Yii::$app->request->post('email')])->one();
                        if (!empty($check_exists)) {
                                $token_value = $this->tokenGenerator();
                                $token_model = new ForgotPassword();
                                $token_model->user_id = $check_exists->id;
                                $token_model->token = $token_value;
                                $token_model->type = 1;
                                if ($token_model->save()) {
//                    $this->sendMail($check_exists);
//                    $this->sendSMS($check_exists);
                                        $data_html = $this->renderPartial('_form_forgot', [
                                            'token_model' => $token_model
                                        ]);
                                        $msg = 'OTP sent to Mobile/Email';
                                        $err_code = 1;
                                }
                        } else {
                                $msg = '<p style="font-size: 12px;color: red;padding-left: 18px;">Invalid Email/Mobile Number</p>';
                                $err_code = 0;
                        }
                        $arr_variable = array('err_code' => $err_code, 'msg' => $msg, 'html_data' => $data_html);
                        $data['result'] = $arr_variable;
                        echo json_encode($data);
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

                $message = Yii::$app->mailer->compose('forgot_mail', ['model' => $model, 'val' => $val]) // a view rendering result becomes the message body here
                        ->setFrom('no-replay@coralperfumes.com')
                        ->setTo($model->email)
                        ->setSubject('Change Password');
                echo $message;
                exit;
//        $message->send();
                return TRUE;
        }

        public function actionOtpCheck() {
                if (yii::$app->request->isAjax) {
                        $otp = $_POST['otp'];
                        $result = ForgotPassword::find()->where(['token' => $otp])->one();
                        if (empty($result)) {
                                echo 1;
                        } else {
                                echo 0;
                        }
                }
        }

        public function actionResendOtp() {
                if (Yii::$app->request->isAjax) {
                        $user_exists = User::find()->where(['id' => Yii::$app->request->post('data_val')])->one();
                        $check_exists = ForgotPassword::find()->where(['user_id' => Yii::$app->request->post('data_val')])->one();
//            if (!empty($check_exists)) {
//                $this->sendMail($val, $check_exists);
//            }
                }
        }

}
