<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Vendors */

$this->title = 'Update Vendors: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Vendors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
        <div class="col-md-12">

                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                        </div>
                        <div class="panel-body">
                                <?= Html::a('<i class="fa-th-list"></i><span> Manage Vendors</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                                <a id="<?= $model->id ?>" class="btn btn-blue  btn-icon btn-icon-standalone ResetPassword" href="javascript:;" style="float:right;"><i class="fa-cog"></i><span> Reset Password</span></a>
                                <div class="panel-body"><div class="vendors-create">
                                                <?=
                                                $this->render('_form', [
                                                    'model' => $model,
                                                ])
                                                ?>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>
