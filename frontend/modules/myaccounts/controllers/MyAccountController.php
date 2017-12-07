<?php

namespace frontend\modules\myaccounts\controllers;

use yii;
use common\models\UserAddress;
use common\models\User;
use common\models\OrderDetails;
use common\models\OrderDetailsSearch;
use common\models\OrderHistory;

class MyAccountController extends \yii\web\Controller {

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionAddress($id = NULL) {
        $error_return = 0;
        $user_data = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        $user_address = UserAddress::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        if (!empty($id)) {
            $model = UserAddress::findOne($id);
            $error_return = 2;
        } else {
            $model = new UserAddress();
        }
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $model->user_id = Yii::$app->user->identity->id;
            if (empty($user_address)) {
                $model->default_address = 1;
            } else {
                $user_exist = UserAddress::findOne(['user_id' => Yii::$app->user->identity->id, 'default_address' => 1]);
                if (!empty($user_exist)) {
                    if ($model->default_address != 0) {
                        $user_exist->default_address = 0;
                        $user_exist->update();
                    }
                }
            }
            if ($model->validate() && $model->save()) {
                $model = new UserAddress();
                $error_return = 0;
                return $this->redirect('address');
            } else {
                $error_return = 1;
            }
        }
        return $this->render('address', [
                    'model' => $model,
                    'user_data' => $user_data,
                    'error_return' => $error_return,
                    'user_address' => $user_address,
        ]);
    }

    public function actionSetDefault($id) {
        $model = UserAddress::findOne($id);
        $default_exist = UserAddress::findOne(['user_id' => Yii::$app->user->identity->id, 'default_address' => 1]);
        if (!empty($default_exist)) {
            $default_exist->default_address = 0;
            $default_exist->update();
        }
        $model->default_address = 1;
        $model->save();
        return $this->redirect('address');
    }

    public function actionMyOrders() {
        if (isset(Yii::$app->user->identity->id)) {
            $searchModel = new OrderDetailsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere(['user_id' => Yii::$app->user->identity->id]);
            $dataProvider->query->andWhere(['payment_status' => '1']);
            $dataProvider->pagination->pageSize = 10;
            return $this->render('my_order', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
//            $orders = OrderDetails::find()->where(['user_id' => Yii::$app->user->identity->id, 'payment_status' => '1'])->all();
//            return $this->render('my_order', ['orders' => $orders]);
        } else {
            $this->redirect(array('tjar'));
        }
    }

    public function actionWishList() {
        return $this->render('wish_list');
    }

    public function actionReviews() {
        $searchModel = new \common\models\CustomerReviewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['user_id' => \Yii::$app->user->identity->id]);
        $dataProvider->query->andWhere(['status' => 1]);
        return $this->render('reviews', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAccountDetails() {
        $user_details = User::findOne(Yii::$app->user->identity->id);
        return $this->render('account_details', [
                    'user_details' => $user_details,
        ]);
    }

    public function actionDelete($id) {
        $model = UserAddress::findOne($id);
        $model->delete();
        return $this->redirect('address');
    }

    public function actionEditPersonalInfo() {
        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user_details = User::findOne(Yii::$app->user->identity->id);
            $user_details->first_name = $model->first_name;
            $user_details->last_name = $model->last_name;
            $user_details->gender = $model->gender;
            $user_details->dob = date('Y-m-d', strtotime($model->dob));
            $user_details->mobile_number = $model->mobile_number;
            $user_details->save();
        }
        return $this->redirect('account-details');
    }

    public function actionChangeEmailAddress() {
        if (yii::$app->request->isAjax) {
            $email = $_POST['email'];
            $user = User::findOne(Yii::$app->user->identity->id);
            $user->email = $email;
            $user->save();
            echo 1;
        }
    }

    public function actionChangePassword() {
        if (yii::$app->request->isAjax) {
            $err_code = 0;
            $model = User::findOne(Yii::$app->user->identity->id);
            if (Yii::$app->getSecurity()->validatePassword(Yii::$app->request->post('old_password'), $model->password_hash)) {
                if (Yii::$app->request->post('new_password') == Yii::$app->request->post('confirn_password')) {
                    $model->password_hash = Yii::$app->security->generatePasswordHash(Yii::$app->request->post('confirn_password'));
                    $model->update();
                    $msg = 'Password changed successfully';
                    $err_code = 1;
                } else {
                    $msg = 'Password mismatch';
                }
            } else {
                $msg = 'Incorrect Old Password';
            }
            $arr_variable = array('err_code' => $err_code, 'msg' => $msg);
            $data['result'] = $arr_variable;
            echo json_encode($data);
        }
    }

    public function actionAddReview() {

        if (Yii::$app->request->isAjax) {
            $product_id = $_POST['product_id'];
            $exists = \common\models\CustomerReviews::find()->where(['user_id' => \Yii::$app->user->identity->id, 'product_id' => $product_id])->exists();
            if ($exists) {
                $model_review = \common\models\CustomerReviews::find()->where(['user_id' => \Yii::$app->user->identity->id, 'product_id' => $product_id])->one();
            } else {
                $model_review = new \common\models\CustomerReviews();
            }
            $product_details = \common\models\ProductVendor::findOne($product_id);
            $product_master_details = \common\models\Products::findOne($product_details->product_id);
            $data = $this->renderPartial('add_reviews', [
                'model_review' => $model_review,
                'product_id' => $product_id,
                'product_details' => $product_details,
                'product_master_details' => $product_master_details,
            ]);
            echo $data;
        }
    }

    public function actionSaveReview() {

        if (Yii::$app->request->isAjax) {

            $exists = \common\models\CustomerReviews::find()->where(['user_id' => \Yii::$app->user->identity->id, 'product_id' => $_POST['CustomerReviews']['product_id']])->exists();
            if ($exists) {
                $model_review = \common\models\CustomerReviews::find()->where(['user_id' => \Yii::$app->user->identity->id, 'product_id' => $_POST['CustomerReviews']['product_id']])->one();
            } else {
                $model_review = new \common\models\CustomerReviews();
            }
            if ($model_review->load(Yii::$app->request->post())) {
                $model_review->user_id = Yii::$app->user->identity->id;
                $model_review->review_date = date('Y-m-d');
                $model_review->save();
                \Yii::$app->SetValues->Rating($model_review->product_id);
            }
        }
    }

    public function actionTrack() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $history = OrderHistory::find()->where(['detail_id' => $id])->all();
            $model = OrderDetails::findOne($id);
            if ($history) {
                $content = OrderHistory::track_content($history, $model);

                echo json_encode(array('msg' => 'success', 'content' => $content));
                exit;
            }else{
                $content = OrderHistory::track_content($history, $model);
                echo json_encode(array('msg' => 'failed', 'content' => $content));
                exit;
            }
        }
//        return $this->renderAjax('track', [
//                    'model' => $this->findModel($id),
//                    'history' => OrderHistory::find()->where(['detail_id' => $id])->all(),
//        ]);
    }

}
