<?php

namespace backend\modules\vendors\controllers;

use common\models\ProductVendorSearch;
use Yii;

class FullfilledProductsController extends \yii\web\Controller {

	public function actionIndex($vendor_status = null, $admin_status = null) {
		$searchModel = new ProductVendorSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andWhere(['full_fill' => 1]);
		if (!empty($vendor_status)) {
			$dataProvider->query->andWhere(['full_fill' => 1, 'admin_status' => 2]);
			$dataProvider->query->andWhere(['vendor_status' => $vendor_status]);
		} elseif (!empty($admin_status)) {
			$dataProvider->query->andWhere(['admin_status' => $admin_status]);
		}

		return $this->render('index', [
			    'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
			    'vendor_status' => $vendor_status,
			    'admin_status' => $admin_status,
		]);
	}

}
