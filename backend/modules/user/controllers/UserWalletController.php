<?php

namespace backend\modules\user\controllers;

use Yii;
use common\models\UserWallet;
use common\models\UserWalletSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

/**
 * UserWalletController implements the CRUD actions for UserWallet model.
 */
class UserWalletController extends Controller {

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
	 * Lists all UserWallet models.
	 * @return mixed
	 */
	public function actionIndex($id = null) {

		$searchModel = new UserWalletSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andWhere(['user_id' => $id]);
		$user_model = \common\models\User::findOne([$id]);

		return $this->render('index', [
			    'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
			    'user_model' => $user_model,
		]);
	}

	/**
	 * Displays a single UserWallet model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render('view', [
			    'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new UserWallet model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new UserWallet();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
				    'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing UserWallet model.
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
	 * Deletes an existing UserWallet model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the UserWallet model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return UserWallet the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = UserWallet::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionRecentActivity($type = null) {


		$start_date = date('Y-m-d 60:60:60');

		$end_date = date('Y-m-d 00:00:00', strtotime(date('Y-m-d H:i:s') . " -1 month"));
		$searchModel = new UserWalletSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		if ($type != 1)
			$dataProvider->query->andWhere(['>=', 'entry_date', $end_date])->andWhere(['<=', 'entry_date', $start_date]);
//		$model = UserWallet::find()->where(['>=', 'entry_date', $end_date])->andWhere(['<=', 'entry_date', $start_date])->all();
//		$dataProvider = new ArrayDataProvider([
//		    'key' => 'id',
//		    'allModels' => $model,
//		    'sort' => [
//			'attributes' => ['id', 'user_id', 'credit_debit', 'entry_date', 'amount', 'balance_amount', 'reference_id'],
//		    ],
//		]);

		return $this->render('recent-activity', [
			    'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
			    'type' => $type
		]);
	}

	public function actionUserView($id) {
		$product_model = \common\models\User::findOne(['id' => $id]);

		return $this->renderAjax('user-view', [
			    'model' => $product_model,
		]);
	}

}
