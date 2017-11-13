<?php

namespace backend\modules\reports\controllers;

use Yii;
use common\models\OrderMasterSearch;
use common\models\OrderDetailsSearch;

class OrdersController extends \yii\web\Controller {

    public function actionIndex() {

        $searchModel = new OrderMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (isset($_GET['OrderMasterSearch']['createdFrom'])) {
            $from = $_GET['OrderMasterSearch']['createdFrom'];
        } else {
            $from = '';
        }
        if (isset($_GET['OrderMasterSearch']['createdTo'])) {
            $to = $_GET['OrderMasterSearch']['createdTo'];
        } else {
            $to = '';
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'from' => $from,
                    'to' => $to,
        ]);
    }

    public function actionItemReport() {

        $searchModel = new OrderDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (isset($_GET['OrderDetailsSearch']['createdFrom'])) {
            $from = $_GET['OrderDetailsSearch']['createdFrom'];
        } else {
            $from = '';
        }
        if (isset($_GET['OrderDetailsSearch']['createdTo'])) {
            $to = $_GET['OrderDetailsSearch']['createdTo'];
        } else {
            $to = '';
        }
        $item_data = $dataProvider->models;
        return $this->render('item_report', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'from' => $from,
                    'to' => $to,
                    'item_data' => $item_data,
        ]);
    }

}
