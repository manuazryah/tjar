<?php

namespace backend\modules\menumanagement\controllers;

use Yii;
use common\models\MenuManagement;
use common\models\MenuManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuManagementController implements the CRUD actions for MenuManagement model.
 */
class MenuManagementController extends Controller {

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
     * Lists all MenuManagement models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MenuManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MenuManagement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MenuManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new MenuManagement();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            if (isset($model->main_menu_id) && $model->main_menu_id != '') {
                $main_menu = MenuManagement::find()->where(['id' => $model->main_menu_id])->one();
                $model->main_menu = $main_menu->main_menu;
                $model->main_menu_arabic = $main_menu->main_menu_arabic;
            }
            if (isset($model->sub_menu_id) && $model->sub_menu_id != '') {
                $main_menu = MenuManagement::find()->where(['id' => $model->sub_menu_id])->one();
                $model->sub_menu = $main_menu->sub_menu;
                $model->sub_menu_arabic = $main_menu->sub_menu_arabic;
            }
            if ($model->save()) {
                $model = new MenuManagement();
                Yii::$app->getSession()->setFlash('success', 'Data Saved Successfully');
            }
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MenuManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            if (isset($model->main_menu_id) && $model->main_menu_id != '') {
                $main_menu = MenuManagement::find()->where(['id' => $model->main_menu_id])->one();
                $model->main_menu = $main_menu->main_menu;
                $model->main_menu_arabic = $main_menu->main_menu_arabic;
            }
            if (isset($model->sub_menu_id) && $model->sub_menu_id != '') {
                $main_menu = MenuManagement::find()->where(['id' => $model->sub_menu_id])->one();
                $model->sub_menu = $main_menu->sub_menu;
                $model->sub_menu_arabic = $main_menu->sub_menu_arabic;
            }
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Data Updated Successfully');
            }
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MenuManagement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MenuManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MenuManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MenuManagement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * This function select sub menu based on main menu
     * return result to the view
     */

    public function actionSelectSubMenu() {
        if (Yii::$app->request->isAjax) {
            $main = $_POST['main_cat'];
            $submenus = MenuManagement::find()->where(['main_menu_id' => $main, 'type' => 2])->all();
            $options = '<option value="">-Choose a Submenu-</option>';
            foreach ($submenus as $submenu) {
                $options .= "<option value='" . $submenu->id . "'>" . $submenu->sub_menu . "</option>";
            }

            echo $options;
        }
    }

}
