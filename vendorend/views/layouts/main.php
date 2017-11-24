<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\NotificationViewStatus;

AppAsset::register($this);

$new_notifications = NotificationViewStatus::find()->where(['user_type' => 2, 'user_id' => Yii::$app->user->identity->id, 'view_status' => 0])->orderBy(['id' => SORT_DESC])->all();
$limit_notifications = NotificationViewStatus::find()->where(['user_type' => 2, 'user_id' => Yii::$app->user->identity->id, 'view_status' => 0])->limit(3)->orderBy(['id' => SORT_DESC])->all();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
        <head>
                <meta charset="<?= Yii::$app->charset ?>">
                <link rel="shortcut icon" href="<?= yii::$app->homeUrl; ?>../images/fav.png" type="image/png" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <?= Html::csrfMetaTags() ?>
                <title><?= Html::encode($this->title) ?></title>
                <script src="<?= yii::$app->homeUrl; ?>js/jquery-1.11.1.min.js"></script>
                <script>
                        var homeUrl = '<?= yii::$app->homeUrl; ?>';
                </script>
                <?php $this->head() ?>
        </head>
        <body>
                <?php $this->beginBody() ?>

        <body class="page-body">



                <div class="page-container"><!-- add class "sidebar-collapsed" to close sidebaowered By Azryah Networksr by default, "chat-visible" to make chat appear always -->
                        owered By Azryah Networks
                        <!-- Add "fixed" class to make the sidebar fixed always to the broowered By Azryah Networkswser viewport. -->
                        <!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
                        <!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->
                        <div class="sidebar-menu toggle-others fixed">

                                <div class="sidebar-menu-inner">

                                        <header class="logo-env" >

                                                <!-- logo -->
                                                <div class="logo">
                                                        <a href="<?= yii::$app->homeUrl; ?>" class="logo-expanded">
                                                                <img src="<?= yii::$app->homeUrl; ?>images/Login-left-logo.png" width="70px" alt="" />
                                                        </a>

                                                        <a href="<?= yii::$app->homeUrl; ?>" class="logo-collapsed">
                                                                <img src="<?= yii::$app->homeUrl; ?>images/logo.png" width="56px" alt="" />
                                                        </a>
                                                </div>

                                                <!-- This will toggle the mobile menu and will be visible only on mobile devices -->
                                                <div class="mobile-menu-toggle visible-xs">
                                                        <a href="#" data-toggle="user-info-menu">
                                                                <i class="fa-bell-o"></i>
                                                                <span class="badge badge-success">7</span>
                                                        </a>

                                                        <a href="#" data-toggle="mobile-menu">
                                                                <i class="fa-bars"></i>
                                                        </a>
                                                </div>


                                        </header>
                                        <ul id="main-menu" class="main-menu">
                                                <li class="">
                                                        <?= Html::a('<i class="fa fa-tachometer"></i><span class="title">Dashboard</span>', ['/site/index'], ['class' => 'title']) ?>
                                                </li>
                                                <li class="">
                                                        <a href="#">
                                                                <i class="fa fa-indent"></i>
                                                                <span class="title">Inventory</span>
                                                        </a>
                                                        <ul>
                                                                <li>
                                                                        <?= Html::a('Inventory Management', ['/product/product/index'], ['class' => 'title']) ?>
                                                                </li>

                                                                <li>
                                                                        <?= Html::a('Item Listing', ['/site/search-item'], ['class' => 'title']) ?>
                                                                </li>
                                                        </ul>
                                                </li>

                                                <li class="">
                                                        <a href="#">
                                                                <i class="fa fa-shopping-cart"></i>
                                                                <span class="title">Orders</span>
                                                        </a>
                                                        <ul>
                                                                <li>
                                                                        <?= Html::a('Order Management', ['/orders/order/index'], ['class' => 'title']) ?>
                                                                </li>

                                                        </ul>
                                                </li>

                                                <li class="">
                                                        <a href="#">
                                                                <i class="fa fa-indent"></i>
                                                                <span class="title">Fullfilled By Tjar</span>
                                                        </a>
                                                        <ul>
                                                                <li>
                                                                        <?= Html::a('Inventory', ['/product/fullfill/index'], ['class' => 'title']) ?>
                                                                </li>

                                                                <li>
                                                                        <?= Html::a('Orders', ['/product/fullfill/orders'], ['class' => 'title']) ?>
                                                                </li>

                                                        </ul>
                                                </li>

                                        </ul>

                                </div>

                        </div>
                        <div class="main-content">

                                <nav class="navbar user-info-navbar"  role="navigation"><!-- User Info, Notifications and Menu Bar -->

                                        <!-- Left links for user info navbar -->
                                        <ul class="user-info-menu left-links list-inline list-unstyled">

                                                <li class="hidden-sm hidden-xs">
                                                        <a href="#" data-toggle="sidebar">
                                                                <i class="fa-bars"></i>
                                                        </a>
                                                </li>

                                                <li class="dropdown hover-line">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                <i class="fa-bell-o"></i>
                                                                <span class="badge badge-purple"><?= count($new_notifications) ?></span>
                                                        </a>

                                                        <ul class="dropdown-menu notifications">
                                                                <li class="top">
                                                                        <p class="small">
                                                                                <a href="#" class="pull-right">Mark all Read</a>
                                                                                You have <strong><?= count($new_notifications) ?></strong> new notifications.
                                                                        </p>
                                                                </li>

                                                                <li>
                                                                        <ul class="dropdown-menu-list list-unstyled ps-scrollbar">
                                                                                <?php
                                                                                if (!empty($limit_notifications)) {
                                                                                        foreach ($limit_notifications as $new_notification) {
                                                                                                ?>
                                                                                                <li class="active notification-success">

                                                                                                        <?= Html::a('<i class="fa-lock"></i>
														<span class="line">' . $new_notification->content . '</span>
														<span class="line small time"> ' . date('d-m-Y', strtotime($new_notification->date)) . '</span>', ['/site/notifications?id=' . $new_notification->id], ['class' => '']) ?>
                                                                                                </li>
                                                                                                <?php
                                                                                        }
                                                                                }
                                                                                ?>


                                                                        </ul>
                                                                </li>

                                                                <li class="external">
                                                                        <?= Html::a('<span>View all notifications</span> <i class="fa-link-ext"></i>', ['/site/notifications'], ['class' => '']) ?>

                                                                </li>
                                                        </ul>
                                                </li>

                                        </ul>


                                        <!-- Right links for user info navbar -->
                                        <ul class="user-info-menu right-links list-inline list-unstyled">

                                                <li>
                                                        <a href="<?= Yii::$app->homeUrl; ?>site/home"><i class="fa-home"></i> Home</a>
                                                </li>

                                                <li class="dropdown user-profile">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                <img src="<?= yii::$app->homeUrl; ?>images/user-4.png" alt="user-image" class="img-circle img-inline userpic-32" width="28" />
                                                                <span>
                                                                        <?= Yii::$app->user->identity->username ?>
                                                                        <i class="fa-angle-down"></i>
                                                                </span>
                                                        </a>

                                                        <ul class="dropdown-menu user-profile-menu list-unstyled">

                                                                <li class="user-header">
                                                                        <img src="<?= yii::$app->homeUrl; ?>images/user-4.png" alt="user-image" class="img-circle" />
                                                                        <p>
                                                                                <?= Yii::$app->user->identity->first_name ?>
                                                                            <!--<small>Member since Nov. 2012</small>-->
                                                                        </p>
                                                                </li>
                                                                <li class="user-footer" style="background: #eeeeee;">
                                                                        <div class="row">
                                                                                <div class="pull-left" style="padding-right: 10px;">
                                                                                        <?= Html::a('Account', ['/settings/account-settings'], ['class' => 'btn btn-white', 'style' => 'padding: 12px 20px;']) ?>
                                                                                </div>
                                                                                <div class="pull-left">
                                                                                        <?= Html::a('Locations', ['/settings/locations'], ['class' => 'btn btn-white', 'style' => 'padding: 12px 20px;']) ?>
                                                                                </div>
                                                                                <div class="pull-right">
                                                                                        <?php
                                                                                        echo ''
                                                                                        . Html::beginForm(['/site/logout'], 'post', ['style' => 'margin-bottom: 0px;']) . '<a>'
                                                                                        . Html::submitButton(
                                                                                                'Sign out', ['class' => 'btn btn-white']
                                                                                        ) . '</a>'
                                                                                        . Html::endForm()
                                                                                        . '';
                                                                                        ?>
                                                                                </div>
                                                                        </div>
                                                                </li>

                                                        </ul>
                                                </li>



                                        </ul>

                                </nav>

                                <?= Alert::widget() ?>
                                <?= $content ?>

                                <!-- Main Footer -->
                                <!-- Choose between footer styles: "footer-type-1" or "footer-type-2" -->
                                <!-- Add class "sticky" to  always stick the footer to the end of page (if page contents is small) -->
                                <!-- Or class "fixed" to  always fix the footer to the end of page -->
                                <footer class="main-footer sticky footer-type-1">

                                        <div class="footer-inner">

                                                <!-- Add your copyright text here -->
                                                <div class="footer-text">
                                                        &copy; 2017
                                                        All Rights Reserved. Powered By Azryah Networks
                                                </div>


                                                <!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
                                                <div class="go-up">

                                                        <a href="#" rel="go-top">
                                                                <i class="fa-angle-up"></i>
                                                        </a>

                                                </div>

                                        </div>

                                </footer>
                        </div>

                        <!--    </div>
                        </div>-->

                        <div class="footer-sticked-chat"><!-- Start: Footer Sticked Chat -->

                                <script type="text/javascript">
                                        function toggleSampleChatWindow()
                                        {
                                                var $chat_win = jQuery("#sample-chat-window");

                                                $chat_win.toggleClass('open');

                                                if ($chat_win.hasClass('open'))
                                                {
                                                        var $messages = $chat_win.find('.ps-scrollbar');

                                                        if ($.isFunction($.fn.perfectScrollbar))
                                                        {
                                                                $messages.perfectScrollbar('destroy');

                                                                setTimeout(function () {
                                                                        $messages.perfectScrollbar();
                                                                        $chat_win.find('.form-control').focus();
                                                                }, 300);
                                                        }
                                                }

                                                jQuery("#sample-chat-window form").on('submit', function (ev)
                                                {
                                                        ev.preventDefault();
                                                });
                                        }

                                        jQuery(document).ready(function ($)
                                        {
                                                $(".footer-sticked-chat .chat-user, .other-conversations-list a").on('click', function (ev)
                                                {
                                                        ev.preventDefault();
                                                        toggleSampleChatWindow();
                                                });

                                                $(".mobile-chat-toggle").on('click', function (ev)
                                                {
                                                        ev.preventDefault();

                                                        $(".footer-sticked-chat").toggleClass('mobile-is-visible');
                                                });

                                                $('.disable-notification').on('change', function (e) {
                                                        var idd = $(this).attr('data-id');
                                                        var count = $('#notify-count').text();
                                                        $.ajax({
                                                                type: 'POST',
                                                                cache: false,
                                                                async: false,
                                                                data: {id: idd},
                                                                url: '<?= Yii::$app->homeUrl; ?>notifications/notification/update-notification',
                                                                success: function (data) {
                                                                        $(".hover-line-notify").addClass("open");
                                                                        var res = $.parseJSON(data);
                                                                        $('#notify-' + idd).fadeOut(750, function () {
                                                                                $(this).remove();
                                                                        });
                                                                        $('.notify-counts').text(res.result["notificationcount"]);
                                                                        $(".dropdown-menu-list-notify").html(res.result["notification-list"]);
                                                                        e.preventDefault();
                                                                }
                                                        });
                                                });
                                        });
                                </script>



                                <a href="#" class="mobile-chat-toggle">
                                        <i class="linecons-comment"></i>
                                        <span class="num">6</span>
                                        <span class="badge badge-purple">4</span>
                                </a>

                                <!-- End: Footer Sticked Chat -->
                        </div>



                        <?php $this->endBody() ?>
        </body>
</html>
<?php $this->endPage() ?>
