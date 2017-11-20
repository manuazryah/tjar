<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductVendor */

$this->title = $model->product->product_name;
$this->params['breadcrumbs'][] = ['label' => 'Product Vendors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	.manage {
		position: relative;
		/*display: inline-block;*/
	}
	.manage:hover .tooltiptext {
		visibility: visible;
	}

	.manage .tooltiptext {
		padding-left: 0px !important;
		padding-right:  0px !important;
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

		/* Position the tooltip */
		position: absolute;
		z-index: 1;
	}
</style>
<div class="row">
        <div class="col-md-12">

                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

				<span class="product_venode_view_span"><?= !empty($model->sku) ? '<br>EAN:' . $model->sku : '' ?></span>

                        </div>
                        <div class="panel-body">
				<?= Html::a('<i class="fa-th-list manage"><span class="tooltiptext">List All</span></i>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                                <div class="panel-body"><div class="product-vendor-view">
                                                <p>
							<?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
							<?=
							Html::a('Delete', ['delete', 'id' => $model->id], [
							    'class' => 'btn btn-danger',
							    'data' => [
								'confirm' => 'Are you sure you want to delete this item?',
								'method' => 'post',
							    ],
							])
							?>
                                                </p>

						<?=
						DetailView::widget([
						    'model' => $model,
						    'attributes' => [
							'id',
							'product_id',
							'vendor_id',
							'qty',
							'price',
							'sku',
							'offer_note:ntext',
							'handling_time:datetime',
							'pick_up_location',
							'free_shipping',
							'courier_handover',
							'conditions:ntext',
							'offer_price',
							'full_fill',
							'warranty',
							'field1',
							'field2',
							'field3',
							'vendor_status',
							'admin_status',
							'expiry_date',
							'CB',
							'UB',
							'DOC',
							'DOU',
						    ],
						])
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


