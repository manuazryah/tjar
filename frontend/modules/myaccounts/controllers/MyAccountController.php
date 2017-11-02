<?php

namespace frontend\modules\myaccounts\controllers;

use yii;
use common\models\UserAddress;
use common\models\User;

class MyAccountController extends \yii\web\Controller {

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionAddress($id = NULL) {
        $error_return = 0;
        $user_data = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        $user_address = UserAddress::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        if (!empty($id)) {
            $model = UserAddress::findOne($id);
            $error_return = 2;
        } else {
            $model = new UserAddress();
        }
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $model->user_id = Yii::$app->user->identity->id;
            if (empty($user_address)) {
                $model->default_address = 1;
            } else {
                $user_exist = UserAddress::findOne(['user_id' => Yii::$app->user->identity->id, 'default_address' => 1]);
                if (!empty($user_exist)) {
                    if ($model->default_address != 0) {
                        $user_exist->default_address = 0;
                        $user_exist->update();
                    }
                }
            }
            if ($model->validate() && $model->save()) {
                $model = new UserAddress();
                $error_return = 0;
                return $this->redirect('address');
            } else {
                $error_return = 1;
            }
        }
        return $this->render('address', [
                    'model' => $model,
                    'user_data' => $user_data,
                    'error_return' => $error_return,
                    'user_address' => $user_address,
        ]);
    }

    public function actionSetDefault($id) {
        $model = UserAddress::findOne($id);
        $default_exist = UserAddress::findOne(['user_id' => Yii::$app->user->identity->id, 'default_address' => 1]);
        if (!empty($default_exist)) {
            $default_exist->default_address = 0;
            $default_exist->update();
        }
        $model->default_address = 1;
        $model->save();
        return $this->redirect('address');
    }

    public function actionMyOrders() {
        return $this->render('my_order');
    }

    public function actionWishList() {
        return $this->render('wish_list');
    }

    public function actionReviews() {
        return $this->render('reviews');
    }

    public function actionAccountDetails() {
        $user_details = User::findOne(Yii::$app->user->identity->id);
        return $this->render('account_details', [
                    'user_details' => $user_details,
        ]);
    }

    public function actionDelete($id) {
        $model = UserAddress::findOne($id);
        $model->delete();
        return $this->redirect('address');
    }

    public function actionEditPersonalInfo() {
        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user_details = User::findOne(Yii::$app->user->identity->id);
            $user_details->first_name = $model->first_name;
            $user_details->last_name = $model->last_name;
            $user_details->gender = $model->gender;
            $user_details->dob = date('Y-m-d', strtotime($model->dob));
            $user_details->save();
        }
        return $this->redirect('account-details');
    }

    public function actionChangeEmailAddress() {
        if (yii::$app->request->isAjax) {
            $email = $_POST['email'];
            $user = User::findOne(Yii::$app->user->identity->id);
            $user->email = $email;
            $user->save();
            echo 1;
        }
    }

    public function actionChangePassword() {
        if (yii::$app->request->isAjax) {
            $err_code = 0;
            $model = User::findOne(Yii::$app->user->identity->id);
            if (Yii::$app->getSecurity()->validatePassword(Yii::$app->request->post('old_password'), $model->password_hash)) {
                if (Yii::$app->request->post('new_password') == Yii::$app->request->post('confirn_password')) {
                    $model->password_hash = Yii::$app->security->generatePasswordHash(Yii::$app->request->post('confirn_password'));
                    $model->update();
                    $msg = 'Password changed successfully';
                    $err_code = 1;
                } else {
                    $msg = 'Password mismatch';
                }
            } else {
                $msg = 'Incorrect Old Password';
            }
            $arr_variable = array('err_code' => $err_code, 'msg' => $msg);
            $data['result'] = $arr_variable;
            echo json_encode($data);
        }
    }

}
