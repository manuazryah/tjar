<?php

//use Yii;

namespace frontend\controllers;

use yii;
use common\models\Products;
use common\models\ProductsSearch;
use common\models\ProductVendor;

class ProductsController extends \yii\web\Controller {

    /**
     * Displays a Products based on category.
     * @param category_code $id
     * @return mixed
     */
    public function actionIndex($id = null, $type = null, $category = null, $featured = null, $keyword = null) {

        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 42;
        if (!empty($id) && $id != null) {
            $catag = Category::find()->where(['category_code' => $id])->one();
            $category = $catag->main_category;
        } else {
            $catag = "";
        }

        if (isset($keyword) && $keyword != '') {
            $this->Search($keyword, $dataProvider);
        }

        if (!empty($category)) {
//			if ($category == "exclusive-brands")
//				$category = 1;
//			elseif ($category == "brands") {
//				$category = 2;
//			}
            $dataProvider->query->andWhere(['main_category' => $category]);
        }

        if (!empty($id)) {
            $dataProvider->query->andWhere(['category' => $catag->id]);
            $category = $catag->main_category;
        }

        if ((!empty($type) && $type == 0) || $type != "") {
            $dataProvider->query->andWhere(['gender_type' => $type]);
        }

        if (!empty($featured)) {

            if ($featured == 'featured') {
                $featured = 1;
            } else {
                $featured = 1;
            }
            $dataProvider->query->andWhere(['featured_product' => $featured]);
        }


        $categories = Category::find()->where(['status' => 1, 'main_category' => $category])->all();

        $meta_tags = CmsMetaTags::find()->where(['id' => 3])->one();
        \Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $meta_tags->meta_keyword]);
        \Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $meta_tags->meta_description]);


        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'categories' => $categories,
                    'catag' => $catag,
                    'main_categry' => $category,
                    'id' => $id,
                    'type' => $type,
                    'meta_title' => $meta_tags->meta_title,
                    'featured_status' => $featured,
                    'keyword' => $keyword,
        ]);
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
//                $shipping_limit = Settings::findOne('1')->value;
        $product_details = Products::find()->where(['canonical_name' => $product, 'status' => '1'])->one();
        $vendor_product = ProductVendor::find()->where(['vendor_id' => $vendor_id, 'product_id' => $product_details->id])->one();
//                $this->RecentlyViewed($product_details);
//                $product_reveiws = \common\models\CustomerReviews::find()->where(['product_id' => $product_details->id, 'status' => '1'])->all();

        return $this->render('product_detail', [
                    'product_details' => $product_details,
                    'vendor_product' => $vendor_product,
                    'user_id' => $user_id,
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
                $model = RecentlyViewed::find()->where(['product_id' => $product->id, 'session_id' => Yii::$app->session['temp_user_product']])->one();
            }
            $sessonid = Yii::$app->session['temp_user_product'];
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
     * This function will display new modal for add new customer reviews
     */
    public function actionAddReview() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(array('site/login-signup'));
        }
        if (Yii::$app->request->isAjax) {
            $product_id = $_POST['product_id'];
            $model_review = new \common\models\CustomerReviews();
            $product_details = Product::findOne($product_id);
            $data = $this->renderPartial('add_reviews', [
                'model_review' => $model_review,
                'product_id' => $product_id,
                'product_details' => $product_details,
            ]);
            echo $data;
        }
    }

    /**
     * This function will save new customer reviews
     */
    public function actionSaveReview() {
        if (Yii::$app->request->isAjax) {
            $model_review = new \common\models\CustomerReviews();
            if ($model_review->load(Yii::$app->request->post())) {
                $model_review->user_id = Yii::$app->user->identity->id;
                $model_review->review_date = date('Y-m-d');
                $model_review->save();
                echo 1;
                exit;
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
        if (Yii::$app->request->isAjax) {

            $keyword = $_POST['keyword'];
            if ($keyword != '' || !empty($keyword)) {
                $search_tags = \common\models\MasterSearchTag::find()->select('tag_name')->where(['status' => 1])->andWhere((['like', 'tag_name', $keyword]))->all();
                $products = Product::find()->where(['status' => 1])->select('product_name')->andWhere((['like', 'product_name', $keyword]))->all();
                $category = Category::find()->where(['status' => 1])->select('category')->andWhere((['like', 'category', $keyword]))->all();
                $results_temp = array_merge($search_tags, $products);
                $results = array_merge($results_temp, $category);

                $values = $this->renderPartial('_product_search', ['products' => $results, 'keyword' => $keyword]);
                echo $values;
            }
        }
    }

}
