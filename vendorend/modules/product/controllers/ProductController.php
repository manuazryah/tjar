<?php

namespace vendorend\modules\product\controllers;

use yii;
use common\models\Products;
use common\models\ProductsSearch;
use common\models\ProductVendor;
use common\models\ProductVendorSearch;
use common\models\StockHistory;
use yii\db\Expression;
use common\models\UserComplaintsSearch;

class ProductController extends \yii\web\Controller {

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

                $dataProvider->query->andWhere(['<>', 'full_fill', 1]);
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

        public function actionProductView($id) {
                $product_model = Products::findOne(['id' => $id]);
                return $this->renderAjax('product-view', [
                            'model' => $product_model,
                ]);
        }

        public function actionProductList() {
                $searchModel = new ProductsSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->pagination->pageSize = 42;
                return $this->render('product_list', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
        }

        public function actionSellProduct($id) {
                $model = new ProductVendor();
                $vendor_address = \common\models\Locations::find()->where(['vendor_id' => Yii::$app->user->identity->id])->orderBy(['(dafault_address)' => SORT_DESC])->all();
                $product_model = Products::find()->where(['id' => $id])->one();
                $product_specifications = \common\models\ProductSpecifications::find()->where(['product_id' => $id])->all();
                if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
                        $model->vendor_id = Yii::$app->user->identity->id;
                        if (isset($model->offer_price) && $model->offer_price != '') {
                                $model->offer = round(100 - (($model->offer_price * 100) / $model->price));
                        } else {
                                $model->offer_price = $model->price;
                        }
                        if ($model->save()) {
                                StockHistory::stockhistory($model->qty, '1', $model->id, '2', ''); //qty,purpose,product vendor id,vendor
                                $history_id = Yii::$app->SetValues->History($model->id, 1, $model->id, 2, Yii::$app->user->identity->id); //params : reference id, history type, product id, user type, user id
                                if (isset($history_id))
                                        Yii::$app->SetValues->Notifications($model->id, $history_id, Yii::$app->user->identity->id); //params : reference id, history id, user id
                                return $this->redirect(['index', 'vendor_status' => 1]);
                        }
                }

                return $this->render('sell_product', [
                            'product_model' => $product_model,
                            'vendor_address' => $vendor_address,
                            'model' => $model,
                            'id' => $id,
                            'product_specifications' => $product_specifications,
                ]);
        }

