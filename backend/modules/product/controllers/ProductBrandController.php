<?php

namespace backend\modules\product\controllers;

use Yii;
use common\models\ProductBrand;
use common\models\ProductBrandSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * ProductBrandController implements the CRUD actions for ProductBrand model.
 */
class ProductBrandController extends Controller {

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
     * Lists all ProductBrand models.
     * @return mixed
     */
    public function actionIndex($id = NULL) {
        if (!empty($id)) {
            $model = $this->findModel($id);
        } else {
            $model = new ProductBrand();
        }
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate() && $model->save()) {
            if (!empty($id)) {
                Yii::$app->getSession()->setFlash('success', 'Updated Successfully');
            } else {
                Yii::$app->getSession()->setFlash('success', 'Created Successfully');
            }
            return $this->redirect(['index']);
        }
        $searchModel = new ProductBrandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    /**
     * Displays a single ProductBrand model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductBrand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ProductBrand();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductBrand model.
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
     * Deletes an existing ProductBrand model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductBrand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductBrand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProductBrand::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetbrand() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            var_dump($ids);
            exit;
            $maincat_id = empty($ids[0]) ? null : $ids[0];
            $cat_id = empty($ids[1]) ? null : $ids[1];
            $subcat_id = empty($ids[2]) ? null : $ids[2];
            if ($cat_id != null) {
                $out = ProductBrand::getBrandList($maincat_id, $cat_id, $subcat_id);
                /**
                 * the getProdList function will query the database based on the
                 * cat_id and sub_cat_id and return an array like below:
                 *  [
                 *      'out'=>[
                 *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
                 *          ['id'=>'<prod_id_2>', 'name'=>'<prod-name2>']
                 *       ],
                 *       'selected'=>'<prod-id-1>'
                 *  ]
                 */
                echo Json::encode(['output' => $out, 'selected' => '']);
//                echo Json::encode(['output' => $data['out'], 'selected' => $data['selected']]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

}
