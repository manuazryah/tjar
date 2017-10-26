<?php

namespace vendorend\modules\product\controllers;

use yii;
use common\models\Products;
use common\models\ProductsSearch;
use common\models\ProductVendor;
use common\models\ProductVendorSearch;

class ProductController extends \yii\web\Controller {

    public function actionIndex() {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 42;
        return $this->render('index', [
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
            return $this->redirect('index');
        }
        return $this->render('sell_product', [
                    'product_model' => $product_model,
                    'vendor_address' => $vendor_address,
                    'model' => $model,
                    'id' => $id,
        ]);
    }
    
    public function actionDetails($id){
        $vendor_address = \common\models\Locations::find()->where(['vendor_id' => Yii::$app->user->identity->id])->orderBy(['(dafault_address)' => SORT_DESC])->all();
        $product_model = Products::find()->where(['id' => $id])->one();
        
        return $this->renderAjax('product_detail', [
                    'product_model' => $product_model,
                    'vendor_address' => $vendor_address,
                    'id' => $id,
        ]);
    }

}
