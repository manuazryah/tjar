<?php

namespace backend\modules\cms\controllers;

use Yii;
use common\models\HomeManagement;
use common\models\HomeManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * HomeManagementController implements the CRUD actions for HomeManagement model.
 */
class HomeManagementController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all HomeManagement models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new HomeManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HomeManagement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HomeManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($data = NULL) {
        $model = new HomeManagement();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $this->SetExtension($model) && $model->validate()) {
            if ($model->type == 0) {
                $model->product_id = implode(',', $model->product_id);
                $model->save();
            } elseif ($model->type == 1) {
                if ($model->save()) {
                    $this->SaveUpload($model, $data);
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /*
     * This function get model and set image extensions
     * return model
     */

    public function SetExtension($model) {
        $image1 = UploadedFile::getInstance($model, 'image_1');
        $image1_arabic = UploadedFile::getInstance($model, 'image_1_arabic');
        $image2 = UploadedFile::getInstance($model, 'image_2');
        $image2_arabic = UploadedFile::getInstance($model, 'image_2_arabic');
        $image3 = UploadedFile::getInstance($model, 'image_3');
        $image3_arabic = UploadedFile::getInstance($model, 'image_3_arabic');
        if (!empty($image1) && !empty($image1_arabic) && !empty($image2) && !empty($image2_arabic) && !empty($image3) && !empty($image3_arabic)) {
            $model->image_1 = $image1->extension;
            $model->image_1_arabic = $image1_arabic->extension;
            $model->image_2 = $image2->extension;
            $model->image_2_arabic = $image2_arabic->extension;
            $model->image_3 = $image3->extension;
            $model->image_3_arabic = $image3_arabic->extension;
        }
        return TRUE;
    }

    /**
     * Upload gender image based on id.
     * @return mixed
     */
    public function SaveUpload($model, $data) {
        $image1 = UploadedFile::getInstance($model, 'image_1');
        $image1_arabic = UploadedFile::getInstance($model, 'image_1_arabic');
        $image2 = UploadedFile::getInstance($model, 'image_2');
        $image2_arabic = UploadedFile::getInstance($model, 'image_2_arabic');
        $image3 = UploadedFile::getInstance($model, 'image_3');
        $image3_arabic = UploadedFile::getInstance($model, 'image_3_arabic');
        $path = Yii::$app->basePath . '/../uploads/cms/home_management/' . $model->id;
        if (!file_exists($path)) {
            FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
        }
        if (!empty($image1)) {
            if ($image1->saveAs($path . '/image1.' . $image1->extension)) {
                $model->image_1 = $image1->extension;
            }
        } else {
            $model->image_1 = $data->image_1;
        }
        if (!empty($image1_arabic)) {
            if ($image1_arabic->saveAs($path . '/image1_arabic.' . $image1_arabic->extension)) {
                $model->image_1_arabic = $image1_arabic->extension;
            }
        } else {
            $model->image_1_arabic = $data->image_1_arabic;
        }
        if (!empty($image2)) {
            if ($image2->saveAs($path . '/image2.' . $image2->extension)) {
                $model->image_2 = $image2->extension;
            }
        } else {
            $model->image_2 = $data->image_2;
        }
        if (!empty($image2_arabic)) {
            if ($image2_arabic->saveAs($path . '/image2_arabic.' . $image2_arabic->extension)) {
                $model->image_2_arabic = $image2_arabic->extension;
            }
        } else {
            $model->image_2_arabic = $data->image_2_arabic;
        }
        if (!empty($image3)) {
            if ($image3->saveAs($path . '/image3.' . $image3->extension)) {
                $model->image_3 = $image3->extension;
            }
        } else {
            $model->image_3 = $data->image_3;
        }
        if (!empty($image3_arabic)) {
            if ($image3_arabic->saveAs($path . '/image3_arabic.' . $image3_arabic->extension)) {
                $model->image_3_arabic = $image3_arabic->extension;
            }
        } else {
            $model->image_3_arabic = $data->image_3_arabic;
        }
        $model->update();
        return TRUE;
    }

    /**
     * Updates an existing HomeManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if (isset($id) && $id != '') {
            $data = $this->findModel($id);
        }
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate()) {
            if ($model->type == 0) {
                $model->product_id = implode(',', $model->product_id);
                $model->save();
            } elseif ($model->type == 1) {
                if ($model->save()) {
                    $this->SaveUpload($model, $data);
                }
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing HomeManagement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the HomeManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HomeManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = HomeManagement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * This function select sub category and products based on category
     * return result to the view
     */

    public function actionChangeCategory() {
        if (Yii::$app->request->isAjax) {
            $category = $_POST['category'];
            $subcategories = \common\models\ProductSubCategory::findAll(['category_id' => $category, 'status' => 1]);
            $product_datas = \common\models\Products::findAll(['category' => $category, 'status' => 1]);
            $items = array();
            if (!empty($product_datas)) {
                foreach ($product_datas as $product_data) {
                    $items[] = $product_data->id;
                }
            }
            $product_vendor_datas = \common\models\ProductVendor::find()->where(['in', 'product_id', $items])->all();
            $options = '<option value="">-Choose Subcategory-</option>';
            $options1 = '<option value="">-Choose Products-</option>';
            if (!empty($subcategories)) {
                foreach ($subcategories as $subcategory) {
                    $options .= "<option value='" . $subcategory->id . "'>" . $subcategory->subcategory_name . "</option>";
                }
            }
            if (!empty($product_vendor_datas)) {
                foreach ($product_vendor_datas as $product_vendor_data) {
                    $options1 .= "<option value='" . $product_vendor_data->id . "'>" . \common\models\Products::findOne($product_vendor_data->id)->product_name . "</option>";
                }
            }
            $arr_variable = array('subcategory' => $options, 'products' => $options1);
            $data['result'] = $arr_variable;
            echo json_encode($data);
        }
    }

    /*
     * This function select sub category and products based on category
     * return result to the view
     */

    public function actionChangeSubcategory() {
        if (Yii::$app->request->isAjax) {
            $category = $_POST['category'];
            $subcategory = $_POST['subcategory'];
            $product_datas = \common\models\Products::findAll(['subcategory' => $subcategory, 'status' => 1]);
            if (empty($product_datas)) {
                $product_datas = \common\models\Products::findAll(['category' => $category, 'status' => 1]);
            }
            if (!empty($product_datas)) {
                foreach ($product_datas as $product_data) {
                    $items[] = $product_data->id;
                }
            }
            $product_vendor_datas = \common\models\ProductVendor::find()->where(['in', 'product_id', $items])->all();
            $options = '<option value="">-Choose Product-</option>';
            if (!empty($product_vendor_datas)) {
                foreach ($product_vendor_datas as $product_vendor_data) {
                    $options .= "<option value='" . $product_vendor_data->id . "'>" . \common\models\Products::findOne($product_vendor_data->id)->product_name . "</option>";
                }
            }
            echo $options;
        }
    }

}
