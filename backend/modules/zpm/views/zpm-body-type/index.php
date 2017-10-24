<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\ProductCategory;
use common\models\ProductSubCategory;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ZpmBodyTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Zpm Body Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zpm-body-type-index">

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
                        <div class="table-responsive" style="border: none">
                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'attribute' => 'category',
                                        'filter' => ArrayHelper::map(ProductCategory::find()->all(), 'id', 'category_name'),
                                        'value' => function($data) {
                                            return ProductCategory::findOne($data->category)->category_name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'subcategory',
                                        'filter' => ArrayHelper::map(ProductSubCategory::find()->all(), 'id', 'subcategory_name'),
                                        'value' => function($data) {
                                            return ProductSubCategory::findOne($data->subcategory)->subcategory_name;
                                        }
                                    ],
                                    'value',
                                    // 'type_1',
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
                                        'template' => '{update}{delete}',
                                        'buttons' => [
                                            'update' => function ($url, $model) {
                                                return Html::button('<i class="fa fa-pencil"></i>', ['value' => Url::to(['update', 'id' => $model->id]), 'class' => 'modalButton edit-btn']);
                                            },
                                            'delete' => function ($url, $model) {
                                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                                            'title' => Yii::t('app', 'delete'),
                                                            'class' => '',
                                                            'data' => [
                                                                'confirm' => 'Are you sure you want to delete this item?',
                                                            ],
                                                ]);
                                            },
                                        ],
                                        'urlCreator' => function ($action, $model) {
                                            if ($action === 'delete') {
                                                $url = Url::to(['del', 'id' => $model->id]);
                                                return $url;
                                            }
                                        }
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
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