        /**
         * Displays a single ProductVendor model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id) {


                $product_model = ProductVendor::findOne($id);
                $vendor_address = \common\models\Locations::find()->where(['vendor_id' => \Yii::$app->user->identity->id])->orderBy(['(dafault_address)' => SORT_DESC])->all();
                $product_specifications = \common\models\ProductSpecifications::find()->where(['product_id' => $product_model->product_id])->all();
                $product = Products::findOne($product_model->product_id);

                if ($product_model->load(Yii::$app->request->post())) {
                        $product_model->update();
                }
                return $this->render('view', [
                            'model' => $product_model,
                            'product_specifications' => $product_specifications,
                            'vendor_address' => $vendor_address,
                            'product' => $product,
                            'id' => $id,
                ]);
        }

        /**
         * Deletes an existing Filter model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDel($id) {
                $model = ProductVendor::find()->where(['id' => $id])->one();
                if ($model->delete()) {
                        Yii::$app->getSession()->setFlash('error', 'Product Removed Successfully');
                }

                return $this->redirect(['index']);
        }

        public function actionAjaxchangeProduct() {
                if (yii::$app->request->isAjax) {
                        $qty = Yii::$app->request->post()['qty'];
                        $price = Yii::$app->request->post()['price'];
                        $offerprice = Yii::$app->request->post()['offerprice'];
                        $status = Yii::$app->request->post()['status'];
                        $id = Yii::$app->request->post()['id'];
                        if ($id) {
                                $model = ProductVendor::find()->where(['id' => $id])->one();
                                $offerprice_ = $model->price - $model->offer_price;
                                $old_qty = $model->qty;
                                $model->qty = $qty;

                                if (isset(Yii::$app->request->post()['offerprice'])) {
                                        $model->offer_price = $offerprice;
                                        $model->offer = round(100 - (($model->offer_price * 100) / $model->price));
                                }


                                $model->price = $price;
                                $model->vendor_status = $status;
                                if ($model->save()) {
                                        if ($qty != $old_qty) {
                                                StockHistory::stockhistory($model->qty, '2', $model->id, '2', $old_qty);
                                        }
                                        echo json_encode(array('msg' => 'success', 'title' => 'Updated Successfully'));
                                } else {
                                        echo json_encode(array('msg' => 'error', 'title' => 'Internal error '));
                                }
                        } else {
                                echo json_encode(array('msg' => 'error', 'title' => 'Product cannot be find'));
                        }
                }
        }

        public function actionDetails($id) {
                $vendor_address = \common\models\Locations::find()->where(['vendor_id' => Yii::$app->user->identity->id])->orderBy(['(dafault_address)' => SORT_DESC])->all();
                $product_model = Products::find()->where(['id' => $id])->one();
                $product_specifications = \common\models\ProductSpecifications::find()->where(['product_id' => $id])->all();

                return $this->renderAjax('product_detail', [
                            'product_model' => $product_model,
                            'vendor_address' => $vendor_address,
                            'id' => $id,
                            'product_specifications' => $product_specifications,
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

        public function actionProductSearch($query_cat = null, $query_search = null) {
                if (isset($query_search)) {
                        $category_id = \common\models\ProductCategory::find()->where(['canonical_name' => $query_cat])->one();
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
                $vendor_products = ProductVendor::find()->where(['vendor_id' => \Yii::$app->user->identity->id])->all();
                $vendor_added_products = [];
                foreach ($vendor_products as $vendor_products) {
                        $vendor_added_products[] = $vendor_products->product_id;
                }

                $searchModel = new ProductsSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->pagination->pageSize = 42;
                $dataProvider->query->andWhere(['NOT IN', 'id', $vendor_added_products]);
                $dataProvider->query->andWhere(['IN', 'id', $products]);


                return $this->render('product_list', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
        }

        public function actionChangeVendorStatus() {
                if (yii::$app->request->isAjax) {

                        $id = Yii::$app->request->post()['id'];
                        $vendor_status = Yii::$app->request->post()['status'];
                        $model = ProductVendor::findOne($id);
                        $model->vendor_status = $vendor_status;
                        if ($model->save()) {
                                echo 1;
                        } else {
                                echo 0;
                        }
                }
        }

        public function actionProductHistory($id) {

                $product_model = ProductVendor::findOne($id);
                if (!empty($product_model)) {
                        $other_vendors = ProductVendor::find()->where(['<>', 'id', $id])->andWhere(['product_id' => $product_model->product_id])->all();
                } else {
                        $other_vendors = '';
                }
                $from = '';
                $to = '';
                if (Yii::$app->request->post()) {
                        if (Yii::$app->request->post('from_date') != '') {
                                $from = Yii::$app->request->post('from_date');
                        }
                        if (Yii::$app->request->post('to_date') != '') {
                                $to = Yii::$app->request->post('to_date');
                        }
                }

                return $this->render('product-history', [
                            'model' => $product_model,
                            'id' => $id,
                            'from' => $from,
                            'to' => $to,
                            'other_vendors' => $other_vendors,
                ]);
        }

        public function actionProductComplaints($id) {
                $searchModel = new UserComplaintsSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->query->andWhere(['product_id' => $id, 'vendor_id' => \Yii::$app->user->identity->id]);
//		$complaints = UserComplaints::find()->where(['product_id' => $id])->all();

                return $this->render('_complaints', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'id' => $id,
                ]);
        }

        public function actionUserView($id) {

                $product_model = \common\models\User::findOne(['id' => $id]);
//		var_dump($product_model);
//		exit;
                return $this->renderAjax('user-view', [
                            'model' => $product_model,
                ]);
        }

}
