<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\bootstrap\Modal;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<style>
	.url_gen{
		padding: 0;
		border: none;
		background-color: inherit;
		font-size: 15px;
		color: #005e9e;
		font-weight: bold;
	}
	.page-loading-overlay {
		position: fixed;
		left: 0;
		top: 0;
		bottom: 0;
		right: 0;
		overflow: hidden;
		background: rgba(44, 46, 47, 0.28);
		z-index: 10000;
		-webkit-perspective: 10000;
		-moz-perspective: 10000;
		perspective: 10000;
		-webkit-perspective: 10000px;
		-moz-perspective: 10000px;
		perspective: 10000px;
		zoom: 1;
		filter: alpha(opacity=100);
		-webkit-opacity: 1;
		-moz-opacity: 1;
		opacity: 1;
		-webkit-transition: all 800ms ease-in-out;
		-moz-transition: all 800ms ease-in-out;
		-o-transition: all 800ms ease-in-out;
		transition: all 800ms ease-in-out
	}

	.page-loading-overlay.loaded {
		zoom: 1;
		filter: alpha(opacity=0);
		-webkit-opacity: 0;
		-moz-opacity: 0;
		opacity: 0;
		visibility: hidden
	}
	@-webkit-keyframes loaderAnimate {
		0% {
			-webkit-transform: rotate(0deg)
		}
		100% {
			-webkit-transform: rotate(220deg)
		}
	}

	@-moz-keyframes loaderAnimate {
		0% {
			-moz-transform: rotate(0deg)
		}
		100% {
			-moz-transform: rotate(220deg)
		}
	}

	@-o-keyframes loaderAnimate {
		0% {
			-o-transform: rotate(0deg)
		}
		100% {
			-o-transform: rotate(220deg)
		}
	}

	@keyframes loaderAnimate {
		0% {
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			transform: rotate(0deg)
		}
		100% {
			-webkit-transform: rotate(220deg);
			-moz-transform: rotate(220deg);
			-ms-transform: rotate(220deg);
			transform: rotate(220deg)
		}
	}

	lesshat-selector {
		-lh-property: 0
	}

	@-webkit-keyframes loaderAnimate2 {
		0% {
			box-shadow: inset #555 0 0 0 8px;
			-webkit-transform: rotate(-140deg)
		}
		50% {
			box-shadow: inset #555 0 0 0 2px
		}
		100% {
			box-shadow: inset #555 0 0 0 8px;
			-webkit-transform: rotate(140deg)
		}
	}

	@-moz-keyframes loaderAnimate2 {
		0% {
			box-shadow: inset #555 0 0 0 8px;
			-moz-transform: rotate(-140deg)
		}
		50% {
			box-shadow: inset #555 0 0 0 2px
		}
		100% {
			box-shadow: inset #555 0 0 0 8px;
			-moz-transform: rotate(140deg)
		}
	}

	@-o-keyframes loaderAnimate2 {
		0% {
			box-shadow: inset #555 0 0 0 8px;
			-o-transform: rotate(-140deg)
		}
		50% {
			box-shadow: inset #555 0 0 0 2px
		}
		100% {
			box-shadow: inset #555 0 0 0 8px;
			-o-transform: rotate(140deg)
		}
	}

	@keyframes loaderAnimate2 {
		0% {
			box-shadow: inset #555 0 0 0 8px;
			-webkit-transform: rotate(-140deg);
			-moz-transform: rotate(-140deg);
			-ms-transform: rotate(-140deg);
			transform: rotate(-140deg)
		}
		50% {
			box-shadow: inset #555 0 0 0 2px
		}
		100% {
			box-shadow: inset #555 0 0 0 8px;
			-webkit-transform: rotate(140deg);
			-moz-transform: rotate(140deg);
			-ms-transform: rotate(140deg);
			transform: rotate(140deg)
		}
	}

	.loader-1:after {
		-webkit-animation: loaderAnimate2 1000ms ease-in-out infinite;
		-moz-animation: loaderAnimate2 1000ms ease-in-out infinite;
		-o-animation: loaderAnimate2 1000ms ease-in-out infinite;
		animation: loaderAnimate2 1000ms ease-in-out infinite;
		clip: rect(0, 30px, 30px, 15px);
		content: '';
		border-radius: 50%;
		height: 30px;
		width: 30px;
		position: absolute
	}

	@keyframes loaderAnimate2 {
		0% {
			box-shadow: inset #fff 0 0 0 17px;
			transform: rotate(-140deg)
		}
		50% {
			box-shadow: inset #fff 0 0 0 2px
		}
		100% {
			box-shadow: inset #fff 0 0 0 17px;
			transform: rotate(140deg)
		}
	}

	.loader-2 {
		-webkit-animation: loaderAnimate2 1000ms linear infinite;
		-moz-animation: loaderAnimate2 1000ms linear infinite;
		-o-animation: loaderAnimate2 1000ms linear infinite;
		animation: loaderAnimate2 1000ms linear infinite;
		clip: rect(0, 30px, 30px, 15px);
		height: 30px;
		width: 30px;
		position: absolute;
		left: 50%;
		top: 50%;
		margin-left: -15px;
		margin-top: -15px
	}

	lesshat-selector {
		-lh-property: 0
	}

	@-webkit-keyframes loaderAnimate2 {
		0% {
			-webkit-transform: rotate(0deg)
		}
		100% {
			-webkit-transform: rotate(220deg)
		}
	}

	@-moz-keyframes loaderAnimate2 {
		0% {
			-moz-transform: rotate(0deg)
		}
		100% {
			-moz-transform: rotate(220deg)
		}
	}

	@-o-keyframes loaderAnimate2 {
		0% {
			-o-transform: rotate(0deg)
		}
		100% {
			-o-transform: rotate(220deg)
		}
	}

	@keyframes loaderAnimate2 {
		0% {
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			transform: rotate(0deg)
		}
		100% {
			-webkit-transform: rotate(220deg);
			-moz-transform: rotate(220deg);
			-ms-transform: rotate(220deg);
			transform: rotate(220deg)
		}
	}

	lesshat-selector {
		-lh-property: 0
	}

	@-webkit-keyframes loaderAnimate22 {
		0% {
			box-shadow: inset #fff 0 0 0 8px;
			-webkit-transform: rotate(-140deg)
		}
		50% {
			box-shadow: inset #fff 0 0 0 2px
		}
		100% {
			box-shadow: inset #fff 0 0 0 8px;
			-webkit-transform: rotate(140deg)
		}
	}

	@-moz-keyframes loaderAnimate22 {
		0% {
			box-shadow: inset #fff 0 0 0 8px;
			-moz-transform: rotate(-140deg)
		}
		50% {
			box-shadow: inset #fff 0 0 0 2px
		}
		100% {
			box-shadow: inset #fff 0 0 0 8px;
			-moz-transform: rotate(140deg)
		}
	}

	@-o-keyframes loaderAnimate22 {
		0% {
			box-shadow: inset #fff 0 0 0 8px;
			-o-transform: rotate(-140deg)
		}
		50% {
			box-shadow: inset #fff 0 0 0 2px
		}
		100% {
			box-shadow: inset #fff 0 0 0 8px;
			-o-transform: rotate(140deg)
		}
	}

	@keyframes loaderAnimate22 {
		0% {
			box-shadow: inset #fff 0 0 0 8px;
			-webkit-transform: rotate(-140deg);
			-moz-transform: rotate(-140deg);
			-ms-transform: rotate(-140deg);
			transform: rotate(-140deg)
		}
		50% {
			box-shadow: inset #fff 0 0 0 2px
		}
		100% {
			box-shadow: inset #fff 0 0 0 8px;
			-webkit-transform: rotate(140deg);
			-moz-transform: rotate(140deg);
			-ms-transform: rotate(140deg);
			transform: rotate(140deg)
		}
	}

	.loader-2:after {
		-webkit-animation: loaderAnimate22 1000ms ease-in-out infinite;
		-moz-animation: loaderAnimate22 1000ms ease-in-out infinite;
		-o-animation: loaderAnimate22 1000ms ease-in-out infinite;
		animation: loaderAnimate22 1000ms ease-in-out infinite;
		clip: rect(0, 30px, 30px, 15px);
		content: '';
		border-radius: 50%;
		height: 30px;
		width: 30px;
		position: absolute
	}

	@keyframes loaderAnimate22 {
		0% {
			box-shadow: inset #fff 0 0 0 17px;
			transform: rotate(-140deg)
		}
		50% {
			box-shadow: inset #fff 0 0 0 2px
		}
		100% {
			box-shadow: inset #fff 0 0 0 17px;
			transform: rotate(140deg)
		}
	}

	.page-loading-overlay {
		position: fixed;
		left: 0;
		top: 0;
		bottom: 0;
		right: 0;
		overflow: hidden;
		background: rgba(44, 46, 47, 0.28);
		z-index: 10000;
		-webkit-perspective: 10000;
		-moz-perspective: 10000;
		perspective: 10000;
		-webkit-perspective: 10000px;
		-moz-perspective: 10000px;
		perspective: 10000px;
		zoom: 1;
		filter: alpha(opacity=100);
		-webkit-opacity: 1;
		-moz-opacity: 1;
		opacity: 1;
		-webkit-transition: all 800ms ease-in-out;
		-moz-transition: all 800ms ease-in-out;
		-o-transition: all 800ms ease-in-out;
		transition: all 800ms ease-in-out
	}

	.page-loading-overlay.loaded {
		zoom: 1;
		filter: alpha(opacity=0);
		-webkit-opacity: 0;
		-moz-opacity: 0;
		opacity: 0;
		visibility: hidden
	}
