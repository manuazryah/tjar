<?php

namespace frontend\modules\myaccounts\controllers;

use common\models\User;
use common\models\UserWallet;
use yii;

class WalletController extends \yii\web\Controller {

	public function actionIndex() {
		$model = new UserWallet();
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
				if ($user_wallet_history->validate() && $user_wallet_history->save() && $this->changeCurrentWallet($user_wallet_history, $user_data)) {
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
//			if ($user_wallet_history->validate() && $user_wallet_history->save()) {
//				$user_data->wallet_amount = $user_data->wallet_amount + $user_wallet_history->amount;
//				$user_data->update();
//				Yii::$app->session->setFlash('success', 'Amount is added to your wallet.');
//			} else {
//
//				Yii::$app->session->setFlash('error', 'An error occured.');
//			}
		}
		return $this->render('index', [
			    'model' => $model,
			    'user_data' => $user_data
		]);
	}

	public function changeCurrentWallet($wallet_history, $model) {
		if (!empty($wallet_history) && !empty($model)) {
			$model->wallet_amount = $model->wallet_amount + $wallet_history->amount;
			if ($model->update()) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

}
