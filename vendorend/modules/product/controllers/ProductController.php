<?php

namespace vendorend\modules\product\controllers;

use yii;
use common\models\Products;
use common\models\ProductsSearch;
use common\models\ProductVendor;
use common\models\ProductVendorSearch;

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
//            Yii::$app->SetValues->Attributes($model);
            $model->vendor_id = Yii::$app->user->identity->id;
            $model->save();
            return $this->redirect('product-list');
        }
        return $this->render('sell_product', [
                    'product_model' => $product_model,
                    'vendor_address' => $vendor_address,
                    'model' => $model,
                    'id' => $id,
        ]);
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
                    echo json_encode(array('msg' => 'error', 'title' => 'Internal error '));
                }
            } else {
                echo json_encode(array('msg' => 'error', 'title' => 'Product cannot be find'));
            }
        }
    }

}
