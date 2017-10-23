<?php

namespace backend\controllers;

class ProductAjaxController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

}
