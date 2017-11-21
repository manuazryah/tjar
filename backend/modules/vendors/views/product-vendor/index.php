<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\User;
use common\models\Products;
use common\models\Vendors;

/* @var $this yii\web\View */

$this->title = 'Product Management';
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
</style>
<div class="products-index">
	<?php
	yii\bootstrap\Modal::begin([
	    'headerOptions' => ['id' => 'modalHeader'],
	    'id' => 'modal',
	    'size' => 'modal-lg',
	    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
	]);
	?>
	<div id='modalContent'></div>;
	<?php yii\bootstrap\Modal::end(); ?>

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
								<?php yii\widgets\Pjax::begin(['id' => 'vendor_product_manage']); ?>

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
										<?= Html::a('<span class="visible-xs"><i class=" fa-calendar"></i></span><i class="fa  fa-calendar" aria-hidden="true"></i><span class="hidden-xs">Expired</span>', ['index', 'expiry' => 1], ['class' => '']) ?>
									</li>
									<li class="<?= $soldout == 1 ? 'active' : '' ?>">
										<?= Html::a('<span class="visible-xs"><i class="fa-ban"></i></span><i class="fa fa-list" aria-hidden="true"></i><span class="hidden-xs">SoldOut</span>', ['index', 'soldout' => 1], ['class' => '']) ?>
									</li>
									<li class="<?= $vendor_status == 2 ? 'active' : '' ?>">
										<?= Html::a('<span class="visible-xs"><i class="fa-pause"></i></span><i class="fa fa-pause" aria-hidden="true"></i><span class="hidden-xs">Paused</span>', ['index', 'vendor_status' => 2], ['class' => '']) ?>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="">
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
												    return ['data-id' => $model->id];
											    },
											    'columns' => [
												    ['class' => 'yii\grid\SerialColumn'],
//
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
												    'attribute' => 'vendor_id',
												    'label' => 'Vendor',
												    'format' => 'raw',
												    'filter' => ArrayHelper::map(Vendors::find()->all(), 'id', 'first_name'),
												    'value' => function ($model) {
													    return Html::button($model->vendor->first_name . ' ' . $model->vendor->last_name, ['value' => Url::to(['vendor-view', 'id' => $model->vendor_id]), 'class' => 'modalButton edit-btn']);
												    },
												],
												'qty',
//												'price',
												[
												    'attribute' => 'price',
												    'header' => 'Price',
												    'filter' => Html::dropDownList('ProductVendor[compareOp]', $model->compareOp, array('>' => '>', '<' => '<', '>=' => '>=', '<=' => '<=', '=' => '='), array('style' => 'width:35px;height: 25px;', 'id' => 'grid-id')) .
												    Html::textInput('ProductVendor[compare]', $model->compare, array('style' => 'width:100px;margin-left: 10px;height: 25px;'))
												],
												    [
												    'attribute' => 'vendor_status',
												    'format' => 'raw',
												    'filter' => ['1' => 'Live', '2' => 'Paused'],
												    'value' => function ($data) {
													    return $data->vendor_status == 1 ? 'Live' : 'Paused';
												    },
												],
												    [
												    'attribute' => 'admin_status',
												    'format' => 'raw',
												    'filter' => ['1' => 'pending', '2' => 'Approved', '3' => 'Rejected'],
												    'value' => function ($data) {
													    return \yii\helpers\Html::dropDownList('admin_status', null, ['1' => 'Pending', '2' => 'Approved', '3' => 'Rejected'], ['options' => [$data->admin_status => ['Selected' => 'selected']], 'class' => 'form-control admin_status_field', 'id' => 'vendor_pdt_admin_status-' . $data->id,]);
												    },
												],
//												,
//												['class' => 'yii\grid\ActionColumn'],
											    ],
											]);
											?>
										</div>
									</div>

								</div>


								<?php yii\widgets\Pjax::end(); ?>
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
            location.href = '" . Url::to(['product-vendor/view']) . "?id=' + id;
    });

");
?>
<script>



	$(document).ready(function () {
//		$('td').click(function (e) {
//			var id = $(this).closest('tr').data('id');
//
//			$.ajax({
//				url: homeUrl + 'vendors/product-vendor/test',
//				type: "post",
//				data: {id: id},
//				success: function (data) {
//					$.pjax.reload({container: '#vendor_product_manage'});
//				}, error: function () {
//				}
//			});
//		});
		$(".filters").slideToggle();
		$("#search-option").click(function () {
			$(".filters").slideToggle();
		});
		$('#grid-id').change(function (e) {
			e.preventDefault();
			return false;
		});
		$(document).on('change', '.admin_status_field', function (e) {
			var change_id = $(this).attr('id').match(/\d+/);

			var admin_status = $(this).val();
			$.ajax({
				url: homeUrl + 'vendors/product-vendor/change-admin-status',
				type: "post",
				data: {status: admin_status, id: change_id},
				success: function (data) {
					alert('Status Changed Sucessfully');
					$.pjax.reload({container: '#vendor_product_manage'});
				}, error: function () {
				}
			});
		});
//        $('.orders').on('click', function () {
//            $.pjax.reload({container: '#order-manage'});
//        });
	});
</script>
