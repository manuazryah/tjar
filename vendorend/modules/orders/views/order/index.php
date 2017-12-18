<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\User;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */

$this->title = 'Order Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <div class="" style="border: none">
                        <div class="table-responsive" style="border: none">
                            <button class="btn btn-white" id="search-option" style="float: right;">
                                <i class="linecons-search"></i>
                                <span>Search</span>
                            </button>
                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'rowOptions' => function ($model, $key, $index, $grid) {
                                    return ['id' => $model['id']];
                                },
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'attribute' => 'order_id',
                                        'format' => 'raw',
                                        'value' => function ($data) {
                                            if (isset($data->order_id)) {
                                                return \yii\helpers\Html::a($data->order_id, ['/orders/order/view-more', 'id' => $data->order_id], ['target' => '_blank']);
                                            } else {
                                                return '';
                                            }
                                        },
                                    ],
                                    [
                                        'attribute' => 'user_id',
                                        'format' => 'raw',
                                        'filter' => Html::activeDropDownList($searchModel, 'user_id', ArrayHelper::map(User::find()->all(), 'id', 'first_name'), ['class' => 'form-control', 'id' => 'user_name', 'prompt' => '']),
                                        'value' => function ($data) {
                                            $name = User::findOne($data->user_id);
                                            return \yii\helpers\Html::a($name->first_name . ' ' . $name->last_name, ['/user/user/update', 'id' => $data->user_id], ['target' => '_blank']);
                                        },
                                    ],
                                    [
                                        'attribute' => 'net_amount',
                                        'value' => function($model) {
                                            return sprintf('%0.2f', $model->net_amount);
                                        },
                                    ],
                                    [
                                        'attribute' => 'order_date',
                                        'value' => function($model) {
                                            return \Yii::$app->formatter->asDatetime($model->order_date, "php:d-M-Y h:i A");
                                        },
                                        'filter' => DateRangePicker::widget(['model' => $searchModel, 'attribute' => 'order_date', 'pluginOptions' => ['format' => 'd-m-Y', 'autoUpdateInput' => false]]),
                                    ],
                                    // 'ship_address_id',
                                    // 'bill_address_id',
                                    // 'currency_id',
                                    // 'user_comment:ntext',
                                    // 'payment_mode',
                                    // 'admin_comment',
                                    [
                                        'attribute' => 'admin_status',
                                        'format' => 'raw',
                                        'filter' => ['0' => 'Pending', '1' => 'Approved'],
                                        'value' => function ($data) {
                                            if ($data->status == 0) {
                                                return 'Pending';
                                            } if ($data->status == 1) {
                                                return 'Approved';
                                            } 
                                        },
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
//                                    'contentOptions' => ['style' => 'width:100px;'],
                                        'header' => 'Actions',
                                        'template' => '{view}{print}',
                                        'buttons' => [
                                            'view' => function ($url, $model) {
                                                return Html::a('<span><i class="fa fa-eye" aria-hidden="true"></i></span>', $url, [
                                                            'title' => Yii::t('app', 'view'),
                                                            'class' => '',
                                                ]);
                                            },
                                            'print' => function ($url, $model) {
//                                            if ($model->status == 4) {
                                                return Html::a('<span><i class="fa fa-print" aria-hidden="true"></i></span>', $url, [
                                                            'title' => Yii::t('app', 'print'),
                                                            'class' => '',
                                                            'target' => '_blank',
                                                ]);
//                                            }
                                            },
                                        ],
                                        'urlCreator' => function ($action, $model) {
                                            if ($action === 'view') {
                                                $url = Url::to(['view-more', 'id' => $model->order_id]);
                                                return $url;
                                            }
                                            if ($action === 'print') {
                                                $url = Url::to(['print', 'id' => $model->order_id]);
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

        $("#user_name").select2({
            placeholder: '',
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
    });
</script>
