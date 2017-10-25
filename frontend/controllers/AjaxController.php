<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\SetLanguage;

/**
 * Site controller
 */
class AjaxController extends Controller {

        public function beforeAction($action) {
                $this->enableCsrfValidation = false;
                return parent::beforeAction($action);
        }

        public function actionSs() {
                SetLanguage::SetLanguage($_POST['language']);
        }

}
