<?php

namespace frontend\modules\myaccounts\controllers;

use yii;
use common\models\UserAddress;
use common\models\User;

class MyAccountController extends \yii\web\Controller {

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
//            $model->country_id = 1;
            if (empty($user_address)) {
                $model->default_address = 1;
            } else {
                $user_exist = UserAddress::findOne(['user_id' => Yii::$app->user->identity->id, 'default_address' => 1]);
                if (!empty($user_exist)) {
                    if (isset($model->default_address)) {
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

}
