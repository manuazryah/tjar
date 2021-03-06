<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
if (isset($touser) && $touser != '')
    $name = $touser;
else
    $name = '';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style>
            .main-content p{
                line-height: 1.8;
            }
        </style>
    </head>
    <body style="font-family: sans-serif !important;">
        <?php $this->beginBody() ?>
        <div style="/* margin: 20px 200px 0px 300px; */border: 1px solid #9E9E9E;">
            <table border ="0"  class="main-tabl" border="0" style="width:100%;">
                <thead>
                    <tr>
                        <th style="width:100%">
                            <div class="header" style="padding-bottom: 0px;">
                                <div class="main-header">
                                    <div class="" style=";padding-left: 40px;text-align: center;">
                                        <?php echo Html::img('http://' . Yii::$app->request->serverName . '/images/logo.png', $options = ['width' => '']) ?>
                                        <?php //echo Html::img('@web/admin/images/logos/logo-1.png', $options = ['width' => '200px']) ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="navigation-bar"style="text-align: center;">
                                    <ul style="text-align: center;width: 100%;padding: 10px 0px;margin: 0;list-style-type: none;background-color: #005e9d;">
                                        <li style="display: inline;"><a target="_blank" style="width: 6em;text-decoration: none;color: white;padding: 0.2em 0.6em;font-size: 15px;text-transform: uppercase;font-weight: 500;" href="http://<?= Yii::$app->request->serverName ?>/about-coral-perfumes">Electronics</a></li>
                                        <li style="display: inline;"><a target="_blank" style="width: 6em;text-decoration: none;color: white;padding: 0.2em 0.6em;font-size: 15px;text-transform: uppercase;font-weight: 500;" href="http://<?= Yii::$app->request->serverName ?>/product/index?featured=1">Appliances</a></li>
                                        <li style="display: inline;"><a target="_blank" style="width: 6em;text-decoration: none;color: white;padding: 0.2em 0.6em;font-size: 15px;text-transform: uppercase;font-weight: 500;" href="http://<?= Yii::$app->request->serverName ?>/coral-perfumes-showrooms">Men</a></li>
                                        <li style="display: inline;"><a target="_blank" style="width: 6em;text-decoration: none;color: white;padding: 0.2em 0.6em;font-size: 15px;text-transform: uppercase;font-weight: 500;" href="http://<?= Yii::$app->request->serverName ?>/coral-perfumes-contact">Women</a></li>
                                        <li style="display: inline;"><a target="_blank" style="width: 6em;text-decoration: none;color: white;padding: 0.2em 0.6em;font-size: 15px;text-transform: uppercase;font-weight: 500;" href="http://<?= Yii::$app->request->serverName ?>/coral-perfumes-contact">BABY & KIDS</a></li>
                                        <li style="display: inline;"><a target="_blank" style="width: 6em;text-decoration: none;color: white;padding: 0.2em 0.6em;font-size: 15px;text-transform: uppercase;font-weight: 500;" href="http://<?= Yii::$app->request->serverName ?>/coral-perfumes-contact">HOME & FURNITURE</a></li>
                                        <li style="display: inline;"><a target="_blank" style="width: 6em;text-decoration: none;color: white;padding: 0.2em 0.6em;font-size: 15px;text-transform: uppercase;font-weight: 500;" href="http://<?= Yii::$app->request->serverName ?>/coral-perfumes-contact">BOOKS & MORE</a></li>
                                        <li style="display: inline;"><a target="_blank" style="width: 6em;text-decoration: none;color: white;padding: 0.2em 0.6em;font-size: 15px;text-transform: uppercase;font-weight: 500;" href="http://<?= Yii::$app->request->serverName ?>/coral-perfumes-contact">OFFER ZONE</a></li>
                                    </ul>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width:100%">
                            <?= $content ?>
                            <!--<hr style="border: 1px solid #0f60a0;">-->
                            <div class="main-content" style="text-align:center;border-top: 2px solid #0f60a0;padding: 15px 0px;">
                                <p style="margin:0px;font-size: 13px;"><a href="mailto:info@tjar.com" style="color:#501a8f;text-decoration: none;"><span style="font-weight: 600;">Email : </span></i>info@tjar.com</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.tjar.com" style="color:#501a8f;text-decoration: none;"><span style="font-weight: 600;">Web : </span>tjar.com</a></p>
                                <p style="margin-top:0px;margin-bottom: 0px;font-size: 15px;">Tjar.com</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
