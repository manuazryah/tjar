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

<style>
        .tab-content{
                background: #f9f9f9 !important;
        }
        .nav.nav-tabs>li>a {
                background-color: #f9f9f9;
        }
        .nav.nav-tabs>li {
                background: #f9f9f9;
        }
        .nav.nav-tabs>li.active>a {
                background-color: #f9f9f9 !important;
        }
        .nav.nav-tabs.nav-tabs-justified, .nav-tabs-justified .nav.nav-tabs {
                background: #f9f9f9;
        }
        .nav.nav-tabs>li>a:hover {
                background-color: #f9f9f9;
        }
        .nav-tabs {
                border-bottom: 1px solid #f9f9f9 !important;
        }
        .hidden-xs{
                padding-left: 5px;
        }
        /*        .url_gen {
                        position: relative;
                        display: inline-block;
                }*/
        /*        .url_gen:hover .tooltiptext {
                        visibility: visible;
                }*/

        /*        .url_gen .tooltiptext {
                        visibility: hidden;
                        width: 55px;
                        background-color: black;
                        color: #fff;
                        text-align: center;
                        border-radius: 6px;
                        padding: 5px 0;
                        position: absolute;
                        z-index: 1;
                        font-size: 14px;

                         Position the tooltip
                        position: absolute;
                        z-index: 1;
                }*/
        #copy_url{
                position: relative;
        }
        .tooltiptext{
                position: absolute;
                opacity: 0;
                word-break: break-all;
                background: black;
                width: 100px;
                transition: 400ms;
        }
        #copy_url:hover .tooltiptext{
                opacity: 1;
        }
        .hover{
                position: relative;
        }
        .hover-box{
                position: absolute;
                opacity: 0;
                word-break: break-all;
                background: black;
                width: 100px;
                transition: 400ms;
                left: 0px;
        }
        .hover:hover .hover-box{
                opacity: 2;
        }


</style>

