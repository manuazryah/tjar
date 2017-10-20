<?php

use yii\helpers\Html;
use common\models\Fregrance;
use common\components\ProductLinksWidget;
?>
<?php
if (!empty($recently_viewed)) {
	?>
	<div class="international-brands">
		<h1>Recently viewed</h1>
		<div class="product-slider">
			<div id="adv_gp_products_1_columns_carousel" class="carousel slide four_shows_one_move gp_products_carousel_wrapper" data-ride="carousel" data-interval="2000">
				<!--========= Wrapper for slides =========-->
				<div class="carousel-inner" role="listbox">

					<!--========= 1st slide =========-->
					<?php
					$j = 0;
					$k = 1;
					foreach ($recently_viewed as $recent) {
						$j++;
						$model = \common\models\Product::findOne($recent->product_id);
						if ($model) {
							?>
							<div class="item <?php
							if ($j == 1) {
								echo ' active';
							}
							?> " >
								<div class="col-xs-12 col-sm-6 col-md-3 gp_products_item">
									<?= ProductLinksWidget::widget(['id' => $model->id, 'div_id' => $k]) ?>
								</div>
							</div>
							<?php
						}
						$k++;
					}
					?>



				</div>

				<!--======= Navigation Buttons =========-->

				<!--======= Left Button =========-->
				<a class="left carousel-control gp_products_carousel_control_left" href="#adv_gp_products_1_columns_carousel" role="button" data-slide="prev">
					<span class="fa fa-angle-left gp_products_carousel_control_icons" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>

				<!--======= Right Button =========-->
				<a class="right carousel-control gp_products_carousel_control_right" href="#adv_gp_products_1_columns_carousel" role="button" data-slide="next">
					<span class="fa fa-angle-right gp_products_carousel_control_icons" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>

			</div> <!--*-*-*-*-*-*-*-*-*-*- END BOOTSTRAP CAROUSEL *-*-*-*-*-*-*-*-*-*-->
		</div>
	</div>
	<?php
}
?>

