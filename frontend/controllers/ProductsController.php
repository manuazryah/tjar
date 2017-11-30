<?php

//use Yii;

namespace frontend\controllers;

use yii;
use common\models\Products;
use common\models\ProductsSearch;
use common\models\ProductVendor;
use yii\db\Expression;
use common\models\RecentlyViewed;
use common\models\ProductMainCategory;
use common\models\ProductSubCategory;
use common\models\Filter;
use common\models\ProductCategory;
use common\models\Features;
use common\models\ProductFeatures;
use common\models\ProductVendorSearch;
use common\models\UserComplaints;

class ProductsController extends \yii\web\Controller {

	/**
	 * Displays a Products based on category.
	 * @param category_code $id
	 * @return mixed
	 */
	public function actionIndex($main_categ, $categ = null, $sub_categ = null) {
		$searchModel = new ProductVendorSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->pagination->pageSize = 10;
		$query = explode('&', $_SERVER['QUERY_STRING']);

		$params = array();
		foreach ($query as $param) {
			list($name, $value) = explode('=', $param, 2);
			$params[urldecode($name)][] = urldecode($value);
		}


		$main_category = ProductMainCategory::findOne(['canonical_name' => $params['main_categ'][0]]);
		if (!empty($params['categ'][0])) {
			$category = ProductCategory::findOne(['canonical_name' => $params['categ'][0]]);
		} elseif (!empty($params['sub_categ'][0])) {
			$sub_category = ProductSubCategory::findOne(['canonical_name' => $params['sub_categ'][0]]);
		}
		if (!empty($category)) {
			$products = Products::find()->where(['main_category' => $main_category->id, 'category' => $category->id])->select('id')->asArray()->all();
			$filters = Filter::find()->where(['category' => $category])->select(['features'])->distinct()->all();
		} elseif (!empty($sub_category)) {

			$filters = Filter::find()->where(['subcategory' => $sub_category->id])->select(['features'])->distinct()->all();
			$category = ProductCategory::findOne(['id' => $sub_category->category_id]);
			$products = Products::find()->where(['main_category' => $main_category->id, 'subcategory' => $sub_category->id])->select('id')->asArray()->all();
		}

		$result = $this->Filters($params);

		if ($result[0] == null && $result[1] == 2) {

			foreach ($products as $product) {

				$productids[] = $product['id'];
			}
		} else {

			$productids = $result[0];
		}

		foreach ($params as $key => $value) {

			$price = array('min-range', 'max-range');
			if (in_array($key, $price)) {
				if ($key == 'min-range') {
					$min_value = $value[0];
				} elseif ($key == 'max-range') {
					$max_value = $value[0];
				}
			}
		}

		if (!empty($min_value) && !empty($max_value) && $productids != null) {

			$dataProvider->query->where(['IN', 'product_id', $productids])->andWhere(['between', 'price', $min_value, $max_value]);
//			$vendor_products = \common\models\ProductVendor::find()->where(['IN', 'product_id', $productids])->andWhere(['between', 'price', $min_value, $max_value])->all();
		} elseif ($productids != null) {
			$dataProvider->query->where(['IN', 'product_id', $productids]);
//			$vendor_products = \common\models\ProductVendor::find()->where(['IN', 'product_id', $productids])->all();
		} else {
			$productids = 0;
			$dataProvider->query->where(['IN', 'product_id', $productids]);

//			$vendor_products = null;
//			$vendor_products = \common\models\ProductVendor::find()->where(['IN', 'product_id', $productids])->all();
		}



		return $this->render('index', [
//			    'dataProvider' => $vendor_products,
			    'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
			    'filters' => $filters,
			    'categ' => $category->id,
			    'sub_categ' => $sub_category->id,
			    'main_categ' => $main_category->id,
		]);
	}

	function Filters($data) {
		$flag = 2;
		$main_category = ProductMainCategory::findOne(['canonical_name' => $data['main_categ'][0]]);
		if (!empty($data['categ'][0])) {
			$category = ProductCategory::findOne(['canonical_name' => $data['categ'][0]]);
		} elseif (!empty($data['sub_categ'][0])) {
			$sub_category = ProductSubCategory::findOne(['canonical_name' => $data['sub_categ'][0]]);
		}

		foreach ($data as $key => $value) {

			$unwanted = array("products/index", "main_categ", "categ", "sub_categ", 'min-range', 'max-range', 'page', 'per-page');
			if (!in_array($key, $unwanted)) {
				$flag = 0;

				$features = Features::findOne(['canonical_name' => $key]);

				if (!empty($sub_category)) {
					echo $sub_category->id;
					$product_features = ProductFeatures::find()->where(['specification' => $features->id, 'category' => $sub_category->category_id, 'subcategory' => $sub_category
						    ->id])->select('id')->asArray()->all();
				} else {
					$product_features = ProductFeatures::find()->where(['specification' => $features->id, 'category' => $category->id])->select('id')->asArray()->all();
				}

				foreach ($product_features as $product_feature) {
					$feature_ids [] = $product_feature['id'];
				}

				unset($dat);

				foreach ($value as $val) {

					$datas = \common\models\ProductSpecifications::find()->where(['IN', 'product_feature_id', $feature_ids])->andWhere(['Product_feature_text' => $val])->select('product_id')->asArray()->all();

					foreach ($datas as $data_) {
						$dat [] = $data_['product_id'];
					}
				}
			}
			if (!empty($dat)) {
				$flag = 1;
				if (empty($productids)) {
					$productids = $dat;
				} else {
					$productids = array_intersect($dat, $productids);
				}
			}
		}




//		var_dump($productids);
//
		$result = [$productids, $flag];
		return $result;
	}

