<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Products;
use common\models\ProductVendor;
use common\models\Vendors;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StockHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-history-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="panel-body">

                    <div class="row" style="margin-left: 0px;margin-bottom: 20px;">
                        <div class="col-md-12" style="padding: 0px;">

                            <?= $this->render('_search', ['model' => $searchModel, 'from' => $from, 'to' => $to]) ?>

                        </div>

                    </div>

                    <?= Html::a('<i class="fa-th-list"></i><span> Create Stock History</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>

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
                                'id',
                                'products_id',
                                'productvendor_id',
                                'qty',
                                // 'total_stock',
                                // 'purpose',
                                // 'DOC',
                                ['class' => 'yii\grid\ActionColumn'],
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