<div class="products-index">
        <div class="row">
                <div class="col-md-12">

                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                                </div>
                                <div class="panel-body">
                                        <div class="" style="border: none">

                                                <div class="row">

                                                        <div class="col-md-12">

                                                                <ul class="nav nav-tabs">
                                                                        <li class="<?= ( $vendor_status == '' && $admin_status == '' && $soldout == '' && $expiry == '') ? 'active' : '' ?>">
										<?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">All</span>', ['index'], ['class' => '']) ?>
                                                                        </li>
                                                                        <li class="<?= $vendor_status == 1 ? 'active' : '' ?>">
										<?= Html::a('<span class="visible-xs"><i class="fa-desktop"></i></span><i class="fa fa-desktop" aria-hidden="true"></i><span class="hidden-xs">Live</span>', ['index', 'vendor_status' => 1], ['class' => '']) ?>
                                                                        </li>
                                                                        <li class="<?= $admin_status == 1 ? 'active' : '' ?>">
										<?= Html::a('<span class="visible-xs"><i class="fa-clock-o"></i></span><i class="fa fa-clock-o" aria-hidden="true"></i><span class="hidden-xs">Pending</span>', ['index', 'admin_status' => 1], ['class' => '']) ?>
                                                                        </li>
                                                                        <li class="<?= $admin_status == 3 ? 'active' : '' ?>">
										<?= Html::a('<span class="visible-xs"><i class="fa-ban"></i></span><i class="fa fa-ban" aria-hidden="true"></i><span class="hidden-xs">Rejected</span>', ['index', 'admin_status' => 3], ['class' => '']) ?>
                                                                        </li>
                                                                        <li class="<?= $expiry == 1 ? 'active' : '' ?>">
										<?= Html::a('<span class="visible-xs"><i class="fa-calendar"></i></span><i class="fa  fa-calendar" aria-hidden="true"></i><span class="hidden-xs">Expired</span>', ['index', 'expiry' => 1], ['class' => '']) ?>
                                                                        </li>
                                                                        <li class="<?= $soldout == 1 ? 'active' : '' ?>">
										<?= Html::a('<span class="visible-xs"><i class="fa-ban"></i></span><i class="fa fa-list" aria-hidden="true"></i><span class="hidden-xs">SoldOut</span>', ['index', 'soldout' => 1], ['class' => '']) ?>
                                                                        </li>
                                                                        <li class="<?= $vendor_status == 2 ? 'active' : '' ?>">
										<?= Html::a('<span class="visible-xs"><i class="fa-pause"></i></span><i class="fa fa-pause" aria-hidden="true"></i><span class="hidden-xs">Paused</span>', ['index', 'vendor_status' => 2], ['class' => '']) ?>
                                                                        </li>
                                                                        <!--                                                                        <a href="" class="hover">fhdgb
                                                                                                                                                        <div class="hover-box">
                                                                                                                                                                <p>The lowest price offered by a seller on Souq right now is  180.00 Offering the lowest price gives you a higher chance of selling.</p>
                                                                                                                                                        </div>
                                                                                                                                                </a>-->


                                                                </ul>

								<?= ModalViewWidget::widget() ?>
                                                                <div class="tab-content">
                                                                        <div class="tab-pane active" id="">
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
											    'rowOptions' => function ($model, $key, $index, $grid) {
												    return ['data-id' => $model->id];
											    },
											    'columns' => [
												    ['class' => 'yii\grid\SerialColumn'],
												    [
												    'attribute' => 'product_id',
												    'label' => 'Product Name',
												    'format' => 'raw',
												    'filter' => ArrayHelper::map(Products::find()->all(), 'id', 'product_name'),
												    'value' => function ($model) {
													    $img = '<img  src="' . Yii::$app->homeUrl . '../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $model->product_id) . '/' . $model->product_id . '/profile/' . $model->product->canonical_name . '_thumb.' . $model->product->gallery_images . '"/>';

													    return $img . Html::button($model->product->product_name, ['value' => Url::to(['product-view', 'id' => $model->product_id]), 'class' => 'modalButton edit-btn']);
												    },
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
													    $product_price = $data->CheckProductPrice($data->product_id, $data->price, 1);
													    if ($product_price == 1) {
														    $productprice = $data->CheckProductPrice($data->product_id, $data->price, 2);
														    return \yii\helpers\Html::textInput('price', $data->price, ['class' => 'form-control product_form', 'id' => 'product_price_' . $data->id]) .
															    '<button id="copy_url" class="url_gen" style="background-color: white; position: relative;padding-top: 10px;font-size: 12px;border:none;float: right;" title="The lowest price offered by a seller on Tjar right now is  ' . $productprice . ' Offering the lowest price gives you a higher chance of selling."><i class="fa fa-exclamation-triangle" aria-hidden="true" style="color:#e5bd00"></i>

                                                                                                                               </button>'
														    ;
													    } else {
														    return \yii\helpers\Html::textInput('price', $data->price, ['class' => 'form-control product_form', 'id' => 'product_price_' . $data->id]);
													    }
												    },
												],
												//  'sku',
												[
												    'attribute' => 'offer_price',
												    'format' => 'raw',
												    'value' => function ( $data) {
													    return \yii\helpers\Html::textInput('offer_price', $data->offer_price, ['class' => 'form-control product_form', 'id' => 'product_offer_price_' . $data->id]) .
														    '<label id="offer_price" style="color:#cc3f44"class="hide">Offer price must be less than price</label>';
												    },
												],
												    [
												    'attribute' => 'vendor_status',
												    'format' => 'raw',
												    'filter' => ['1' => 'Live', '0' => 'Pause'],
												    'value' => function ($data) {
													    return \yii\helpers\Html::dropDownList('vendor_status', null, ['0' => 'Select', '1' => 'Live', '2' => 'Pause'], ['options' => [$data->vendor_status => ['Selected' => 'selected']], 'class' => 'form-control product_form', 'id' => 'product_status_' . $data->id,]);
												    },
												],
//                                                                                                    [
//                                                                                                    'class' => 'yii\grid\ActionColumn',
//                                                                                                    'header' => 'Actions',
//                                                                                                    'template' => '{view}',
//                                                                                                    'buttons' => [
//                                                                                                        'view' => function ($url, $model) {
//                                                                                                                return Html::button('<i class="fa fa-eye"></i>', ['value' => Url::to(['view', 'id' => $model->id]), 'class' => 'modalButton edit-btn']);
//                                                                                                        },
//                                                                                                    ],
//                                                                                                    'urlCreator' => function ($action, $model) {
//                                                                                                            if ($action === 'delete') {
//                                                                                                                    $url = Url::to(['del', 'id' => $model->id]);
//                                                                                                                    return $url;
//                                                                                                            }
//                                                                                                    }
//                                                                                                ],
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
                                </div>
                        </div>
                </div>
        </div>
</div>

<?php
$this->registerJs("
$(document).on('click', 'td', function (e) {
        var id = $(this).closest('tr').data('id');
        if(e.target == this)
            location.href = '" . Url::to(['product/view']) . "?id=' + id;
    });

");
?>

<script>
	$(document).ready(function () {
		$(".filters").slideToggle();
		$("#search-option").click(function () {
			$(".filters").slideToggle();
		});

		$('.product_form').on('change', function () {
			$('#offer_price').addClass('hide');
			var res = $(this).attr('id').match(/\d+/);
			var qty = $('#product_qty_' + res).val();
			var price = $('#product_price_' + res).val();
			var offerprice = $('#product_offer_price_' + res).val();
			var status = $('#product_status_' + res).val();
			if (offerprice >= price) {
				$('#offer_price').removeClass('hide');
			} else {
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
			}
		});
	});
</script>

