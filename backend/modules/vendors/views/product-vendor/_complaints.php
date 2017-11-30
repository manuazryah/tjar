<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserComplaintsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Complaints';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-complaints-index">

	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


				</div>
				<div class="panel-body">


					<?php // echo $this->render('_search', ['model' => $searchModel]); ?>



					<?= Html::a('<span>Back</span>', ['view', 'id' => $id], ['class' => 'btn btn-blue']) ?>

					<div class="table-responsive" style="border: none">
						<!--						<button class="btn btn-white" id="search-option" style="float: right;">
													<i class="linecons-search"></i>
													<span>Search</span>
												</button>-->

						<?=
						GridView::widget([
						    'dataProvider' => $dataProvider,
						    'filterModel' => $searchModel,
						    'columns' => [
							    ['class' => 'yii\grid\SerialColumn'],
							    [
							    'attribute' => 'user_id',
							    'label' => 'user',
							    'format' => 'raw',
							    'filter' => ArrayHelper::map(common\models\User::find()->all(), 'id', 'first_name'),
							    'value' => function ($model) {
								    return Html::button($model->user->first_name, ['value' => Url::to(['user-view', 'id' => $model->user_id]), 'class' => 'modalButton edit-btn']);
//								    return $model->user->first_name;
							    },
							],
							    [
							    'attribute' => 'vendor_id',
							    'label' => 'Vendor Name',
							    'format' => 'raw',
							    'filter' => ArrayHelper::map(\common\models\Vendors::find()->all(), 'id', 'first_name'),
							    'value' => function ($model) {
								    return Html::button($model->vendor->first_name, ['value' => Url::to(['vendor-view', 'id' => $model->vendor_id]), 'class' => 'modalButton edit-btn']);
//								    return $model->vendor->first_name;
							    },
							],
							'complaint',
//							'product_id',
//							'product_name',
						    // 'status',
						    // 'CB',
						    // 'UB',
						    // 'DOC',
						    // 'DOU',
//							['class' => 'yii\grid\ActionColumn'],
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
			alert("fdgfd");
			$(".filters").slideToggle();
		});
	});
</script>

