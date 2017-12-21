<?php

namespace vendorend\modules\stock\controllers;

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
//        $product_array = [];
                $from = '';
                $to = '';
                $searchModel = new StockHistorySearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $prdctvendor = \common\models\ProductVendor::find()->where(['vendor_id' => Yii::$app->user->identity->id])->all();
                if (isset($_GET['StockHistorySearch']['productvendor_id']) && $_GET["StockHistorySearch"]["productvendor_id"] != '') {
                        $prdctvendor = \common\models\ProductVendor::find()->where(['product_id' => $_GET['StockHistorySearch']['productvendor_id'], 'vendor_id' => Yii::$app->user->identity->id])->all();
                }
                foreach ($prdctvendor as $value) {
                        $product_array[] = $value->id;
                }
                $dataProvider->query->andWhere(['in', 'productvendor_id', $product_array])->all();
                return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'from' => $from,
                            'to' => $to,
                ]);
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
