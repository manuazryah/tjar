<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use common\components\LeftMenuWidget;

$this->title = 'My Orders';

/* @var $this yii\web\View */
?>
<div class="container">
        <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-t-b-30 bg-white">
                        <div class="my-account-sidebar">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <h3 class="MyAccount-title">Orders</h3>
					<?= LeftMenuWidget::widget() ?>
                                </div>
                        </div>

                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <div class="MyAccount-content">
                                        <table class="order-table">
                                                <thead>
                                                        <tr>
                                                                <th class=""><span class="">Order</span></th>
                                                                <th class=""><span class="">Date</span></th>
                                                                <th class=""><span class="">Status</span></th>
                                                                <th class=""><span class="">Total</span></th>
                                                                <th class=""><span class="">Actions</span></th>
                                                        </tr>
                                                </thead>
                                                <tbody>
							<?php
							if ($dataProvider->totalCount > 0) {
								?>
								<?=
								ListView::widget([
								    'dataProvider' => $dataProvider,
								    'itemView' => 'orders',
								    'pager' => [
									'firstPageLabel' => 'first',
									'lastPageLabel' => 'last',
									'prevPageLabel' => '<',
									'nextPageLabel' => '>',
									'maxButtonCount' => 3,
								    ],
								]);
								?>
								<?php
							} else {
								?>

								<?php
							}
							?>
                                                </tbody>
                                        </table>
                                </div>
                        </div>
                </div>
        </div>
</div>

<script>
	$(document).ready(function () {

		/*
		 * on click of the Add new review link
		 * return pop up form for add new review
		 */

		$(document).on('click', '.add-product-review', function (e) {
			e.preventDefault();
			var product = $(this).attr('id');
			$.ajax({
				type: 'POST',
				cache: false,
				async: false,
				data: {product_id: product},
				url: '<?= Yii::$app->homeUrl; ?>myaccounts/my-account/add-review',
				success: function (data) {
					$("#modal-pop-up").html(data);
					$('#modal-6').modal('show', {backdrop: 'static'});
					e.preventDefault();
				}
			});
		});
		/*
		 * on submit of the form add new Principals
		 * return new principal added into Debtor
		 */

		$(document).on('submit', '#submit-reviews', function (e) {
			var str = $(this).serialize();
			$.ajax({
				url: '<?= Yii::$app->homeUrl; ?>myaccounts/my-account/save-review',
				type: "POST",
				data: str,
				success: function (data) {
					$('#modal-6').modal('hide');
				}
			});
			return false;

		});
	});


</script>


<style>

        .rating {
                float:left;
        }

        /* :not(:checked) is a filter, so that browsers that don’t support :checked don’t
           follow these rules. Every browser that supports :checked also supports :not(), so
           it doesn’t make the test unnecessarily selective */
        .rating:not(:checked) > input {
                position:absolute;
                top:-9999px;
                clip:rect(0,0,0,0);
        }

        .rating:not(:checked) > label {
                float:right;
                width:1em;
                padding:0 .1em;
                overflow:hidden;
                white-space:nowrap;
                cursor:pointer;
                font-size:200%;
                line-height:1.2;
                color:#ddd;
                text-shadow:1px 1px #bbb, 2px 2px #666, .1em .1em .2em rgba(0,0,0,.5);
        }

        .rating:not(:checked) > label:before {
                content: '★ ';
        }

        .rating > input:checked ~ label {
                color: #f70;
                text-shadow:1px 1px #c60, 2px 2px #940, .1em .1em .2em rgba(0,0,0,.5);
        }

        .rating:not(:checked) > label:hover,
        .rating:not(:checked) > label:hover ~ label {
                color: gold;
                text-shadow:1px 1px goldenrod, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
        }

        .rating > input:checked + label:hover,
        .rating > input:checked + label:hover ~ label,
        .rating > input:checked ~ label:hover,
        .rating > input:checked ~ label:hover ~ label,
        .rating > label:hover ~ input:checked ~ label {
                color: #ea0;
                text-shadow:1px 1px goldenrod, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
        }

        .rating > label:active {
                position:relative;
                top:2px;
                left:2px;
        }
        form div.required label.control-label:after {
                content:" * ";
                color:red;
        }
        .h4-labels{
                color: #000;
                font-style: italic;
                font-weight: bold;
        }.summary{
                display: none;
        }
</style>