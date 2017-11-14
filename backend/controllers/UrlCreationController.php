<?php

namespace backend\controllers;

use yii;

class UrlCreationController extends \yii\web\Controller {

	public function actionIndex() {
		return $this->render('index');
	}

	public function actionCategory() {
		if (yii::$app->request->isAjax) {
			$categ_id = $_POST['categ_id'];
			$type = $_POST['type'];
			if ($type == 1 && !empty($categ_id)) {
				$category_model = \common\models\ProductCategory::findOne(['id' => $categ_id]);
				$main_model = \common\models\ProductMainCategory::findOne(['id' => $category_model->category_id]);
				$result = ['main_categ_id' => $category_model->category_id, 'canonical_name' => $category_model->canonical_name, 'main_categ_cano_name' => $main_model->canonical_name];
			} elseif ($type == 2 && !empty($categ_id)) {
				$category_model = \common\models\ProductSubCategory::findOne(['id' => $categ_id]);
				$main_model = \common\models\ProductMainCategory::findOne(['id' => $category_model->main_category_id]);
				$result = ['main_categ_id' => $main_model->id, 'canonical_name' => $category_model->canonical_name, 'main_categ_cano_name' => $main_model->canonical_name];
			}
			if (!empty($category_model) && !empty($main_model)) {
				$result = ['main_categ_id' => $category_model->category_id, 'canonical_name' => $category_model->canonical_name, 'main_categ_cano_name' => $main_model->canonical_name];
			} else {
				$result = '';
			}
			echo json_encode($result);
		}
	}

}
