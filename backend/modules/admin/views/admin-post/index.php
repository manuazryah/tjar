<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\AdminPost;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminPostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-post-index">

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

                    <div class="table-responsive table-striped" style="border: none">
                        <button class="btn btn-white" id="search-option" style="float: right;">
                            <i class="linecons-search"></i>
                            <span>Search</span>
                        </button>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
//                                ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                                'post_name',
//                            [
//                                'attribute' => 'post_name',
//                                'filter' => ArrayHelper::map(AdminPost::find()->all(), 'id', 'post_name'),
//                                'value' => function($data) {
//                                    return AdminPost::findOne($data->id)->post_name;
//                                }
//                            ],
                                [
                                    'attribute' => 'admin',
                                    'filter' => ['1' => 'Yes', '0' => 'No'],
                                    'value' => function($data) {
                                        return $data->admin == 1 ? 'Yes' : 'No';
                                    }
                                ],
                                [
                                    'attribute' => 'product_reviews',
                                    'filter' => ['1' => 'Yes', '0' => 'No'],
                                    'value' => function($data) {
                                        return $data->product_reviews == 1 ? 'Yes' : 'No';
                                    }
                                ],
                                [
                                    'attribute' => 'order',
                                    'filter' => ['1' => 'Yes', '0' => 'No'],
                                    'value' => function($data) {
                                        return $data->order == 1 ? 'Yes' : 'No';
                                    }
                                ],
                                [
                                    'attribute' => 'vendor',
                                    'filter' => ['1' => 'Yes', '0' => 'No'],
                                    'value' => function($data) {
                                        return $data->vendor == 1 ? 'Yes' : 'No';
                                    }
                                ],
                                [
                                    'attribute' => 'users',
                                    'filter' => ['1' => 'Yes', '0' => 'No'],
                                    'value' => function($data) {
                                        return $data->users == 1 ? 'Yes' : 'No';
                                    }
                                ],
                                [
                                    'attribute' => 'promotions',
                                    'filter' => ['1' => 'Yes', '0' => 'No'],
                                    'value' => function($data) {
                                        return $data->promotions == 1 ? 'Yes' : 'No';
                                    }
                                ],
                                [
                                    'attribute' => 'masters',
                                    'filter' => ['1' => 'Yes', '0' => 'No'],
                                    'value' => function($data) {
                                        return $data->masters == 1 ? 'Yes' : 'No';
                                    }
                                ],
//                            'CB',
//                            'UB',
                                // 'DOC',
                                // 'DOU',
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
<script>
    $(document).ready(function () {
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
    });
</script>


