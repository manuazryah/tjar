<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\ProductMainCategory;
use common\models\ProductCategory;
use yii\helpers\Url;
use common\components\ModalViewWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	.fa{
		font-size: 17px;
	}
	/*	.can_name {
			width: 100px;
			overflow: hidden;
			white-space: nowrap;
			text-overflow: ellipsis;
		}

		.can_name:hover{
			overflow: visible;
			white-space: normal;
			width: auto;
			position: absolute;
			background-color:#FFF;
		}
		.can_name:hover+div {
			margin-top:20px;
		}*/

</style>
<div class="products-index">

	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


				</div>
				<div class="panel-body">


					<?php
					// echo $this->render('_search', ['model' => $searchModel]);
					?>



					<?= Html::a('<i class="fa-th-list"></i><span> Create Products</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>

					<?= ModalViewWidget::widget() ?>
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
//							'product_name',
							[
							    'attribute' => 'canonical_name',
							    'contentOptions' => ['class' => 'can_name'],
							    'value' => function ($data) {
								    if (strlen($data->canonical_name) > 20) {
									    $str = substr($data->canonical_name, 0, 20) . '...';
								    } else {
									    $str = $data->canonical_name;
								    }
								    return $str;
							    },
							],
							    [
							    'attribute' => 'main_category',
							    'filter' => ArrayHelper::map(ProductMainCategory::find()->all(), 'id', 'name'),
							    'value' => 'mainCategory.name'
							],
							    [
							    'attribute' => 'category',
							    'filter' => ArrayHelper::map(ProductCategory::find()->all(), 'id', 'category_name'),
							    'value' => 'categoryName.category_name'
							],
							    [
							    'attribute' => 'gallery_images',
							    'format' => 'raw',
							    'value' => function ($data) {
								    if (!empty($data->gallery_images)) {
									    $img = '<img width="120px" src="' . Yii::$app->homeUrl . '../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $data->id) . '/' . $data->id . '/profile/' . $data->canonical_name . '_thumb.' . $data->gallery_images . '"/>';
									    return $img;
								    }
							    },
							],
//							'subcategory',
							// 'brand',
							// 'item_ean',
							// 'gender',
							// 'main_description:ntext',
							// 'gallery_images',
							// 'related_products',
							// 'search_tags',
							// 'meta_title',
							// 'meta_description:ntext',
							// 'meta_keyword:ntext',
							// 'field1',
							// 'field2',
							// 'field3',
							// 'status',
							// 'CB',
							// 'UB',
							// 'DOC',
							// 'DOU',
							[
							    'class' => 'yii\grid\ActionColumn',
//                                    'contentOptions' => ['style' => 'width:100px;'],
							    'header' => 'Actions',
							    'template' => '{view}{update}{copy}',
							    'buttons' => [
//								'view' => function ($url, $model) {
//									return Html::a('<span class="fa fa-eye"></span>', $url, [
//										    'title' => Yii::t('app', 'view'),
//										    'class' => 'modalButton',
//									]);
//								},
								'view' => function ($url, $model) {
									return Html::button('<i class="fa fa-eye"></i>', ['value' => Url::to(['view', 'id' => $model->id]), 'class' => 'modalButton edit-btn']);
								},
								'update' => function ($url, $model) {
									return Html::a('<span class="fa fa-pencil"></span>', $url, [
										    'title' => Yii::t('app', 'update'),
										    'class' => '',
									]);
								},
								'delete' => function ($url, $model) {
									return Html::a('<span class="fa fa-trash-o"></span>', $url, [
										    'title' => Yii::t('app', 'delete'),
										    'class' => '',
									]);
								},
								'copy' => function ($url, $model) {
									return Html::a('<span class="fa fa-copyright"></span>', $url, [
										    'title' => Yii::t('app', 'copy'),
										    'class' => '',
									]);
								},
							    ],
							    'urlCreator' => function ($action, $model) {
//								    if ($action === 'view') {
//									    $url = Url::to(['view', 'id' => $model->id]);
//									    return $url;
//								    }
								    if ($action === 'update') {
									    $url = Url::to(['update', 'id' => $model->id]);
									    return $url;
								    }
								    if ($action === 'delete') {
									    $url = Url::to(['delete', 'id' => $model->id]);
									    return $url;
								    }
								    if ($action === 'copy') {
									    $url = Url::to(['create', 'id' => $model->id]);
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
	});
</script>

