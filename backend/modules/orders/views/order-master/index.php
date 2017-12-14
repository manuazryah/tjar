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

<?php
if (isset(Yii::$app->request->queryParams['order_status']) && (Yii::$app->request->queryParams['order_status'] == 1))
	$user_search_id = 'user_name_' . Yii::$app->request->queryParams['order_status'];
else if (isset(Yii::$app->request->queryParams['order_status']) && (Yii::$app->request->queryParams['order_status'] == 2))
	$user_search_id = 'user_name_' . Yii::$app->request->queryParams['order_status'];
else
	$user_search_id = 'user_name';
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

						<div class="row">

							<div class="col-md-12">

								<ul class="nav nav-tabs">
									<li class="<?= $order_status == '' ? 'active' : '' ?>">
<?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">All Orders</span>', ['index'], ['onclick' => "Select()"]) ?>
									</li>
									<li class="<?= $order_status == 1 ? 'active' : '' ?>">
<?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">Pending</span>', ['index', 'order_status' => 1], ['onclick' => "Select()"]) ?>
									</li>
									<li class="<?= $order_status == 2 ? 'active' : '' ?>">
<?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">Approved</span>', ['index', 'order_status' => 2], ['onclick' => "Select()"]) ?>
									</li>
								</ul>
<?php yii\widgets\Pjax::begin(['id' => 'order-manage']); ?>


								<div class="tab-content">
									<div class="tab-pane active" id="">

										<div class="table-responsive" style="border: none">
											<button class="btn btn-white" id="search-option" style="float: right;">
												<i class="linecons-search"></i>
												<span>Search</span>
											</button>
<?php
if ($search_status == 1) {
	?>
												<script>
													Select();
												</script>
	<?php
}
?>

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
												    'attribute' => 'user_id',
												    'format' => 'raw',
												    'filter' => Html::activeDropDownList($searchModel, 'user_id', ArrayHelper::map(User::find()->all(), 'id', 'first_name'), ['class' => 'form-control', 'id' => $user_search_id, 'prompt' => '']),
												    'value' => function ($data) {
													    return Html::button($data->user->first_name . ' ' . $data->user->last_name, ['value' => Url::to(['user-view', 'id' => $data->user_id]), 'class' => 'modalButton edit-btn']);
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
												    [
												    'attribute' => 'admin_status',
												    'format' => 'raw',
												    'filter' => ['0' => 'Pending', '1' => 'Approved'],
												    'value' => function ($data) {
													    return \yii\helpers\Html::dropDownList('admin_status', null, ['0' => 'Pending', '1' => 'Approved'], ['options' => [$data->admin_status => ['Selected' => 'selected']], 'class' => 'form-control admin_status_field', 'id' => 'order_admin_status-' . $data->id,]);
												    },
												],
												    [
												    'class' => 'yii\grid\ActionColumn',
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
														return Html::a('<span><i class="fa fa-print" aria-hidden="true"></i></span>', $url, [
															    'title' => Yii::t('app', 'print'),
															    'class' => '',
															    'target' => '_blank',
														]);
													},
												    ],
												    'urlCreator' => function ($action, $model) {
													    if ($action === 'view') {
														    $url = Url::to(['view', 'id' => $model->order_id]);
														    return $url;
													    }
													    if ($action === 'print') {
														    $url = Url::to(['print-all', 'id' => $model->order_id]);
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
<?php yii\widgets\Pjax::end(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		Select();
		$(".filters").slideToggle();
		$("#search-option").click(function () {
			$(".filters").slideToggle();
		});




	});

	function Select() {

		$("#user_name").select2({
			placeholder: '',
			allowClear: true
		}).on('select2-open', function ()
		{
			$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
		});

		$("#user_name_1").select2({
			placeholder: '',
			allowClear: true
		}).on('select2-open', function ()
		{
			$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
		});

		$("#user_name_2").select2({
			placeholder: '',
			allowClear: true
		}).on('select2-open', function ()
		{
			$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
		});
	}
</script>
