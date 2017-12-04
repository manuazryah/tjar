<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\HomeManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Home Managements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="home-management-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">


                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



                    <?php // Html::a('<i class="fa-th-list"></i><span> Create Home Management</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <div class="table-responsive" style="border: none">
                        <button class="btn btn-white" id="search-option" style="float: right;">
                            <i class="linecons-search"></i>
                            <span>Search</span>
                        </button>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
//                                        'id',
                                [
                                    'attribute' => 'type',
                                    'filter' => ['1' => 'Category', '0' => 'Product'],
                                    'value' => function($data) {
                                        return $data->type == 1 ? 'Category' : 'Product';
                                    }
                                ],
                                'tittle',
                                [
                                    'attribute' => 'product_id',
                                    'value' => function($model, $key, $index, $column) {
                                        if (isset($model->product_id) && $model->product_id != '') {
                                            return $model->getProducts($model->product_id);
                                        }
                                    },
                                    'filter' => ArrayHelper::map(common\models\Products::find()->asArray()->all(), 'id', 'product_name'),
                                ],
                                'image_1',
//                                'image_1_arabic',
                                'link_1',
                                // 'image_2',
                                // 'image_2_arabic',
                                // 'link_2',
                                // 'image_3',
                                // 'image_3_arabic',
                                // 'link_3',
                                // 'sort_order',
                                // 'status',
                                // 'CB',
                                // 'UB',
                                // 'DOC',
                                // 'DOU',
                                [
                                    'class' => 'yii\grid\ActionColumn',
//                                    'contentOptions' => ['style' => 'width:100px;'],
                                    'header' => 'Actions',
                                    'template' => '{update}',
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            return Html::a('<span class="fa fa-pencil"></span>', $url, [
                                                        'title' => Yii::t('app', 'update'),
                                                        'class' => '',
                                            ]);
                                        },
//                                        'delete' => function ($url, $model) {
//                                            if ($model->id != 1) {
//                                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
//                                                            'title' => Yii::t('app', 'delete'),
//                                                            'class' => '',
//                                                            'data' => [
//                                                                'confirm' => 'Are you sure you want to delete this item?',
//                                                            ],
//                                                ]);
//                                            }
//                                        },
                                    ],
                                    'urlCreator' => function ($action, $model) {
                                        if ($action === 'update') {
                                            $url = Url::to(['update', 'id' => $model->id]);
                                            return $url;
                                        }
//                                        if ($action === 'delete') {
//                                            $url = Url::to(['del', 'id' => $model->id]);
//                                            return $url;
//                                        }
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

<script>
    $(document).ready(function () {
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
    });
</script>

