<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\AdminPost;
use yii\helpers\ArrayHelper;
use common\models\OrderMaster;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminUsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div style="text-align: center;padding-top: 125px;">
    <h1>Welcome to the Tjar Sellers</h1>
    <p>All set. Now you need to start listing your products so customers can find them.</p>
    <p>Click the button below to start listing</p>
    <?= Html::a('<i class="fa fa-indent"></i><span>Start Listing Now</span>', ['/site/search-item'], ['class' => 'btn btn-info btn-icon btn-icon-standalone btn-lg']) ?>
</div>


