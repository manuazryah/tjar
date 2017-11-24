<?php

namespace vendorend\modules\product\controllers;

use yii;
use common\models\ProductVendor;
use common\models\ProductVendorSearch;
use common\models\OrderDetailsSearch;

class FullfillController extends \yii\web\Controller {

        public function actionIndex($vendor_status = NULL, $admin_status = NULL, $expiry = NULL, $soldout = NULL) {

                $searchModel = new ProductVendorSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                if (!empty($vendor_status)) {
                        $dataProvider->query->andWhere(['vendor_status' => $vendor_status]);
                } elseif (!empty($admin_status)) {
                        $dataProvider->query->andWhere(['admin_status' => $admin_status]);
                } elseif ($expiry == 1) {
                        $dataProvider->query->andWhere(['and', 'expiry_date<= NOW()']);
                } elseif ($soldout == 1) {
                        $dataProvider->query->andWhere(['and', 'qty<= 0']);
                }

                $dataProvider->query->andWhere(['<>', 'full_fill', 0]);
                $dataProvider->query->andWhere(['vendor_id' => \Yii::$app->user->identity->id]);
                return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'vendor_status' => $vendor_status,
                            'admin_status' => $admin_status,
                            'expiry' => $expiry,
                            'soldout' => $soldout,
                ]);
        }

        public function actionOrders() {
                $searchModel = new OrderDetailsSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $fullfilled = ProductVendor::find()->where(['full_fill' => 1, 'vendor_status' => 1])->all();
                $fullfilled_products = array();
                foreach ($fullfilled as $value) {
                        $fullfilled_products[] = $value->id;
                }
                $dataProvider->query->andWhere(['IN', 'product_id', $fullfilled_products]);

                return $this->render('full_fill', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
        }

}
