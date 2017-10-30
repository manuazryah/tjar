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
        $user_data = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        $user_address = UserAddress::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        if (!empty($id)) {
            $model = UserAddress::findOne($id);
        } else {
            $model = new UserAddress();
        }
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate()) {
            $model->user_id = Yii::$app->user->identity->id;
            $model->country_id = 1;
            if (empty($user_address)) {
                $model->default_address = 1;
            } else {
                $user_exist = UserAddress::findOne(['user_id' => Yii::$app->user->identity->id, 'default_address' => 1]);
                if (!empty($user_exist)) {
                    $user_exist->default_address = 0;
                    $user_exist->update();
                }
                $model->default_address = 1;
            }
            $model->save();
            $model = new UserAddress();
        }
        return $this->render('address', [
                    'model' => $model,
                    'user_data' => $user_data,
        ]);
    }

}
