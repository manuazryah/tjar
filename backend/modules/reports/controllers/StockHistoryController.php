<?php

namespace backend\modules\reports\controllers;

use Yii;
use common\models\StockHistory;
use common\models\StockHistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StockHistoryController implements the CRUD actions for StockHistory model.
 */
class StockHistoryController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all StockHistory models.
     * @return mixed
     */
    public function actionIndex() {
        $product_array = [];
        $searchModel = new StockHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (isset($_GET['StockHistorySearch']['productvendor_id']) && $_GET["StockHistorySearch"]["productvendor_id"] != '') {
            $prdctvendor = \common\models\ProductVendor::find()->where(['product_id' => $_GET['StockHistorySearch']['productvendor_id']])->all();
            if (!empty($prdctvendor)) {
                foreach ($prdctvendor as $value) {
                    $product_array[] = $value->id;
    }
    }
                $dataProvider->query->andWhere(['in', 'productvendor_id', $product_array])->all();
        }
        if (isset($_GET['StockHistorySearch']['createdFrom'])) {
            $from = $_GET['StockHistorySearch']['createdFrom'];
        } else {
            $from = '';
        }
        if (isset($_GET['StockHistorySearch']['createdTo'])) {
            $to = $_GET['StockHistorySearch']['createdTo'];
        } else {
            $to = '';
    }
//        $item_data = $dataProvider->models;
//        echo '<pre>';
//        print_r($item_data);exit;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
            ]);
        }

    /**
     * Deletes an existing StockHistory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StockHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StockHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = StockHistory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