</style>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<link rel="shortcut icon" href="<?= yii::$app->homeUrl; ?>../images/fav.png" type="image/png" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?= Html::csrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
		<script src="<?= yii::$app->homeUrl; ?>/js/jquery-1.11.1.min.js"></script>
		<script>
			var homeUrl = '<?= yii::$app->homeUrl; ?>';
		</script>
		<?php $this->head() ?>
	</head>
	<body>
		<?php $this->beginBody() ?>

	<body class="page-body">

		<div class="page-loading-overlay loaded">
			<div class="loader-2"></div>
		</div>

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
						<!-- add class "multiple-expanded" to allow multiple submenus to open -->
						<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
						<?php if (Yii::$app->session['post']['admin'] == 1) { ?>
							<li class="">
								<a href="#">
									<i class="fa fa-cog"></i>
									<span class="title">Admin</span>
								</a>
								<ul>
									<li>
										<?= Html::a('Admin Post', ['/admin/admin-post/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Admin User', ['/admin/admin-users/index'], ['class' => 'title']) ?>
									</li>
								</ul>
							</li>
						<?php } ?>
						<?php if (Yii::$app->session['post']['product_reviews'] == 1) { ?>
							<li>
								<a href="layout-variants.html">
									<i class="fa fa-desktop"></i>
									<span class="title">Products</span>
								</a>
								<ul>
									<li>
										<a href="extra-icons-fontawesome.html">
											<span class="title">Master</span>
										</a>
										<ul>
											<li>
												<?= Html::a('Main Category', ['/product/product-main-category/index'], ['class' => 'title']) ?>
											</li>
											<li>
												<?= Html::a('Category', ['/product/product-category/index'], ['class' => 'title']) ?>
											</li>
											<li>
												<?= Html::a('Sub Category', ['/product/product-sub-category/index'], ['class' => 'title']) ?>
											</li>
											<li>
												<?= Html::a('Brand', ['/product/product-brand/index'], ['class' => 'title']) ?>
											</li>
											<li>
												<?= Html::a('Search Tag', ['/product/search-tag/index'], ['class' => 'title']) ?>
											</li>
											<li>
												<?= Html::a('Master Features', ['/product/features/index'], ['class' => 'title']) ?>
											</li>
											<li>
												<?= Html::a('Filter', ['/product/filter/index'], ['class' => 'title']) ?>
											</li>
											<li>
												<?= Html::a('Product Features', ['/product/product-features/index'], ['class' => 'title']) ?>
											</li>
										</ul>
									</li>
									<li>
										<?= Html::a('Product', ['/product/products/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Product Mapping', ['/product/product-mapping/index'], ['class' => 'title']) ?>
									</li>
								</ul>
							</li>
						<?php } ?>

						<?php if (Yii::$app->session['post']['order'] == 1) { ?>
							<li>
								<a href="">
									<i class="fa fa-shopping-cart"></i>
									<span class="title">Orders</span>
								</a>
								<ul>
									<li>
										<?= Html::a('Order Management', ['/orders/order-master/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Fullfill By Tjar', ['/orders/order-master/full-fill'], ['class' => 'title']) ?>
									</li>
								</ul>
							</li>
						<?php } ?>
						<?php if (Yii::$app->session['post']['vendor'] == 1) { ?>
							<li>
								<a href="#">
									<i class="fa fa-user"></i>
									<span class="title">Vendors</span>
								</a>
								<ul>
									<li>
										<?= Html::a('Vendors', ['/vendors/vendors/index'], ['class' => 'title']) ?>
									</li>



								</ul>
							</li>
						<?php } ?>
						<?php if (Yii::$app->session['post']['users'] == 1) { ?>
							<li>
								<a href="">
									<i class="fa fa-user"></i>
									<span class="title">Users</span>
								</a>
								<ul>
									<li>
										<?= Html::a('Users', ['/user/user/index'], ['class' => 'title']) ?>
									</li>
								</ul>
							</li>
						<?php } ?>
						<?php if (Yii::$app->session['post']['promotions'] == 1) { ?>
							<li>
								<a href="">
									<i class="fa fa-cube"></i>
									<span class="title">Promotions</span>
								</a>
								<ul>
									<li>
										<?= Html::a('Promotions', ['/promotions/promotions/index'], ['class' => 'title']) ?>
									</li>
								</ul>
							</li>
						<?php } ?>
						<?php if (Yii::$app->session['post']['admin'] == 1) { ?>
							<li>
								<a href="">
									<i class="fa-pie-chart"></i>
									<span class="title">CMS</span>
								</a>
								<ul>
									<li>
										<?= Html::a('Slider', ['/cms/slider/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Home Management', ['/cms/home-management/index'], ['class' => 'title']) ?>
									</li>
								</ul>
							</li>
						<?php } ?>
						<?php if (Yii::$app->session['post']['product_reviews'] == 1) { ?>
							<li>
								<a href="">
									<i class="fa fa-envelope-o"></i>
									<span class="title">Reviews</span>
								</a>
								<ul>
									<li>
										<?= Html::a('Reviews', ['/reviews/customer-reviews/index'], ['class' => 'title']) ?>
									</li>
								</ul>
							</li>
						<?php } ?>
						<?php if (Yii::$app->session['post']['admin'] == 1) { ?>
							<li>
								<a href="">
									<i class="fa fa-files-o"></i>
									<span class="title">Reports</span>
								</a>
								<ul>
									<li>
										<?= Html::a('Order report', ['/reports/orders/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Item wise report', ['/reports/orders/item-report'], ['class' => 'title']) ?>
									</li>
								</ul>
							</li>
						<?php } ?>
						<?php if (Yii::$app->session['post']['masters'] == 1) { ?>
							<li>
								<a href="#">
									<i class="fa fa-microphone"></i>
									<span class="title">Master</span>
								</a>
								<ul>
									<li>
										<?= Html::a('Master Unit', ['/master/master-unit/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('City', ['/master/city/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Street', ['/master/street/index'], ['class' => 'title']) ?>
									</li>
								</ul>
							</li>
							<li>
								<a href="#">
									<i class="fa fa-bars"></i>
									<span class="title">ZPM</span>
								</a>
								<ul>
									<li>
										<?= Html::a('Operating System', ['/zpm/zpm-operating-system/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Processor', ['/zpm/zpm-processor/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Type', ['/zpm/zpm-type/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Screen Size', ['/zpm/zpm-screen-size/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Color', ['/zpm/zpm-color/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Screen Type', ['/zpm/zpm-screen-type/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Body Type', ['/zpm/zpm-body-type/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Sleeve', ['/zpm/zpm-sleeve/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Theme', ['/zpm/zpm-theme/index'], ['class' => 'title']) ?>
									</li>
									<li>
										<?= Html::a('Pattern', ['/zpm/zpm-pattern/index'], ['class' => 'title']) ?>
									</li>
								</ul>
							</li>
						<?php } ?>
						<?php if (Yii::$app->session['post']['admin'] == 1) { ?>
							<li>
								<a href="<?= yii::$app->homeUrl; ?>settings">
									<i class="fa fa-star"></i>
									<span class="title">Settings</span>
								</a>
							</li>
						<?php } ?>

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
						<li style="    padding: 15px;">
							<?= Html::button('Create URL', ['value' => Url::to(['/url-creation']), 'class' => 'modalButton url_gen']) ?>
						</li>
					</ul>


					<!-- Right links for user info navbar -->
					<ul class="user-info-menu right-links list-inline list-unstyled">

						<?php
						Modal::begin([
						    'header' => '',
						    'id' => 'modal',
						    'size' => 'modal-lg',
						]);
						echo "<div id = 'modalContent'></div>";
						Modal::end();
						?>

						<li>
							<a href="<?= Yii::$app->homeUrl; ?>site/home"><i class="fa-home"></i> Home</a>
						</li>

						<li class="dropdown user-profile">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?= yii::$app->homeUrl; ?>images/user-4.png" alt="user-image" class="img-circle img-inline userpic-32" width="28" />
								<span>
									<?= Yii::$app->user->identity->user_name ?>
									<i class="fa-angle-down"></i>
								</span>
							</a>

							<ul class="dropdown-menu user-profile-menu list-unstyled">

								<li>
									<?= Html::a('<i class="fa-wrench"></i>Change Password', ['/admin/admin-users/change-password'], ['class' => 'title']) ?>
								</li>
								<li>
									<?= Html::a('<i class="fa-pencil"></i>Edit Profile', ['/admin/admin-users/update?id=' . Yii::$app->user->identity->id], ['class' => 'title']) ?>
								</li>

								<?php
								echo '<li class="last">'
								. Html::beginForm(['/site/logout'], 'post') . '<a>'
								. Html::submitButton(
									'<i class="fa-lock"></i> Logout', ['class' => 'btn logout_btn']
								) . '</a>'
								. Html::endForm()
								. '</li>';
								?>


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
