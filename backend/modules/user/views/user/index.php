<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

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



                                        <?= Html::a('<i class="fa-th-list"></i><span> Create User</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
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
                                                            'template' => '{update}{status}',
                                                            'buttons' => [
                                                                'status' => function ($url, $model) {
                                                                        return Html::checkbox('status', $model->status == 1 ? true : false, ['class' => 'iswitch iswitch-secondary user-ststus', 'id' => $model->id,]);
                                                                },
                                                                'update' => function ($url, $model) {
                                                                        return Html::a('<span class="glyphicon glyphicon-pencil" style="padding-top: 0px;font-size: 18px;"></span>', $url, [
                                                                                    'title' => Yii::t('app', 'print'),
                                                                                    'class' => 'actions',
                                                                        ]);
                                                                },
                                                            ],
                                                            'urlCreator' => function ($action, $model) {
                                                                    if ($action === 'update') {
                                                                            $url = Url::to(['user/update', 'id' => $model->id]);
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
