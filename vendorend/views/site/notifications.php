<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */

$this->title = 'Notifications ';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->staff_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
        <div class="col-md-12">

                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                        </div>
                        <div class="panel-body">

                                <div class="panel-body">
                                        <div class="employee-create">
                                                <table class="table mail-table">
                                                        <tbody>
                                                                <?php foreach ($new_notifications as $notifications) { ?>
                                                                        <tr class="unread">


                                                                                <td class="col-subject ">


                                                                                        <?= Html::a($notifications->content, ['site/notifications?id=' . $notifications->id], ['class' => '']) ?>




                                                                                </td>

                                                                                <td class="col-time">
                                                                                        <?php
                                                                                        if ($notifications->date == date('Y-m-d')) {
                                                                                                echo "Today";
                                                                                        } else {
                                                                                                echo date("d", strtotime($notifications->date)) . ', ' . date("F", strtotime($notifications->date)) . ' ' . date("Y", strtotime($notifications->date));
                                                                                        }
                                                                                        ?>
                                                                                </td>
                                                                        </tr>
                                                                <?php } ?>
                                                        </tbody>
                                                </table>

                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>