	public function actionCategory($id) {
		$searchModel = new ProductSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->where('category =' . $id);
		$category = Category::find()->select('id,category')->where(['status' => 1])->all();
		return $this->render('index', [
			    'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
			    'category' => $category,
		]);
	}

	/**
	 * Displays a Particular Product.
	 * @param prodict_id  $product
	 * @return mixed
	 */
	public function actionProductDetail($product) {
		//   $vendor_id = yii::$app->EncryptDecrypt->Encrypt('decrypt', $a);
		// $vendor_id = yii::$app->EncryptDecrypt->Encrypt('decrypt', $a);
		if (isset(Yii::$app->user->identity->id)) {
			$user_id = Yii::$app->user->identity->id;
		} else {
			$user_id = '';
		}
		$vendor_product = ProductVendor::findOne($product);
		$product_details = Products::findOne($vendor_product->product_id);
		$product_specifications = \common\models\ProductSpecifications::find()->where(['product_id' => $product_details->id])->andWhere(['not', ['product_feature_id' => null]])->all();
		$new_customer_review = new \common\models\CustomerReviews();
		$this->RecentlyViewed($vendor_product);
		$product_reveiws = \common\models\CustomerReviews::find()->where(['product_id' => $vendor_product->id, 'status' => '1'])->all();

		return $this->render('product_detail', [
			    'product_details' => $product_details,
			    'vendor_product' => $vendor_product,
			    'user_id' => $user_id,
			    'product_specifications' => $product_specifications,
			    'new_customer_review' => $new_customer_review,
			    'product_reveiws' => $product_reveiws,
		]);
	}

	/**
	 * Save recently viewed product.
	 * @param product array
	 * if user logged in set user id otherwise set temporary session id
	 */
	public function RecentlyViewed($product) {
		$user_id = '';
		$sessonid = '';
		if (isset(Yii::$app->user->identity->id)) {
			$user_id = Yii::$app->user->identity->id;
			$model = RecentlyViewed::find()->where(['product_id' => $product->id, 'user_id' => $user_id])->one();
		} else {
			if (!isset(Yii::$app->session['temp_user_product']) || Yii::$app->session['temp_user_product'] == '') {
				$milliseconds = round(microtime(true) * 1000);
				Yii::$app->session['temp_user_product'] = $milliseconds;
			}
			$sessonid = Yii::$app->session['temp_user_product'];
			$model = RecentlyViewed::find()->where(['product_id' => $product->id, 'session_id' => Yii::$app->session['temp_user_product']])->one();
		}
		if (empty($model)) {

			$model = new RecentlyViewed();
			$model->user_id = $user_id;
			$model->session_id = $sessonid;
			$model->product_id = $product->id;
			$model->date = date('Y-m-d');
		} else {
			$model->date = date('Y-m-d');
		}
		$model->save();
		return;
	}

	/**
	 * Update recently viewed product.
	 * @param tmperory session for recently viewed product
	 * update session id to corresponding user user id
	 */
	public function actionGetrecentproduct() {
		if (isset(Yii::$app->user->identity->id)) {
			if (isset(Yii::$app->session['temp_user_product'])) {
				$models = RecentlyViewed::find()->where(['session_id' => Yii::$app->session['temp_user_product']])->all();

				foreach ($models as $msd) {
					$data = RecentlyViewed::find()->where(['product_id' => $msd->product_id, 'user_id' => Yii::$app->user->identity->id])->one();
					if (empty($data)) {
						$msd->user_id = Yii::$app->user->identity->id;
						$msd->session_id = '';
						$msd->save();
					} else {
						$data->date = $msd->date;
						if ($data->save()) {
							$msd->delete();
						}
					}
				}
				unset(Yii::$app->session['temp_user_product']);
			}
		}
	}

