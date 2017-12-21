<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Policies */

$this->title = 'Policies';
$this->params['breadcrumbs'][] = ['label' => 'Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
        <div class="col-md-12">

                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                        </div>
                        <div class="panel-body">
                                <div class="panel-body"><div class="policies-view">
                                                <p>
                                                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

                                                </p>

                                                <?=
                                                DetailView::widget([
                                                    'model' => $model,
                                                    'attributes' => [
                                                            [
                                                            'attribute' => 'return_policy',
                                                            'value' => function($model) {
                                                                    return strip_tags($model->return_policy);
                                                            }
                                                        ],
                                                            [
                                                            'attribute' => 'terms_of_use',
                                                            'value' => function($model) {
                                                                    return strip_tags($model->terms_of_use);
                                                            }
                                                        ],
                                                            [
                                                            'attribute' => 'security',
                                                            'value' => function($model) {
                                                                    return strip_tags($model->security);
                                                            }
                                                        ],
                                                            [
                                                            'attribute' => 'privacy',
                                                            'value' => function($model) {
                                                                    return strip_tags($model->privacy);
                                                            }
                                                        ],
                                                            [
                                                            'attribute' => 'infringement',
                                                            'value' => function($model) {
                                                                    return strip_tags($model->infringement);
                                                            }
                                                        ],
                                                            [
                                                            'attribute' => 'faq',
                                                            'value' => function($model) {
                                                                    return strip_tags($model->faq);
                                                            }
                                                        ],
                                                    ],
                                                ])
                                                ?>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>


<style>
        table th{
                width: 10%;
        }
</style>