<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\helpers\ArrayHelper;
use common\models\Products;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CustomerReviewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Reviews';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
        .fa-check{
                color: green;
        }
        .fa-ban{
                color:red;
        }
</style>
<div class="customer-reviews-index">

        <div class="row">
                <div class="col-md-12">

                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                                </div>
                                <div class="panel-body">


                                        <?php // echo $this->render('_search', ['model' => $searchModel]);    ?>



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
                                                            'attribute' => 'user_id',
                                                            'format' => 'raw',
                                                            'value' => function($data) {
                                                                    $user = User::findOne($data->user_id);
                                                                    if (isset($user)) {
                                                                            return Html::button($user->first_name, ['value' => Url::to(['user-view', 'id' => $user->id]), 'class' => 'modalButton edit-btn']);
                                                                    }
                                                            },
                                                            'filter' => Html::activeDropDownList($searchModel, 'user_id', ArrayHelper::map(User::find()->all(), 'id', 'first_name'), ['class' => 'form-control', 'id' => 'user_name', 'prompt' => '']),
                                                        ],
                                                            [
                                                            'attribute' => 'product_id',
                                                            'format' => 'raw',
                                                            'value' => function($data) {
                                                                    if (isset($data->product_id)) {

                                                                            $vendor_product = common\models\ProductVendor::findOne($data->product_id);
                                                                            $product_details = Products::findOne($vendor_product->product_id);
                                                                            if (isset($product_details) && $product_details->product_name != '')
                                                                                    return Html::button($product_details->product_name, ['value' => Url::to(['product-view', 'id' => $product_details->id]), 'class' => 'modalButton edit-btn']);
                                                                            else
                                                                                    return '';
                                                                    }
                                                            },
                                                            'filter' => ArrayHelper::map(common\models\ProductVendor::find()->where(['vendor_status' => 1, 'admin_status' => 2])->all(), 'id', 'productName'),
                                                            'filterOptions' => array('id' => "product_name_search"),
                                                        ],
                                                        'title',
                                                        'description',
//                                [
//                                    'attribute' => 'description',
//                                    'value' => function($data) {
//                                        $str = substr($data->description, 0, strpos(wordwrap($data->description, 100), "\n"));
//                                        if (strlen($data->description) > 100) {
//                                            $dot = ' ....';
//                                        } else {
//                                            $dot = '';
//                                        }
//                                        return $str . $dot;
//                                    },
//                                ],
//                                'description:ntext',
                                                        // 'review_date',
                                                        // 'status',
                                                        [
                                                            'attribute' => 'rating',
                                                            'value' => function($model) {
                                                                    if (isset($model->rating) && $model->rating != '') {
                                                                            return $model->rating;
                                                                    } else {
                                                                            return '';
                                                                    }
                                                            },
                                                        ],
                                                            [
                                                            'class' => 'yii\grid\ActionColumn',
                                                            'contentOptions' => [],
                                                            'header' => 'Actions',
                                                            'template' => '{edit}{delete}{approve}{disable}',
                                                            'buttons' => [
                                                                //view button
                                                                'edit' => function ($url, $model) {
                                                                        return Html::a('<span class="fa fa-pencil" style="padding-top: 0px;"></span>', $url, [
                                                                                    'title' => Yii::t('app', 'Edit'),
                                                                                    'class' => 'actions',
                                                                        ]);
                                                                },
                                                                'delete' => function ($url, $model) {
                                                                        return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', $url, [
                                                                                    'title' => Yii::t('app', 'Delete'),
                                                                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                                                    'class' => 'actions',
                                                                        ]);
                                                                },
                                                                'approve' => function ($url, $model) {
                                                                        if ($model->status == 0) {
                                                                                return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', $url, [
                                                                                            'title' => Yii::t('app', 'Approve'),
                                                                                            'class' => 'actions',
                                                                                ]);
                                                                        }
                                                                },
                                                                'disable' => function ($url, $model) {
                                                                        if ($model->status == 1) {
                                                                                return Html::a('<i class="fa fa-ban" aria-hidden="true"></i>', $url, [
                                                                                            'title' => Yii::t('app', 'Disable'),
                                                                                            'class' => 'actions',
                                                                                ]);
                                                                        }
                                                                },
                                                            ],
                                                            'urlCreator' => function ($action, $model) {
                                                                    if ($action === 'edit') {
                                                                            $url = Url::to(['update', 'id' => $model->id]);
                                                                            return $url;
                                                                    }
                                                                    if ($action === 'delete') {
                                                                            $url = Url::to(['del', 'id' => $model->id]);
                                                                            return $url;
                                                                    }
                                                                    if ($action === 'approve') {
                                                                            $url = Url::to(['approve', 'id' => $model->id]);
                                                                            return $url;
                                                                    }
                                                                    if ($action === 'disable') {
                                                                            $url = Url::to(['disable', 'id' => $model->id]);
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

                $('#product_name_search select').attr('id', 'product_name');
                $("#product_name").select2({
                        placeholder: '',
                        allowClear: true
                }).on('select2-open', function ()
                {
                        // Adding Custom Scrollbar
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
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

