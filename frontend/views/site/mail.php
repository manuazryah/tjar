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
                                        <?php echo Html::img('http://' . Yii::$app->request->serverName . '/tjar/images/logo.png', $options = ['width' => '']) ?>
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
                                                        <div class="content" style="background: #f5f2f2;margin: 25px 80px;">
                                                            <div class="header-content" style="background: #d8ecf5;padding: 15px 30px;color: #060606;text-transform: uppercase;font-weight: 600;">Tjar Varification Code</div>
                                                            <div style="padding: 15px 30px;background: #f9f9f9;">
                                                                <p style="font-size: 12px;">Dear Tjar User,</p>
                                                                <p style="font-size: 12px;">This email address is being used to recover a Tjar Account. If you initiated the recovery process, it is asking you to enter the numeric verification code that appears below.</p>
                                                                <p style="font-size: 12px;">If you did not initiate an account recovery process and have a Tjar Account associated with this email address, it is possible that someone else is trying to access your account. Do not forward or give this code to anyone.</p>
                                                                <p style="text-align: center;font-weight: 600;">984578</p>
                                                                <p style="font-size: 13px;">Sincerely,</p>
                                                                <p style="font-size: 13px;">The Tjar Accounts Team</p>
                                                            </div>
                                                        </div>
                                                        <div class="content" style="background: #f5f2f2;margin: 25px 80px;">
                                                            <div class="header-content" style="background: #d8ecf5;padding: 28px 30px;padding-top: 15px;color: #060606;font-weight: 600;">
                                                                <div style="float:left;text-transform: uppercase;">Order Details</div>
                                                                <div style="float:right;">
                                                                    <ul style="margin:0;padding: 0;list-style: none;">
                                                                        <li style="float:left;"><a style="border-right: 1px solid black;font-size: 12px;padding: 0px 15px;cursor: pointer;">Your Order</a></li>
                                                                        <li style="float:left;"><a style="padding: 0px 15px;font-size: 12px;cursor: pointer;">Your Account</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div style="padding: 15px 30px;background: #f9f9f9;">
                                                                <p style="font-size: 12px;font-size: 14px;color: rgb(204, 102, 0);">Hello Sabitha Varghese,</p>
                                                                <p style="font-size: 12px;">Thank you for your order. We’ll send a confirmation when your order ships.</p>
                                                                <div>
                                                                    <p style="font-size: 14px;font-weight: 600;padding-bottom: 5px;border-bottom: 1px solid #afabab;">Order #<span style="color:#2196F3;">408-0260003-6801978</span></p>
                                                                    <p style="font-size: 12px;">Placed on Sunday, February 5, 2017</p>
                                                                </div>
                                                                <div style="display: flow-root;border-bottom: 1px solid #afabab;">
                                                                    <div style="float:left;">
                            <?php // echo Html::img('http://' . Yii::$app->request->serverName . '/tjar/images/logo.png', $options = ['width' => '']) ?>
                                                                    </div>
                                                                    <div style="float:left;padding: 0px 20px;">
                                                                        <p style="font-size: 11px;">	Timex Analog Off-White Dial Men's Watch - TW002E113 </p>
                                                                        <p style="font-size: 11px;">	Watch </p>
                                                                        <p style="font-size: 11px;">	Sold by ALI EXPRESS  </p>
                                                                    </div>
                                                                    <div style="float:right;">
                                                                        <p style="font-size: 12px;font-weight: 600;">Rs.995.00</p>
                                                                    </div>
                                                                </div>
                                                                <div style="display: flow-root;">
                                                                    <div style="float:left;">
                                                                    </div>
                                                                    <div style="float:right;">
                                                                        <div style="float:left;padding: 0px 130px;">
                                                                            <div style="float: right;">
                                                                                <p style="font-size: 11px;">Item Subtotal:</p>
                                                                                <p style="font-size: 11px;">Shipping & Handling:</p>
                                                                                <p style="font-size: 11px;">Promotion Applied:</p>
                                                                                <p style="font-size: 12px;font-weight: 600;padding-top: 4px;">Order Total:</p>
                                                                            </div>
                                                                        </div>
                                                                        <div  style="float:left">
                                                                            <p style="font-size: 12px;font-weight: 600;">Rs.995.00</p>
                                                                            <p style="font-size: 12px;font-weight: 600;">Rs.995.00</p>
                                                                            <p style="font-size: 12px;font-weight: 600;">Rs.995.00</p>
                                                                            <p style="font-size: 12px;font-weight: 600;">Rs.995.00</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                            <div class="content" style="background: #f5f2f2;margin: 25px 80px;">
                                <div class="header-content" style="background: #d8ecf5;padding: 15px 30px;color: #060606;text-transform: uppercase;font-weight: 600;">Welcome to Tjar</div>
                                <div style="padding: 15px 30px;background: #f9f9f9;">
                                    <div>
                                        <p style="font-size: 12px;font-size: 15px;color: rgb(204, 102, 0);">A Greate Big Thank you:</p>
                                        <p style="margin-top:0px;font-size: 13px;">For shopping with <span style="color: #0f60a0;font-weight: 600;">Tjar</span></p>
                                    </div>
                                    <div>
                                        <p style="margin-top:0px;font-size: 13px;">We love our Customers dearly, and your feedback Is so helpful for us to here.</p>
                                    </div>
                                    <div>
                                        <p style="margin-top:0px;font-size: 13px;">If you have a few minutes to give a quick feedback, We'd be very grateful</p>
                                    </div>
                                    <div>
                                        <p style="margin-top:0px;font-size: 13px;">Please <a href="#">click here</a> for your valuable feedback</p>
                                    </div>
                                </div>
                            </div>

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
