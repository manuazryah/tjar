<?php

namespace vendorend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Vendors;
use common\models\ForgotPasswordTokens;
use common\models\Products;
use common\models\ProductsSearch;
use common\models\NotificationViewStatus;

/**
 * Site controller
 */
class SiteController extends Controller {

        /**
         * @inheritdoc
         */
        public function behaviors() {
                return [
                    'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                                [
                                'actions' => ['login', 'error', 'index', 'home', 'forgot', 'new-password', 'search-item', 'search-keyword', 'notifications'],
                                'allow' => true,
                            ],
                                [
                                'actions' => ['logout', 'index', 'forgot'],
                                'allow' => true,
                                'roles' => ['@'],
                            ],
                        ],
                    ],
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'logout' => ['post'],
                        ],
                    ],
                ];
        }

        /**
         * @inheritdoc
         */
        public function actions() {
                return [
                    'error' => [
                        'class' => 'yii\web\ErrorAction',
                    ],
                ];
        }

        /**
         * Displays homepage.
         *
         * @return string
         */
        public function actionIndex() {
                if (!Yii::$app->user->isGuest) {
                        return $this->redirect(array('site/home'));
                }
                $this->layout = 'adminlogin';

                $model = new Vendors();
                $model->scenario = 'login';
                if ($model->load(Yii::$app->request->post()) && $model->login()) {

                        return $this->redirect(array('site/home'));
                } else {
                        return $this->render('login', [
                                    'model' => $model,
                        ]);
                }
        }

        public function actionHome() {
                if (isset(Yii::$app->user->identity->id)) {
                        if (Yii::$app->user->isGuest) {
                                return $this->redirect(array('site/index'));
                        }
                        $products = \common\models\ProductVendor::find()->where(['vendor_id' => Yii::$app->user->identity->id])->andWhere(['<', 'qty', 3])->all();
                        return $this->render('index', [
                                    'products' => $products]);
                } else {
                        throw new \yii\web\HttpException(2000, 'Session Expired.');
                }
        }

        public function actionLogin() {

                $this->layout = 'adminlogin';
                $model = new AdminUsers();
                $model->scenario = 'login';

                if ($model->load(Yii::$app->request->post()) && $model->login() && $this->setSession()) {

                        return $this->redirect(array('site/home'));
                } else {

                        return $this->render('login', [
                                    'model' => $model,
                        ]);
                }
        }

        /**
         * Logout action.
         *
         * @return string
         */
        public function actionLogout() {
                Yii::$app->user->logout();
                unset(Yii::$app->session['post']);
                return $this->goHome();
        }

        public function actionForgot() {
                $this->layout = 'adminlogin';
                $model = new Vendors();
                if ($model->load(Yii::$app->request->post())) {
                        $check_exists = Vendors::find()->where("username = '" . $model->username . "' OR email = '" . $model->username . "'")->one();

                        if (!empty($check_exists)) {
                                $token_value = $this->tokenGenerator();
                                $token = $check_exists->id . '_' . $token_value;
                                $val = base64_encode($token);
                                $token_model = new ForgotPasswordTokens();
                                $token_model->user_id = $check_exists->id;
                                $token_model->token = $token_value;
                                $token_model->save();
                                $this->sendMail($val, $check_exists);
                                Yii::$app->getSession()->setFlash('success', 'A mail has been sent');
                        } else {
                                Yii::$app->getSession()->setFlash('error', 'Invalid username');
                        }
                        return $this->render('forgot-password', [
                                    'model' => $model,
                        ]);
                } else {
                        return $this->render('forgot-password', [
                                    'model' => $model,
                        ]);
                }
        }

        public function tokenGenerator() {

                $length = rand(1, 1000);
                $chars = array_merge(range(0, 9));
                shuffle($chars);
                $token = implode(array_slice($chars, 0, $length));
                return $token;
        }

        public function sendMail($val, $model) {
                $to = $model->email;
                $subject = 'Change password';
                $message = $this->renderPartial('forgot_mail', ['model' => $model, 'val' => $val]);
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
                        "From: 'info@perfumedunia.com";

                mail($to, $subject, $message, $headers);
        }

        public function actionNewPassword($token) {

                $this->layout = 'adminlogin';
                $data = base64_decode($token);
                $values = explode('_', $data);
                $token_exist = ForgotPasswordTokens::find()->where("user_id = " . $values[0] . " AND token = " . $values[1])->one();
                if (!empty($token_exist)) {
                        $model = Vendors::find()->where("id = " . $token_exist->user_id)->one();
                        if (Yii::$app->request->post()) {
                                if (Yii::$app->request->post('new-password') == Yii::$app->request->post('confirm-password')) {
                                        Yii::$app->getSession()->setFlash('success', 'password changed successfully');
                                        $model->password = Yii::$app->security->generatePasswordHash(Yii::$app->request->post('confirm-password'));
                                        $model->update();
                                        $token_exist->delete();
                                        $this->redirect('index');
                                } else {
                                        Yii::$app->getSession()->setFlash('error', 'Password mismatch  ');
                                }
                        }
                        return $this->render('new-password', [
                                    'model' => $model
                        ]);
                } else {

                }
        }

        public function actionSearchItem($keyword = null) {
                $searchModel = new ProductsSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->pagination->pageSize = 42;
                if (isset($keyword) && $keyword != '') {
                        $this->Search($keyword, $dataProvider);
                }
                return $this->render('search_item');
        }

        public function Search($keyword, $dataProvider) {
                $dataProvider->query->andWhere(['like', 'product_name', $keyword])->orWhere(['like', 'canonical_name', $keyword]);
                /*
                 * search category
                 */
                $categorys = Category::find()->where(['status' => 1])->andWhere(['like', 'category', $keyword])->all();
                $category_products = array();
                if (!empty($categorys)) {
                        foreach ($categorys as $value) {
                                $cat_products = Product::find()->where(['status' => 1, 'category' => $value->id])->all();
                                foreach ($cat_products as $cat_products) {
                                        $category_products[] = $cat_products->id;
                                }
                        }
                        $dataProvider->query->orWhere(['IN', 'id', $category_products]);
                }
                /*
                 * search search tags
                 */
                $search_tags = \common\models\MasterSearchTag::find()->where(['status' => 1])->andWhere((['like', 'tag_name', $keyword]))->all();
                $keyword_products = array();
                if (!empty($search_tags)) {
                        foreach ($search_tags as $value) {
                                $search_products = Product::find()->where(['status' => 1])->andWhere(new Expression('FIND_IN_SET(:search_tag, search_tag)'))->addParams([':search_tag' => $value->id])->all();
                                foreach ($search_products as $search_productss) {
                                        if (!in_array($search_productss->id, $keyword_products))
                                                $keyword_products[] = $search_productss->id;
                                }
                        }
                        $dataProvider->query->orWhere(['IN', 'id', $keyword_products]);
                }
                return $dataProvider;
        }

        public function actionSearchKeyword() {
                if (Yii::$app->request->isAjax) {

                        $keyword = $_POST['keyword'];
                        if ($keyword != '' || !empty($keyword)) {
                                $search_tags = \common\models\SearchTag::find()->select('tag_name')->where(['status' => 1])->andWhere((['like', 'tag_name', $keyword]))->all();
                                $products = Products::find()->where(['status' => 1])->select('product_name')->andWhere((['like', 'product_name', $keyword]))->all();
                                $category = \common\models\ProductCategory::find()->where(['status' => 1])->select('category_name')->andWhere((['like', 'category_name', $keyword]))->all();
                                $results_temp = array_merge($search_tags, $products);
                                $results = array_merge($results_temp, $category);

                                $values = $this->renderPartial('_product_search', ['products' => $results, 'keyword' => $keyword]);
                                echo $values;
                        }
                }
        }

        public function actionNotifications($id = null) {
                if (!empty($id)) {
                        $new_notifications = NotificationViewStatus::find()->where(['id' => $id])->one();
                        $history_model = \common\models\History::find()->where(['id' => $new_notifications->history_id])->one();
                        $master_history = \common\models\MasterHistoryType::findOne($history_model->history_type);
                        $new_notifications->view_status = 1;
                        $new_notifications->update();

                        if (isset($master_history->link)) {
                                $this->redirect(\Yii::$app->homeUrl . $master_history->link);
                        }
                } else {
                        $new_notifications = NotificationViewStatus::find()->where(['user_type' => 2, 'user_id' => Yii::$app->user->identity->id, 'view_status' => 0])->orderBy(['id' => SORT_DESC])->all();
                        return $this->render('notifications', [
                                    'new_notifications' => $new_notifications,
                        ]);
                }
        }

}
