<?php

namespace backend\modules\cms\controllers;

use Yii;
use common\models\Slider;
use common\models\SliderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * SliderController implements the CRUD actions for Slider model.
 */
class SliderController extends Controller {

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
     * Lists all Slider models.
     * @return mixed
     */
    public function actionIndex($id = NULL) {
        if (!empty($id)) {
            $model = $this->findModel($id);
        } else {
            $model = new Slider();
            $model->setScenario('create');
        }
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $this->SetExtension($model, $id) && $model->validate() && $model->save() && $this->SaveUpload($model)) {
            if (!empty($id)) {
                Yii::$app->getSession()->setFlash('success', 'Updated Successfully');
            } else {
                Yii::$app->getSession()->setFlash('success', "Create Successfully");
            }
            return $this->redirect(['index']);
        }
        $searchModel = new SliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 5;

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    /*
     * This function get model and set image extensions
     * return model
     */

    public function SetExtension($model, $id) {
        $image = UploadedFile::getInstance($model, 'slider_image');
        $image_arabic = UploadedFile::getInstance($model, 'slider_image_arabic');
        if (!empty($id)) {
            $update = Slider::findOne($id);
            if (!empty($image)) {
                $model->slider_image = $image->extension;
            } else {
                $model->slider_image = $update->slider_image;
            }
            if (!empty($image_arabic)) {
                $model->slider_image_arabic = $image->extension;
            } else {
                $model->slider_image_arabic = $update->slider_image_arabic;
            }
        } else {
            $model->slider_image = $image->extension;
            $model->slider_image_arabic = $image_arabic->extension;
        }

        return TRUE;
    }

    /**
     * Upload gender image based on id.
     * @return mixed
     */
    public function SaveUpload($model) {
        $image = UploadedFile::getInstance($model, 'slider_image');
        $image_arabic = UploadedFile::getInstance($model, 'slider_image_arabic');
        $path = Yii::$app->basePath . '/../uploads/cms/slider/' . $model->id;
        if (!file_exists($path)) {
            FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
        }
        if (!empty($image)) {
            $image->saveAs($path . '/' . 'large.' . $image->extension);
        }
        if (!empty($image_arabic)) {
            $image_arabic->saveAs($path . '/' . 'large_arabic.' . $image->extension);
        }
        return TRUE;
    }

    /**
     * Displays a single Slider model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Slider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Slider();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Slider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Slider model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Slider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Slider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Slider::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
