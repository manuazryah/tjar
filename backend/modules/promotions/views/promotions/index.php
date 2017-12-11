<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PromotionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Promotions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promotions-index">

        <div class="row">
                <div class="col-md-12">

                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                                </div>
                                <div class="panel-body">


                                        <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>



                                        <?= Html::a('<i class="fa-th-list"></i><span> Create Promotions</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
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
                                                            'attribute' => 'promotion_type',
                                                            'value' => function($model) {
                                                                    if ($model->promotion_type == '1') {
                                                                            return 'Unique Product Code';
                                                                    } else if ($model->promotion_type == '2') {
                                                                            return 'User Specified Code';
                                                                    } else if ($model->promotion_type == '3') {
                                                                            return 'Common Code';
                                                                    }
                                                            },
                                                            'filter' => [1 => 'Unique Product Code', 2 => 'User Specified Code', 3 => 'Common Code'],
                                                        ],
                                                        'promotion_code',
                                                            [
                                                            'attribute' => 'status',
                                                            'value' => function($model) {
                                                                    return $model->status == '1' ? 'Enabled' : 'Disabled';
                                                            },
                                                            'filter' => [1 => 'Enabled', 0 => 'Disabled']
                                                        ],
                                                            [
                                                            'class' => 'yii\grid\ActionColumn',
                                                            'template' => '{disable}{approve}',
                                                            'buttons' => [
                                                                'approve' => function ($url, $model) {
                                                                        if ($model->status == 1) {
                                                                                return Html::a('<i class="fa fa-check" aria-hidden="true" style="color:green"></i>', $url, [
                                                                                            'title' => Yii::t('app', 'Click here to disable'),
                                                                                            'class' => 'actions',
                                                                                            'style' => 'cursor:pointer',
                                                                                ]);
                                                                        }
                                                                },
                                                                'disable' => function ($url, $model) {
                                                                        if ($model->status == 0) {
                                                                                return Html::a('<i class="fa fa-ban" aria-hidden="true" style="color:red"></i>', $url, [
                                                                                            'title' => Yii::t('app', 'Click here to active'),
                                                                                            'class' => 'actions',
                                                                                            'style' => 'cursor:pointer',
                                                                                ]);
                                                                        }
                                                                },
                                                            ],
                                                            'urlCreator' => function ($action, $model) {
                                                                    if ($action === 'approve') {
                                                                            $url = Url::to(['disable', 'id' => $model->id]);
                                                                            return $url;
                                                                    }
                                                                    if ($action === 'disable') {
                                                                            $url = Url::to(['approve', 'id' => $model->id]);
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

