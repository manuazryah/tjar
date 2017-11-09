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

class ProductsController extends \yii\web\Controller {

	/**
	 * Displays a Products based on category.
	 * @param category_code $id
	 * @return mixed
	 */
	public function actionIndex($main_categ, $categ = null, $sub_categ = null) {
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
			$filters = Filter::find()->where(['category' => $category])->all();
		} elseif (!empty($sub_category)) {
			$filters = Filter::find()->where(['subcategory' => $sub_category->id])->all();
			$category = ProductCategory::findOne(['id' => $sub_category->category_id]);
			$products = Products::find()->where(['main_category' => $main_category->id, 'subcategory' => $sub_category->id])->select('id')->asArray()->all();
		}
		$result = $this->Filters($params);
		if ($result[0] == null && $result[1] == 0) {
			foreach ($products as $product) {

				$productids[] = $product['id'];
			}
		} else {
			$productids = $result[0];
//			$vendor_products = \common\models\ProductVendor::find()->where(['IN', 'product_id', $productids])->all();
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
		if (!empty($min_value) && !empty($max_value) && $productids != null)
			$vendor_products = \common\models\ProductVendor::find()->where(['IN', 'product_id', $productids])->andWhere(['between', 'price', $min_value, $max_value])->all();
		elseif ($productids != null) {
			$vendor_products = \common\models\ProductVendor::find()->where(['IN', 'product_id', $productids])->all();
		} else {

			$vendor_products = \common\models\ProductVendor::find()->where(['IN', 'product_id', $productids])->all();
		}



		return $this->render('index', [
			    'dataProvider' => $vendor_products,
			    'filters' => $filters,
			    'categ' => $category->id,
			    'sub_categ' => $sub_category->id,
			    'main_categ' => $main_category->id,
		]);
	}

