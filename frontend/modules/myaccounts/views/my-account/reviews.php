<?php

use yii\helpers\Html;
use common\components\LeftMenuWidget;
use yii\widgets\ListView;

/* @var $this yii\web\View */
?>
<div class="container">
        <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-t-b-30 bg-white">
                        <div class="my-account-sidebar">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <h3 class="MyAccount-title">Reviews & Ratings</h3>
                                        <?= LeftMenuWidget::widget() ?>
                                </div>
                        </div>

                        <tbody>
                                <?=
                                ListView::widget([
                                    'dataProvider' => $dataProvider,
                                    'itemView' => 'my_reviews',
                                    'viewParams' => [
                                        'count' => 2 // How to get this variable?
                                    ],
                                    'pager' => [
                                        'firstPageLabel' => 'first',
                                        'lastPageLabel' => 'last',
                                        'prevPageLabel' => '<',
                                        'nextPageLabel' => '>',
                                        'maxButtonCount' => 3,
                                    ],
                                ]);
                                ?>

                </div>
        </div>


        <style>
                .summary{
                        display: none;
                }
        </style>