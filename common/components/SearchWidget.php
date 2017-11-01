<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppointmentWidget
 *
 * @author
 * JIthin Wails
 */

namespace common\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

//use common\models\RecentlyViewed;

class SearchWidget extends Widget {

        public $type;

        public function init() {
                parent::init();
        }

        public function run() {
                return $this->render('search-data', ['type' => $this->type]);
        }

}

?>
