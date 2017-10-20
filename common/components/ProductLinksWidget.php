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
use common\models\Product;

class ProductLinksWidget extends Widget {

	public $id;
	public $div_id;

	public function init() {
		parent::init();
		if ($this->id === null) {
			return '';
		}
	}

	public function run() {

		$model = Product::findOne($this->id);
		return $this->render('product-links', ['model' => $model, 'div_id' => $this->div_id]);
	}

}

?>
