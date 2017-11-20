<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Products;
use common\components\ModalViewWidget;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
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
					<?= ModalViewWidget::widget() ?>
                                        <div class="table-responsive" style="border: none">

                                                <button class="btn btn-white" id="search-option" style="float: right;">
                                                        <i class="linecons-search"></i>
                                                        <span>Search</span>
                                                </button>
						<?php Pjax::begin(); ?>
						<?=
						GridView::widget([
						    'dataProvider' => $dataProvider,
						    'filterModel' => $searchModel,
						    'columns' => [
							    ['class' => 'yii\grid\SerialColumn'],
							    [
							    'attribute' => 'product_id',
							    'filter' => ArrayHelper::map(Products::find()->all(), 'id', 'product_name'),
							    'value' => 'product.product_name'
							],
							    [
							    'attribute' => 'qty',
							    'format' => 'raw',
							    'value' => function ($data) {
								    return \yii\helpers\Html::textInput('qty', $data->qty, ['class' => 'form-control product_form', 'id' => 'product_qty_' . $data->id, 'type' => 'number']);
							    },
							],
							    [
							    'attribute' => 'price',
							    'format' => 'raw',
							    'value' => function ($data) {
								    return \yii\helpers\Html::textInput('price', $data->price, ['class' => 'form-control product_form', 'id' => 'product_price_' . $data->id]);
							    },
							],
							'sku',
							    [
							    'attribute' => 'offer_price',
							    'format' => 'raw',
							    'value' => function ($data) {
								    return \yii\helpers\Html::textInput('offer_price', $data->offer_price, ['class' => 'form-control product_form', 'id' => 'product_offer_price_' . $data->id]);
							    },
							],
							    [
							    'attribute' => 'vendor_status',
							    'format' => 'raw',
							    'filter' => ['1' => 'Enabled', '0' => 'Disabled'],
							    'value' => function ($data) {
								    return \yii\helpers\Html::dropDownList('vendor_status', null, ['1' => 'Enabled', '0' => 'Disabled'], ['options' => [$data->vendor_status => ['Selected' => 'selected']], 'class' => 'form-control product_form', 'id' => 'product_status_' . $data->id,]);
							    },
							],
							    [
							    'class' => 'yii\grid\ActionColumn',
//                                    'contentOptions' => ['style' => 'width:100px;'],
							    'header' => 'Actions',
							    'template' => '{view}{delete}',
							    'buttons' => [
								'view' => function ($url, $model) {
									return Html::button('<i class="fa fa-eye"></i>', ['value' => Url::to(['view', 'id' => $model->id]), 'class' => 'modalButton edit-btn']);
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
						<?php Pjax::end(); ?>
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

		$('.product_form').on('change', function () {

			var res = $(this).attr('id').match(/\d+/);
			var qty = $('#product_qty_' + res).val();
			var price = $('#product_price_' + res).val();
			var offerprice = $('#product_offer_price_' + res).val();
			var status = $('#product_status_' + res).val();

			$.ajax({
				url: homeUrl + 'product/product/ajaxchange-product',
				type: "post",
				data: {qty: qty, price: price, offerprice: offerprice, status: status, id: res},
				success: function (data) {
					var $data = JSON.parse(data);
					if ($data.msg === "success") {
						alert($data.title);
					} else {
						alert($data.title);
					}
				}, error: function () {
				}
			});
		});
	});
</script>

