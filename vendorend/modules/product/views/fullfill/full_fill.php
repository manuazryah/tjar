<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\User;

/* @var $this yii\web\View */

$this->title = 'Order Full Filled by Tjar';
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
                                                                                    return \yii\helpers\Html::a($data->order_id, ['/orders/order-master/view', 'id' => $data->order_id], ['target' => '_blank']);
                                                                            } else {
                                                                                    return '';
                                                                            }
                                                                    },
                                                                ],
                                                                    [
                                                                    'attribute' => 'product_id',
                                                                    'value' => function($model) {
                                                                            $product_vendor = \common\models\ProductVendor::findOne($model->product_id);
                                                                            if (!empty($product_vendor)) {
                                                                                    $product_detail = common\models\Products::findOne($product_vendor->product_id);
                                                                                    if (isset($product_detail->product_name)) {
                                                                                            return $product_detail->product_name;
                                                                                    } else {
                                                                                            return '';
                                                                                    }
                                                                            }
                                                                    },
                                                                    'filter' => ArrayHelper::map(common\models\ProductVendor::find()->where(['admin_status' => 2, 'full_fill' => 1, 'vendor_id' => Yii::$app->user->identity->id])->all(), 'id', 'productName'),
                                                                    'filterOptions' => array('id' => "product_name_search"),
                                                                ],
                                                                'quantity',
                                                                'sub_total',
                                                                    [
                                                                    'attribute' => 'status',
                                                                    'format' => 'raw',
                                                                    'filter' => ['0' => 'Pending', '1' => 'Approved'],
                                                                    'value' => function ($data) {
                                                                            return \yii\helpers\Html::dropDownList('admin_status', null, ['0' => 'Pending', '1' => 'Approved'], ['options' => [$data->admin_status => ['Selected' => 'selected']], 'class' => 'form-control admin_status_field', 'id' => 'order_admin_status-' . $data->id,]);
                                                                    },
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

                $('#product_name_search select').attr('id', 'full_fill_product');
                $("#full_fill_product").select2({
                        placeholder: '',
                        allowClear: true
                }).on('select2-open', function ()
                {
                        // Adding Custom Scrollbar
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                });
        });
</script>
