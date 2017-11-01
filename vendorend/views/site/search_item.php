<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\AdminPost;
use yii\helpers\ArrayHelper;
use common\components\SearchWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminUsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<style>
        .search .search-dropdown {
                list-style: none;
                padding: 0px;
                position: absolute;
                width: 100%;
                height: auto;
                margin: 0 auto;
                background: white;
                top: 35px;
                z-index: 10;
                border: 1px solid #dfdfdf;
                border-top: 0px;
                max-height: 250px;
                overflow-y: auto;
        }
</style>
<div style="text-align: center;padding-top: 50px;">
        <h2>What do you want to list?</h2>
        <?= SearchWidget::widget(['type' => '1']); ?>

</div>
