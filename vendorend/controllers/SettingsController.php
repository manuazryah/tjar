<?php

namespace vendorend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Locations;
use yii\helpers\Json;

class SettingsController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionLocations() {

        $model = Locations::find()->where(['status' => 1])->all();
        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    public function actionAddNewLocation() {

        $model = new Locations();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate()) {
            $model->vendor_id = Yii::$app->user->identity->id;
            if ($model->dafault_address != 0) {
                $data_exist = Locations::find()->where(['dafault_address' => 1])->one();
                if (!empty($data_exist)) {
                    $data_exist->dafault_address = 0;
                    $data_exist->update();
                    $model->dafault_address = 1;
                }
            } else {
                $data_exist = Locations::find()->where(['status' => 1])->one();
                if (empty($data_exist)) {
                    $model->dafault_address = 1;
                }
            }
            $model->save();
            return $this->redirect(['locations']);
        } else {
            return $this->render('new_location', [
                        'model' => $model,
            ]);
        }
    }

    public function actionEditLocation($id) {

        $model = Locations::findOne($id);

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate() && $model->save()) {
            return $this->redirect(['locations']);
        }
        return $this->render('new_location', [
                    'model' => $model,
        ]);
    }

    public function actionChangeDefaultAddress() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $model = Locations::find()->where(['id' => $id])->one();
            $data_exist = Locations::find()->where(['dafault_address' => 1])->one();
            $model->dafault_address = 1;
            if ($model->save()) {
                $data_exist->dafault_address = 0;
                $data_exist->update();
                echo $data_exist->id;
            } else {
                echo 0;
            }
        }
    }

    public function actionDeleteAddress() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $model = Locations::find()->where(['id' => $id])->one();
            if (!empty($model->save())) {
                if ($model->delete()) {
                    echo 1;
                }
            } else {
                echo 0;
            }
        }
    }

    public function actionStreets() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $city_id = $parents[0];
                $out = \common\models\Street::getStreetList($city_id);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

}
