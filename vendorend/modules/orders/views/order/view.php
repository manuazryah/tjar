<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Products;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-master-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">


                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


                    <?= Html::a('<i class="fa-th-list"></i><span> Manage Order </span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?= Html::a('<i class="fa fa-print"></i><span>Print</span>', ['print', 'id' => $id], ['class' => 'btn btn-secondary btn-icon btn-icon-standalone']) ?>
                    <div class="table-responsive" style="border: none">
                        <button class="btn btn-white" id="search-option" style="float: right;">
                            <i class="linecons-search"></i>
                            <span>Search</span>
                        </button>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
//                                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'order_id',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if (isset($data->order_id)) {
                                            return \yii\helpers\Html::a($data->order_id, ['/orders/order/view', 'id' => $data->order_id], ['target' => '_blank']);
                                        } else {
                                            return '';
                                        }
                                    },
                                ],
                                [
                                    'attribute' => 'product_id',
                                    'value' => function($data) {
                                        $name = Products::findOne($data->product_id)->product_name;
                                        return $name;
                                    }
                                ],
                                'quantity',
                                'amount',
//                                                'sub_total',
//
                                [
                                    'attribute' => 'status',
                                    'format' => 'raw',
                                    'filter' => ['0' => 'Pending', '1' => 'Confirm', '1' => 'Canceled'],
                                    'value' => function ($data) {
                                        return \yii\helpers\Html::dropDownList('status', null, ['0' => 'Pending', '1' => 'Confirm', '2' => 'Canceled'], ['options' => [$data->status => ['Selected' => 'selected']], 'class' => 'form-control admin_status_field', 'id' => 'order_admin_status-' . $data->id,]);
                                    },
                                ],
                                'delivered_date',
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
        $('.admin_status_field').on('change', function () {
            var change_id = $(this).attr('id').match(/\d+/);
            var order_status = $(this).val();
            $.ajax({
                url: homeUrl + 'orders/order/change-order-status',
                type: "post",
                data: {status: order_status, id: change_id},
                success: function (data) {
                    alert('Status Changed Sucessfully');
                }, error: function () {
                }
            });
        });
    });
</script>

