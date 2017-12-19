<?php

namespace backend\modules\vendors\controllers;

use common\models\ProductVendorSearch;
use Yii;

class FullfilledProductsController extends \yii\web\Controller {

        public function actionIndex($vendor_status = null, $admin_status = null, $expiry = NULL, $soldout = NULL) {
                $searchModel = new ProductVendorSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                if (Yii::$app->request->queryParams['ProductVendorSearch']['product_id'] != NULL || Yii::$app->request->queryParams['ProductVendorSearch']['vendor_id'] != NULL) {
                        $search_status = 1;
                } else {
                        $search_status = 0;
                }
                $dataProvider->query->andWhere(['full_fill' => 1]);
                if (!empty($vendor_status)) {
                        $dataProvider->query->andWhere(['full_fill' => 1, 'admin_status' => 2]);
                        $dataProvider->query->andWhere(['vendor_status' => $vendor_status]);
                } elseif (!empty($admin_status)) {
                        $dataProvider->query->andWhere(['admin_status' => $admin_status]);
                } elseif ($expiry == 1) {
                        $dataProvider->query->andWhere(['and', 'expiry_date<= NOW()']);
                } elseif ($soldout == 1) {
                        $dataProvider->query->andWhere(['and', 'qty<= 0']);
                }

                return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'vendor_status' => $vendor_status,
                            'admin_status' => $admin_status,
                            'expiry' => $expiry,
                            'soldout' => $soldout,
                            'search_status' => $search_status,
                ]);
        }

}
