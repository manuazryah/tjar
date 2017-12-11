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
use common\models\StockHistory;

class ProductsController extends \yii\web\Controller {

	/**
	 * Displays a Products based on category.
	 * @param category_code $id
	 * @return mixed
	 */
	public function actionIndex($main_categ, $categ = null, $sub_categ = null) {
		$sub_category = '';
//		$sub_category->id = '';
		$searchModel = new ProductVendorSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->pagination->pageSize = 10;
		$query = explode('&', $_SERVER['QUERY_STRING']);

		$params = array();
		foreach ($query as $param) {
			if (strpos($param, '=') !== false) {
				list($name, $value) = explode('=', $param, 2);
				$params[urldecode($name)][] = urldecode($value);
			}
		}

		$main_category = ProductMainCategory::findOne(['canonical_name' => $params['main_categ'][0]]);
		if (!empty($params['categ'][0])) {
			$category = ProductCategory::findOne(['canonical_name' => $params['categ'][0]]);
		} elseif (!empty($params['sub_categ'][0])) {
			$sub_category = ProductSubCategory::findOne(['canonical_name' => $params['sub_categ'][0]]);
		}

		if (!empty($category)) {

			$products = Products::find()->where(['main_category' => $main_category->id, 'category' => $category->id])->select('id')->asArray()->all();
			$filters = Filter::find()->where(['category' => $category->id])->select(['DISTINCT `features`'])->all();
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
//			    'sub_categ' => $sub_category->id,
			    'main_categ' => $main_category->canonical_name,
			    'subcategory' => $sub_category
		]);
	}

	function Filters($data) {
		$productids = '';
		$flag = 2;
		if (isset($data['main_categ'][0]))
			$main_category = ProductMainCategory::findOne(['canonical_name' => $data['main_categ'][0]]);
		if (!empty($data['categ'][0])) {
			$category = ProductCategory::findOne(['canonical_name' => $data['categ'][0]]);
		} elseif (!empty($data['sub_categ'][0])) {
			$sub_category = ProductSubCategory::findOne(['canonical_name' => $data['sub_categ'][0]]);
		}

		foreach ($data as $key => $value) {

			$unwanted = array("products/index", "products/product-search", "main_categ", "categ", "sub_categ", 'min-range', 'max-range', 'page', 'per-page', 'query_search');
			if (!in_array($key, $unwanted)) {
				$flag = 0;

				$features = Features::findOne(['canonical_name' => $key]);

				if (!empty($sub_category)) {
					echo $sub_category->id;
					$product_features = ProductFeatures::find()->where(['specification' => $features->id, 'category' => $sub_category->category_id, 'subcategory' => $sub_category
						    ->id])->select('id')->asArray()->all();
				} else if (isset($category)) {

					$product_features = ProductFeatures::find()->where(['specification' => $features->id, 'category' => $category->id])->select('id')->asArray()->all();
				} else {
					$product_features = '';
				}
				$feature_ids = array();
				if (!empty($product_features)) {
					foreach ($product_features as $product_feature) {
						$feature_ids [] = $product_feature['id'];
					}
				}

				unset($dat);

				foreach ($value as $val) {
					if (!empty($feature_ids)) {
						$datas = \common\models\ProductSpecifications::find()->where(['IN', 'product_feature_id', $feature_ids])->andWhere(['Product_feature_text' => $val])->select('product_id')->asArray()->all();

						foreach ($datas as $data_) {
							$dat [] = $data_['product_id'];
						}
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
	public function actionProductDetail($canonical, $product) {
		if (isset(Yii::$app->user->identity->id)) {
			$user_id = Yii::$app->user->identity->id;
		} else {
			$user_id = '';
		}
		$product = yii::$app->EncryptDecrypt->Encrypt('decrypt', $product);
//        echo $product;exit;
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

	public function actionOrderCancel($orderdetail) {
		$orderdetail_id = yii::$app->EncryptDecrypt->Encrypt('decrypt', $orderdetail);
		$detail = \common\models\OrderDetails::findOne($orderdetail_id);
		$product_vendor = ProductVendor::findOne($detail->product_id);
		if (StockHistory::stockhistory($detail->quantity, '4', $detail->product_id, '3', $product_vendor->qty)) {//4=?return3=>customer
			$product_vendor->qty = $product_vendor->qty + $detail->quantity;
		}
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

	public function actionProductSearch($main_categ = null, $categ = null, $sub_categ = null, $query_search = null) {
		$query = explode('&', $_SERVER['QUERY_STRING']);

		$params = array();
		foreach ($query as $param) {
			if (strpos($param, '=') !== false) {
				list($name, $value) = explode('=', $param, 2);
				$params[urldecode($name)][] = urldecode($value);
			}
		}
		$main_category_name = '';
		$category_name = '';
		if (isset($params['main_categ'][0])) {
			$main_category = ProductMainCategory::findOne(['canonical_name' => $params['main_categ'][0]]);
			$main_category_name = $main_category->canonical_name;
		}
		if (!empty($params['categ'][0])) {
			$category = ProductCategory::findOne(['canonical_name' => $params['categ'][0]]);
			$category_name = $category->id;
		} elseif (!empty($params['sub_categ'][0])) {
			$sub_category = ProductSubCategory::findOne(['canonical_name' => $params['sub_categ'][0]]);
		}
		if (!empty($category)) {
			$products = Products::find()->where(['main_category' => $main_category->id, 'category' => $category->id])->select('id')->asArray()->all();
			$filters = Filter::find()->where(['category' => $category->id])->select(['DISTINCT `features`'])->all();
		} elseif (!empty($sub_category)) {

			$filters = Filter::find()->where(['subcategory' => $sub_category->id])->select(['features'])->distinct()->all();
			$category = ProductCategory::findOne(['id' => $sub_category->category_id]);
			$category_name = $category->id;
			$products = Products::find()->where(['main_category' => $main_category->id, 'subcategory' => $sub_category->id])->select('id')->asArray()->all();
		} else {
			$filters = '';
		}

		$result = $this->Filters($params);

		/*
		 * search tag actions
		 */
		if (isset($query_search)) {
			if (isset($sub_categ)) {
				$category_id = \common\models\ProductSubCategory::find()->where(['canonical_name' => $sub_categ])->one();
				$category_search = \common\models\SearchTag::find()->where(['canonical_name' => $query_search, 'subcategory' => $category_id->id])->one();
			} else {
				$category_id = \common\models\ProductCategory::find()->where(['canonical_name' => $categ])->one();
				$category_search = \common\models\SearchTag::find()->where(['canonical_name' => $query_search, 'category' => $category_id->id])->one();
			}
			$search_products = Products::find()->where(['status' => 1])->andWhere(new Expression('FIND_IN_SET(:search_tags, search_tags)'))->addParams([':search_tags' => $category_search->id])->andWhere(['category' => $category_search->category])->all();
		} else {
			$keyword = $_GET['keyword'];
			$search_products = Products::find()->where(['item_ean' => $keyword])->orWhere(['like', 'product_name', $keyword])->andWhere(['status' => 1])->all();
		}

		$products = [];
		foreach ($search_products as $value) {
			$products[] = $value->id;
		}


		if ($result[0] == null && $result[1] == 2) {

			$productids = $products;
		} else {
			if (!empty($result[0]))
				$productids = array_intersect($result[0], $products);
			else
				$productids = $products;
		}


		$searchModel = new ProductVendorSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andWhere(['IN', 'product_id', $productids]);
		$dataProvider->query->andWhere(['vendor_status' => 1, 'admin_status' => 2]);
		//$vendor_products = \common\models\ProductVendor::find()->where(['IN', 'product_id', $products])->all();
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
		} elseif ($productids != null) {
			$dataProvider->query->where(['IN', 'product_id', $productids]);
		} else {
			$productids = 0;
			$dataProvider->query->where(['IN', 'product_id', $productids]);
		}
		return $this->render('index', [
			    'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
			    'filters' => $filters,
			    'categ' => $category_name,
			    'main_categ' => $main_category_name,
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
