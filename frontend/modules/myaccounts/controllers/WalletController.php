<?php

namespace frontend\modules\myaccounts\controllers;

use common\models\User;
use common\models\UserWallet;
use yii;
use common\models\Cart;

class WalletController extends \yii\web\Controller {

	public function actionIndex() {
		$model = new UserWallet();
		$searchModel = new UserWalletSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andWhere(['user_id' => Yii::$app->user->identity->id]);
		$user_data = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
		if (Yii::$app->request->post()) {

			$user_wallet_history = new UserWallet();
			$user_wallet_history->user_id = Yii::$app->user->identity->id;
			$user_wallet_history->type_id = 1;
			$user_wallet_history->amount = Yii::$app->request->post()['UserWallet']['amount'];
			$user_wallet_history->entry_date = date('Y-m-d');
			$user_wallet_history->credit_debit = 1;
			if ($user_data->wallet_amount != NULL) {
				$balance = $user_data->wallet_amount + $user_wallet_history->amount;
			} else {
				$balance = $user_wallet_history->amount;
			}
			$user_wallet_history->balance_amount = $balance;
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if ($user_wallet_history->validate() && $user_wallet_history->save() && $this->changeCurrentWallet($user_wallet_history, $user_data, 1)) {
					$transaction->commit();
					Yii::$app->session->setFlash('success', 'Amount is added to your wallet.');
					$model = new UserWallet();
					return $this->redirect(['index']);
				}
			} catch (Exception $e) {
				$transaction->rollBack();
				Yii::$app->session->setFlash('error', 'An error occured.');
				throw $e;
			}
		}
		return $this->render('index', [
			    'model' => $model,
			    'user_data' => $user_data,
			    'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
		]);
	}

	public function changeCurrentWallet($wallet_history, $model, $type) {
		if (!empty($wallet_history) && !empty($model)) {
			if ($type == 1) {
				$model->wallet_amount = $model->wallet_amount + $wallet_history->amount;
			} elseif ($type == 2) {
				$model->wallet_amount = $model->wallet_amount - $wallet_history->amount;
			}

			if ($model->update()) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function actionMoneyFromWallet($net_amount, $ship_address, $bill_address, $order_id) {

		if (isset(Yii::$app->user->identity->id)) {
			$user_details = User::findOne([Yii::$app->user->identity->id]);
			if (!empty($user_details) && $user_details->wallet_amount >= $net_amount) {
				if ($this->debitWallet($user_details, $net_amount, $order_id)) {
					Cart::commissionManagement($order_id);
					return $this->redirect(['/site/index']); /* set payment success */
				}
			}
			return $this->redirect(Yii::$app->request->referrer);
		} else {

		}
	}

	public function debitWallet($user_model, $amount, $order_id) {
		$model = new UserWallet();
		$model->user_id = $user_model->id;
		$model->type_id = 2;
		$model->amount = $amount;
		$model->entry_date = date('Y-m-d');
		$model->credit_debit = 2;
		$model->reference_id = $order_id;
		if ($user_model->wallet_amount != NULL) {
			$balance = $user_model->wallet_amount - $amount;
		}
		$model->balance_amount = $balance;
		$transaction = \Yii::$app->db->beginTransaction();
		try {
			if ($model->validate() && $model->save() && $this->changeCurrentWallet($model, $user_model, 2)) {
				$transaction->commit();

				return true;
			}
		} catch (Exception $e) {
			$transaction->rollBack();
//			throw $e;
			return false;
		}
	}

}
