<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
?>
<tr class="">
        <td class="" data-title="Date">
		<time datetime="2017-10-24T09:25:49+00:00"><?= date("M d, Y", strtotime($model->entry_date)); ?></time>
	       <!--<p><?= $model->entry_date ?></p>-->
        </td>
        <td class="" data-title="Action">
		<p><?= $model->type_id == 1 ? 'Amount credited In Wallet' : 'Amount Debited from Wallet' ?></p>
        </td>
        <td class="" data-title="Withdraw"><p><?= $model->type_id == 1 ? $model->amount : '--' ?></p>

        </td>
        <td class="" data-title="Deposit">
		<p><?= $model->type_id == 2 ? $model->amount : '--' ?></p>

        </td>
        <td class="" data-title="Comment">
		<p><?= $model->comment ?></p>
        </td>

</tr>

