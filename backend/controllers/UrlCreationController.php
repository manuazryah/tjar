<?php

namespace backend\controllers;

use yii;
use common\models\ProductFeatures;
use yii\helpers\Json;
use common\models\ProductSubCategory;
use common\models\Features;

class UrlCreationController extends \yii\web\Controller {

	public function actionIndex() {
//		return $this->render('index');
		return $this->renderAjax('index', [
		]);
	}

	public function actionCategory() {
		if (yii::$app->request->isAjax) {
			$categ_id = $_POST['categ_id'];
			$type = $_POST['type'];
			if ($type == 1 && !empty($categ_id)) {
				$category_model = \common\models\ProductCategory::findOne(['id' => $categ_id]);
				$main_model = \common\models\ProductMainCategory::findOne(['id' => $category_model->category_id]);
				$result = ['main_categ_id' => $category_model->category_id, 'canonical_name' => $category_model->canonical_name, 'main_categ_cano_name' => $main_model->canonical_name, 'category_id' => $categ_id];
			} elseif ($type == 2 && !empty($categ_id)) {

				$sub_category_model = \common\models\ProductSubCategory::findOne(['id' => $categ_id]);

				$category_model = \common\models\ProductCategory::findOne(['id' => $sub_category_model->category_id]);
				$main_model = \common\models\ProductMainCategory::findOne(['id' => $sub_category_model->main_category_id]);
				$result = ['main_categ_id' => $main_model->id, 'main_categ_cano_name' => $main_model->canonical_name, 'category_id' => $category_model->id, 'categ_cano_name' => $category_model->canonical_name, 'sub_categ_id' => $sub_category_model->id, 'sub_categ_cano_name' => $sub_category_model->canonical_name];
//				$result = ['main_categ_id' => $main_model->id, 'canonical_name' => $category_model->canonical_name, 'main_categ_cano_name' => $main_model->canonical_name, 'category_id' => $category_model->category_id, 'sub_category_id' => $categ_id, 'sub_categ_can_name' => $category_model->canonical_name];
			}
//			if (!empty($category_model) && !empty($main_model)) {
//				$result = ['main_categ_id' => $category_model->category_id, 'canonical_name' => $category_model->canonical_name, 'main_categ_cano_name' => $main_model->canonical_name, 'category_id' => $category_model->id];
//			} else {
//				$result = '';
//			}
			echo json_encode($result);
		}
	}

	public function actionFeatures() {
		if (yii::$app->request->isAjax) {
			$categ_id = $_POST['categ_id'];
			$type = $_POST['type'];
			if (!empty($categ_id) && $type == 1) {
				$features = ProductFeatures::find()->where(['category' => $categ_id, 'status' => 1])->select(['id', 'specification'])->all();
				$val .= "<option value=''>Select Sub Category</option>";
				if ($features) {
					foreach ($features as $catgry) {
						$val .= "<option value='" . $catgry->id . "'>" . $catgry->specification0->filter_tittle . "</option>";
					}

					echo json_encode(array("con" => "1", 'val' => $val)); //Success
					exit;
				} else {
					echo json_encode(array("con" => "1", 'val' => $val)); //No Return
					exit;
				}
			} elseif (!empty($categ_id) && $type == 2) {
				$sub_categ_id = $categ_id;
				$sub_categ_model = ProductSubCategory::findOne(['id' => $sub_categ_id]);
				$category = $sub_categ_model->category_id;
				$features = ProductFeatures::find()->where(['category' => $category, 'subcategory' => $sub_categ_id, 'status' => 1])->select(['id', 'specification'])->all();

				$val .= "<option value=''>Select Filters</option>";
				if ($features) {
					foreach ($features as $catgry) {
						$val .= "<option value='" . $catgry->id . "'>" . $catgry->specification0->filter_tittle . "</option>";
					}

					echo json_encode(array("con" => "1", 'val' => $val)); //Success
					exit;
				} else {
					echo json_encode(array("con" => "1", 'val' => $val)); //No Return
					exit;
				}
			} else {
				echo 1; //Value Not Setted
				exit;
			}
		}
	}

	public function actionFilterDatas() {
		if (yii::$app->request->isAjax) {
			$product_feature_model = ProductFeatures::findOne(['id' => $_POST['filterid']]);
			if (!empty($product_feature_model)) {
				$feature_model = Features::findOne(['id' => $product_feature_model->specification]);
				if (!empty($feature_model)) {
					$model_name = $feature_model->model_name;
					$field_name = $feature_model->tablevalue__name;
					if (!empty($_POST['sub_categ']))
						$datas = $model_name::find()->where(['category' => $_POST['categ'], 'subcategory' => $_POST['sub_categ']])->all();
					else {
						$datas = $model_name::find()->where(['category' => $_POST['categ']])->all();
					}
					$val .= "<option value=''>Select Options</option>";
					if ($datas) {
						foreach ($datas as $catgry) {
							$val .= "<option filtercateg='" . $feature_model->canonical_name . "' value='" . $catgry->canonical_name . "'>" . $catgry->$field_name . "</option>";
						}

						echo json_encode(array("con" => "1", 'val' => $val, 'filter_canonical_name' => $feature_model->canonical_name)); //Success
						exit;
					} else {
						echo json_encode(array("con" => "1", 'val' => $val, 'filter_canonical_name' => $feature_model->canonical_name)); //No Return
						exit;
					}
				}
			}
			echo 1; //Value Not Setted
			exit;
		}
	}

	public function actionSearchTags() {
		if (yii::$app->request->isAjax) {
			if (yii::$app->request->isAjax) {
				$categ_id = $_POST['categ_id'];
				$type = $_POST['type'];
				if (!empty($categ_id) && $type == 1) {
					$tags = \common\models\SearchTag::find()->where(['category' => $categ_id, 'status' => 1])->all();
					$val .= "<option value=''>Select Tag</option>";
					if ($tags) {
						foreach ($tags as $catgry) {
							$val .= "<option value='" . $catgry->canonical_name . "'>" . $catgry->tag_name . "</option>";
						}
						echo json_encode(array("con" => "1", 'val' => $val)); //Success
						exit;
					} else {
						echo json_encode(array("con" => "1", 'val' => $val)); //No Return
						exit;
					}
				} else {
					echo 1; //Value Not Setted
					exit;
				}
			}
		}
	}

}
