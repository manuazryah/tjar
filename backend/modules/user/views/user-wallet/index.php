<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\User;
use yii\helpers\Url;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserWalletSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wallet History of' . $user_model->first_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	.flt_right_btn{
		float: right;
	}
</style>
<div class="user-wallet-index">

	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title" style="float: left"><?= Html::encode($this->title) ?></h3>
					<?= Html::a('<span>Users</span>', ['/user/user/index'], ['class' => 'btn btn-secondary flt_right_btn']) ?>

				</div>
				<div class="panel-body">


					<?php // echo $this->render('_search', ['model' => $searchModel]);  ?>



					<?php // Html::a('<i class="fa-th-list"></i><span> Create User Wallet</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone'])  ?>

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
//							'id',
							[
							    'attribute' => 'entry_date',
							    'value' => function($data) {
								    return \Yii::$app->formatter->asDatetime($data->entry_date, "php:d-M-Y h:i A");
							    },
							    'filter' => DateRangePicker::widget(['model' => $searchModel, 'attribute' => 'entry_date', 'pluginOptions' => ['format' => 'd-m-Y', 'autoUpdateInput' => false]]),
							],
							'entry_date',
//							[
//							    'attribute' => 'user_id',
//							    'format' => 'raw',
//							    'value' => function($data) {
//								    return $data->user->first_name;
//							    },
//							    'filter' => ArrayHelper::map(User::find()->all(), 'id', 'first_name'),
//							],
							[
							    'attribute' => 'credit_debit',
							    'value' => function($data) {
								    return $data->credit_debit == '1' ? 'Credit' : 'Debit';
							    },
							    'filter' => [1 => 'Credit', 2 => 'Debit',]
							],
//							'type_id',
							'amount',
//							'credit_debit',
							'balance_amount',
							'reference_id',
						    // 'comment:ntext',
						    // 'field_2',
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

