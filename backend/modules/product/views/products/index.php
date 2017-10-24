<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\ProductMainCategory;
use common\models\ProductCategory;

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


					<?php // echo $this->render('_search', ['model' => $searchModel]); ?>



					<?= Html::a('<i class="fa-th-list"></i><span> Create Products</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
					<button class="btn btn-white" id="search-option" style="float: right;">
						<i class="linecons-search"></i>
						<span>Search</span>
					</button>
					<div class="table-responsive" style="border: none">
						<?=
						GridView::widget([
						    'dataProvider' => $dataProvider,
						    'filterModel' => $searchModel,
						    'columns' => [
							    ['class' => 'yii\grid\SerialColumn'],
							'product_name',
//							'canonical_name',
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
							'category',
							'subcategory',
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

