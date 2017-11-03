<?php

namespace vendorend\modules\product\controllers;

use yii;
use common\models\Products;
use common\models\ProductsSearch;
use common\models\ProductVendor;
use common\models\ProductVendorSearch;
use yii\db\Expression;

class ProductController extends \yii\web\Controller {

        public function actionIndex() {
                $searchModel = new ProductVendorSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->pagination->pageSize = 20;
                return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
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
                if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
                        $model->vendor_id = Yii::$app->user->identity->id;
                        if ($model->save()) {
                                return $this->redirect('product-list');
                        }
                }
                return $this->render('sell_product', [
                            'product_model' => $product_model,
                            'vendor_address' => $vendor_address,
                            'model' => $model,
                            'id' => $id,
                ]);
        }

        /**
         * Displays a single ProductVendor model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id) {
                $model = ProductVendor::find()->where(['id' => $id])->one();
                $product = Products::find()->where(['id' => $model->product_id])->one();
                return $this->renderAjax('view', [
                            'model' => $model,
                            'product' => $product,
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
                                $model->qty = $qty;
                                $model->price = $price;
                                $model->offer_price = $offerprice;
                                $model->status = $status;
                                if ($model->save()) {
                                        echo json_encode(array('msg' => 'success', 'title' => 'succesfully changed'));
                                } else {
                                        var_dump($model);
                                        exit;
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

                return $this->renderAjax('product_detail', [
                            'product_model' => $product_model,
                            'vendor_address' => $vendor_address,
                            'id' => $id,
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