	/**
	 * Update recently viewed product.
	 * @param tmperory session for recently viewed product
	 * update session id to corresponding user user id
	 */
	public function actionGetwishlistproduct() {
		if (isset(Yii::$app->user->identity->id)) {
			if (isset(Yii::$app->session['temp_wish_list'])) {
				$models = WishList::find()->where(['session_id' => Yii::$app->session['temp_wish_list']])->all();

				foreach ($models as $msd) {
					$data = WishList::find()->where(['product' => $msd->product, 'user_id' => Yii::$app->user->identity->id])->one();
					if (empty($data)) {
						$msd->user_id = Yii::$app->user->identity->id;
						$msd->session_id = '';
						$msd->save();
					} else {
						$data->date = $msd->date;
						if ($data->save()) {
							$msd->delete();
						}
					}
				}
				unset(Yii::$app->session['temp_wish_list']);
			}
		}
	}

	/**
	 * This function will save new customer reviews
	 */
	public function actionAddReview() {

		if (Yii::$app->request->isAjax) {
			$model_review = new \common\models\CustomerReviews();
			if ($model_review->load(Yii::$app->request->post())) {
				$model_review->user_id = Yii::$app->user->identity->id;
				$model_review->review_date = date('Y-m-d');
				$model_review->save();
			}
		}
	}

	public function actionSearchKeyword() {
		if (yii::$app->request->isAjax) {
			$keyword = $_POST['keyword'];
			if ($keyword != '' || !empty($keyword)) {
				$search_tags = \common\models\SearchTag::find()->where(['status' => 1])->andWhere((['LIKE', 'tag_name', $keyword . '%', false]))->all();
				if (count($search_tags) > 0) {
					$values = $this->renderPartial('_product_search', ['products' => $search_tags, 'keyword' => $keyword]);
					echo $values;
				}
			}
		}
	}

	public function actionProductSearch($main_categ = null, $categ = null, $query_search = null) {
		$query = explode('&', $_SERVER['QUERY_STRING']);
		$params = array();
		foreach ($query as $param) {
			list($name, $value) = explode('=', $param, 2);
			$params[urldecode($name)][] = urldecode($value);
		}
		$main_category = ProductMainCategory::findOne(['canonical_name' => $params['main_categ'][0]]);
		if (!empty($params['categ'][0])) {
			$category = ProductCategory::findOne(['canonical_name' => $params['categ'][0]]);
		} elseif (!empty($params['sub_categ'][0])) {
			$sub_category = ProductSubCategory::findOne(['canonical_name' => $params['sub_categ'][0]]);
		}
		if (!empty($category)) {
			$products = Products::find()->where(['main_category' => $main_category->id, 'category' => $category->id])->select('id')->asArray()->all();
			$filters = Filter::find()->where(['category' => $category])->select(['features'])->distinct()->all();
		} elseif (!empty($sub_category)) {

			$filters = Filter::find()->where(['subcategory' => $sub_category->id])->select(['features'])->distinct()->all();
			$category = ProductCategory::findOne(['id' => $sub_category->category_id]);
			$products = Products::find()->where(['main_category' => $main_category->id, 'subcategory' => $sub_category->id])->select('id')->asArray()->all();
		}
		/*
		 * search tag actions
		 */
		if (isset($query_search)) {
			$category_id = \common\models\ProductCategory::find()->where(['canonical_name' => $categ])->one();
			$category = \common\models\SearchTag::find()->where(['canonical_name' => $query_search, 'category' => $category_id->id])->one();
			$search_products = Products::find()->where(['status' => 1])->andWhere(new Expression('FIND_IN_SET(:search_tags, search_tags)'))->addParams([':search_tags' => $category->id])->andWhere(['category' => $category->category])->all();
		} else {
			$keyword = $_GET['keyword'];
			$search_products = Products::find()->where(['item_ean' => $keyword])->orWhere(['like', 'product_name', $keyword])->andWhere(['status' => 1])->all();
		}
		$products = [];
		foreach ($search_products as $value) {
			$products[] = $value->id;
		}
		$searchModel = new ProductVendorSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andWhere(['IN', 'product_id', $products]);
		$dataProvider->query->andWhere(['vendor_status' => 1, 'admin_status' => 2]);
		//$vendor_products = \common\models\ProductVendor::find()->where(['IN', 'product_id', $products])->all();

		return $this->render('index', [
			    'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
			    'filters' => $filters,
			    'categ' => $category->id,
		]);
	}

	public function actionComplaints() {
		if (Yii::$app->request->isAjax) {
			$model = new UserComplaints();
			$data = $this->renderPartial('complaints', [
			    'model' => $model
			]);
			echo $data;
		}
	}

	public function actionSaveComplaint() {
		if (Yii::$app->request->isAjax) {

			$model = new UserComplaints();
			if ($model->load(Yii::$app->request->post())) {
				$model->DOC = date('Y-m-d');
//				Yii::$app->SetValues->Attributes($model);

				if ($model->save()) {
					echo json_encode(array('msg' => 'Successfully submitted your complaint', 'dat' => 1));
				} else {
					echo json_encode(array('msg' => 'Sorry an error occured', 'dat' => 2));
				}
			}
		}
	}

}
