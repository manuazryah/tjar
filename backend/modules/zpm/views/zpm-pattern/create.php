<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ZpmPattern */

$this->title = 'Create Pattern';
$this->params['breadcrumbs'][] = ['label' => 'Patterns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
        <div class="col-md-12">

                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                        </div>
                        <div class="panel-body">
                                <div class="panel-body"><div class="zpm-pattern-create">
                                                <?= $this->render('_form', [
                                                'model' => $model,
                                                ]) ?>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>
                