	function Filters($data) {
		$flag = 0;
		$main_category = ProductMainCategory::findOne(['canonical_name' => $data['main_categ'][0]]);
		if (!empty($data['categ'][0])) {
			$category = ProductCategory::findOne(['canonical_name' => $data['categ'][0]]);
		} elseif (!empty($data['sub_categ'][0])) {
			$sub_category = ProductSubCategory::findOne(['canonical_name' => $data['sub_categ'][0]]);
		}

		foreach ($data as $key => $value) {
			$unwanted = array("products/index", "main_categ", "categ", "sub_categ", 'min-range', 'max-range');
			if (!in_array($key, $unwanted)) {
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

//	public function actionInternational($id = null, $type = null) {
//		$catag = Category::find()->where(['category_code' => $id])->one();
//		$categories = Category::find()->where(['status' => 1])->all();
//		$searchModel = new ProductSearch();
//		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//		$dataProvider->query->andWhere(['main_category' => 2]);
//		if (!empty($id)) {
//			$dataProvider->query->andWhere(['category' => $catag->id]);
//		}
//		return $this->render('index', [
//			    'categories' => $categories,
//			    'dataProvider' => $dataProvider,
//			    'id' => $id,
//		]);
//	}


	public function Search($keyword, $dataProvider) {
		$dataProvider->query->andWhere(['like', 'product_name', $keyword])->orWhere(['like', 'canonical_name', $keyword]);
		/*
		 * search category
		 */
		$categorys = Category::find()->where(['status' => 1])->andWhere(['like', 'category', $keyword])->all();
		$category_products = array();
		if (!empty($categorys)) {
			foreach ($categorys as $value) {
				$cat_products = Product::find()->where(['status' => 1, 'category' => $value->id])->all();
				foreach ($cat_products as $cat_products) {
					$category_products[] = $cat_products->id;
				}
			}
			$dataProvider->query->orWhere(['IN', 'id', $category_products]);
		}
		/*
		 * search search tags
		 */
		$search_tags = \common\models\MasterSearchTag::find()->where(['status' => 1])->andWhere((['like', 'tag_name', $keyword]))->all();
		$keyword_products = array();
		if (!empty($search_tags)) {
			foreach ($search_tags as $value) {
				$search_products = Product::find()->where(['status' => 1])->andWhere(new Expression('FIND_IN_SET(:search_tag, search_tag)'))->addParams([':search_tag' => $value->id])->all();
				foreach ($search_products as $search_productss) {
					if (!in_array($search_productss->id, $keyword_products))
						$keyword_products[] = $search_productss->id;
				}
			}
			$dataProvider->query->orWhere(['IN', 'id', $keyword_products]);
		}
		return $dataProvider;
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
		$a = yii::$app->EncryptDecrypt->Encrypt('encrypt', 1);
		$vendor_id = yii::$app->EncryptDecrypt->Encrypt('decrypt', $a);
		if (isset(Yii::$app->user->identity->id)) {
			$user_id = Yii::$app->user->identity->id;
		} else {
			$user_id = '';
		}
		$product_details = Products::find()->where(['canonical_name' => $product, 'status' => '1'])->one();
		$vendor_product = ProductVendor::find()->where(['vendor_id' => $vendor_id, 'product_id' => $product_details->id])->one();
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

	public function actionGenderSearch() {
		if (Yii::$app->request->isAjax) {

			$gender = $_POST['gender'];

			//Yii::$app->session['gender_search'] = $gender;
			if (!empty($gender) || $gender != "") {
				echo 1;
				exit;
			} else {
				echo 0;
				exit;
			}
		}
	}

	public function actionSearch() {


		$keyword = $_GET['keyword'];
		$searchModel = new ProductSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		if (isset($keyword) && $keyword != '') {
			$dataProvider->query->andWhere(['like', 'product_name', $keyword])->orWhere(['like', 'canonical_name', $keyword]);
			/*
			 * search category
			 */
			$category = Category::find()->where(['status' => 1])->andWhere(['like', 'category', $keyword])->all();
			$category_products = array();
			if (!empty($category)) {
				foreach ($category as $value) {
					$cat_products = Product::find()->where(['status' => 1, 'category' => $value->id])->all();
					foreach ($cat_products as $cat_products) {
						$category_products[] = $cat_products->id;
					}
				}
				$dataProvider->query->orWhere(['IN', 'id', $category_products]);
			}
			/*
			 * search search tags
			 */
			$search_tags = \common\models\MasterSearchTag::find()->where(['status' => 1])->andWhere((['like', 'tag_name', $keyword]))->all();
			$keyword_products = array();
			if (!empty($search_tags)) {
				foreach ($search_tags as $value) {
					$search_products = Product::find()->where(['status' => 1])->andWhere(new Expression('FIND_IN_SET(:search_tag, search_tag)'))->addParams([':search_tag' => $value->id])->all();
					foreach ($search_products as $search_productss) {
						if (!in_array($search_productss->id, $keyword_products))
							$keyword_products[] = $search_productss->id;
					}
				}
				$dataProvider->query->orWhere(['IN', 'id', $keyword_products]);
			}
		}

		$categories = Category::find()->where(['status' => 1])->all();
		$main_categry = '';

		return $this->render('index', [
			    'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
			    'categories' => $categories,
			    'main_categry' => $main_categry,
		]);
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

	public function actionProductSearch($query_search = null) {
		if (isset($query_search)) {
			$query_search = Yii::$app->EncryptDecrypt->Encrypt('decrypt', $query_search);
			$category = \common\models\SearchTag::findOne($query_search);
			$search_products = Products::find()->where(['status' => 1])->andWhere(new Expression('FIND_IN_SET(:search_tags, search_tags)'))->addParams([':search_tags' => $query_search])->andWhere(['category' => $category->category])->all();
		} else {
			$keyword = $_GET['keyword'];
			$search_products = Products::find()->where(['item_ean' => $keyword])->orWhere(['like', 'product_name', $keyword])->andWhere(['status' => 1])->all();
		}
		$products = [];
		foreach ($search_products as $value) {
			$products[] = $value->id;
		}
		$searchModel = new ProductsSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->pagination->pageSize = 42;
		$dataProvider->query->andWhere(['IN', 'id', $products]);
		return $this->render('product_list', [
			    'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
		]);
	}

}
