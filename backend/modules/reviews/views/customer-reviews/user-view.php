<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Products */

$this->title = $model->first_name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
        .product-vew-pop{
                /*background: #ececec;*/
                padding: 25px 12px;
                border: 1px solid #ababab;
        }
        .pro-img-left{
                border: 1px solid;
                padding: 16px 15px;
                background: white;
        }
        .panel .panel-body {
                padding-top: 0px;
        }
        h2{
                margin-top: 0px;
                color: #272727;
                text-transform: capitalize;
        }
</style>
<div class="row">
        <div class="col-md-12">

                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                        </div>
                        <div class="panel-body">
                                <div class="panel-body"><div class="products-view">
                                                <div class="product-vendor-view">


                                                        <div class="panel panel-default">
                                                                <div class="panel-body">
                                                                        <div class="panel-body">
                                                                                <div class="col-md-12 col-lg-12 col-sm-12 product-vew-pop">

                                                                                        <div class="col-md-8">
                                                                                                <?=
                                                                                                DetailView::widget([
                                                                                                    'model' => $model,
                                                                                                    'attributes' => [
                                                                                                        'first_name',
                                                                                                        'last_name',
                                                                                                        'email',
                                                                                                        'mobile_number',
                                                                                                            [
                                                                                                            'attribute' => 'gender',
                                                                                                            'value' => function($model) {
                                                                                                                    if (isset($model->gender)) {
                                                                                                                            if ($model->gender == 0)
                                                                                                                                    return 'Male';
                                                                                                                            else if ($model->gender == 1)
                                                                                                                                    return 'Female';
                                                                                                                            else
                                                                                                                                    return '';
                                                                                                                    }
                                                                                                            }
                                                                                                        ],
                                                                                                    ]
                                                                                                ]);
                                                                                                ?>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>

                                                </div>


                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>


