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
use frontend\models\SignupForm;

/**
 * Site controller
 */
class AjaxController extends Controller {

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionSs() {
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

}
