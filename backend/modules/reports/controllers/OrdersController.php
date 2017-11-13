<?php

namespace backend\modules\reports\controllers;

class OrdersController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
