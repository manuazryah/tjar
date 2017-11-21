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