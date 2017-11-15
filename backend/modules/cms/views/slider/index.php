<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\ProductMainCategory;
use common\models\ProductSubCategory;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductMainCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sliders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-main-category-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">


                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



                    <?= Html::button('<i class="fa-th-list"></i><span> Create New</span>', ['value' => Url::to('create'), 'class' => 'btn btn-warning  btn-icon btn-icon-standalone modalButton']) ?>
                    <?php
                    Modal::begin([
                        'header' => '',
                        'id' => 'modal',
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id = 'modalContent'></div>";
                    Modal::end();
                    ?>
                    <div class="table-responsive" style="border: none">
                        <button class="btn btn-white" id="search-option" style="float: right;">
                            <i class="linecons-search"></i>
                            <span>Search</span>
                        </button>
                        <?php Pjax::begin(); ?>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
//                                'id',
                                [
                                    'attribute' => 'slider_image',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if (isset($data->slider_image)) {
                                            $img = '<img width="250px" height: 115px; src="' . Yii::$app->homeUrl . '../uploads/cms/slider/' . $data->canonical_name . '.' . $data->slider_image . '?' . rand() . '"/>';
                                        } else {
                                            $img = '';
                                        }
                                        return $img;
                                    },
                                ],
                                [
                                    'attribute' => 'slider_image_arabic',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if (isset($data->slider_image_arabic)) {
                                            $img = '<img width="250px" height: 115px; src="' . Yii::$app->homeUrl . '../uploads/cms/slider/' . $data->canonical_name . '_arabic.' . $data->slider_image_arabic . '?' . rand() . '"/>';
                                        } else {
                                            $img = '';
                                        }
                                        return $img;
                                    },
                                ],
                                [
                                    'attribute' => 'slider_link',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if (isset($data->slider_link)) {
                                            return $data->slider_link;
                                        } else {
                                            return '';
                                        }
                                    },
                                ],
                                [
                                    'attribute' => 'status',
                                    'filter' => ['1' => 'Enable', '0' => 'Disable'],
                                    'value' => function($data) {
                                        return $data->status == 1 ? 'Enable' : 'Disable';
                                    }
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
//                                    'contentOptions' => ['style' => 'width:100px;'],
                                    'header' => 'Actions',
                                    'template' => '{delete}',
                                ],
                            ],
                        ]);
                        ?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
    });
</script>

