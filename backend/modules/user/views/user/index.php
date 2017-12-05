<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">


                    <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>


                    <?php Pjax::begin(['id' => 'users']) ?>
                    <div class="table-responsive" style="border: none">
                        <div style="float: right;">
                            <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-whitee', 'title' => 'Create User']) ?>
                            <?= Html::a('<i class="fa fa-refresh"></i>', ['index'], ['class' => 'btn btn-whitee refresh-btn', 'title' => 'Create User']) ?>
                            <button class="btn btn-white" id="search-option">
                                <i class="linecons-search"></i>
                                <span>Search</span>
                            </button>
                        </div>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'first_name',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if (isset($data->first_name)) {
                                            if ($data->online_status == 1) {
                                                return \yii\helpers\Html::a($data->first_name . '<i class="fa fa-circle" style="float: right;color: green;font-size: 8px;"></i>');
                                            } else {
                                                return $data->first_name;
                                            }
                                        } else {
                                            return '';
                                        }
                                    },
                                ],
                                'first_name',
                                'last_name',
                                'email:email',
                                // 'password_hash',
                                // 'password_reset_token',
                                // 'gender',
                                // 'dob',
                                'mobile_number',
                                [
                                    'attribute' => 'status',
                                    'value' => function($data) {
                                        return $data->status == '1' ? 'Enabled' : 'Disabled';
                                    },
                                    'filter' => [1 => 'Enabled', 0 => 'Disabled',]
                                ],
                                // 'created_at',
                                // 'updated_at',
                                ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{update}{view}{status}',
                                    'buttons' => [
                                        'status' => function ($url, $model) {
                                            return Html::checkbox('status', $model->status == 1 ? true : false, ['class' => 'iswitch iswitch-secondary user-ststus', 'id' => $model->id, 'title' => $model->status == 1 ? " User is Active" : 'User is Deactive']);
                                        },
                                        'update' => function ($url, $model) {
                                            return Html::a('<span class="fa fa-pencil" style="padding-top: 0px;font-size: 18px;"></span>', $url, [
                                                        'title' => Yii::t('app', 'print'),
                                                        'class' => 'actions',
                                            ]);
                                        },
                                        'view' => function ($url, $model) {
                                            return Html::a('<span class="fa fa-eye" style="padding-top: 0px;font-size: 18px;"></span>', $url, [
                                                        'title' => Yii::t('app', 'View Details'),
                                                        'class' => 'actions',
                                                        'target' => '_blank',
                                            ]);
                                        },
                                    ],
                                    'urlCreator' => function ($action, $model) {
                                        if ($action === 'update') {
                                            $url = Url::to(['user/update', 'id' => $model->id]);
                                            return $url;
                                        }

                                        if ($action === 'view') {
                                            $url = Url::to(['user/view', 'id' => $model->id]);
                                            return $url;
                                        }
                                    }
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                    <script>
                        $(document).ready(function () {
                            $(".filters").slideToggle();
                            $("#search-option").click(function () {
                                $(".filters").slideToggle();
                            });

                            $(document).on('click', '.user-ststus', function (e) {
                                $.ajax({
                                    type: 'POST',
                                    cache: false,
                                    data: {id: $(this).attr('id')},
                                    url: homeUrl + 'user/user/status-update',
                                    success: function (data) {

                                    }
                                });
                            });
                        });
                    </script>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

