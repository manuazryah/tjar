<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\web\Cookie;
use common\models\LoginForm;
use common\models\User;

AppAsset::register($this);

$language = common\components\SetLanguage::Language();
Yii::$app->session['language'] = $language;
$words = \common\components\SetLanguage::Words($language);
$words = json_decode($words);
if (isset(Yii::$app->session['log-return'])) {
    $log_error = 1;
    $email = Yii::$app->session['log-return']['email'];
    $pass = Yii::$app->session['log-return']['password'];
} else {
    $log_error = '';
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <script src="<?= yii::$app->homeUrl; ?>js/jquery-1.11.1.min.js"></script>
        <script>
            var homeUrl = '<?= yii::$app->homeUrl; ?>';
            $(document).ready(function () {
                var log_error = '<?php echo $log_error ?>';
                var email = '<?php echo $email ?>';
                var pass = '<?php echo $pass ?>';
                if (log_error == 1) {
                    $('.log-popup-err').css('display', 'block');
                    $('#user-email').val(email);
                    $('#user-password').val(pass);
                    $('.modal ').css('display', 'block');
                    $('.modal ').addClass('in');
                }
            });
        </script>
        <?php $this->head() ?>
    </head>
    <style>
        .error-block{
            color: red;
            font-size: 11px;
            padding-left: 5px;
        }
        .shopping-cart{
            display: none;
            background: white;
            width: 350px;
            position: absolute;
            border-radius: 3px;
            padding: 15px 0;
            z-index: 1000000;
            top: 60px;
            right: 0px;
            box-shadow: 1px 1px 10px rgba(33, 33, 33, 0.62);
            padding-bottom: 0px;
        }
    </style>
    <body>
        <?php $this->beginBody() ?>
        <header>
            <div class="top-small-header">
                <div class="container">
                    <div class="dropdown">
                        <button onclick="myFunction()" class="dropbtn language"><span class="country-flag"><img src="<?= Yii::$app->homeUrl ?>/images/flags/USA.png"/></span>ENGLISH<span class="arrow-down"><i class="fa fa-caret-down" aria-hidden="true"></i></span></button>
                        <div id="myDropdown" class="dropdown-content">
                            <ul>
                                <li class="language-choose" id="English"><a  ><span class="country-flag"><img src="<?= Yii::$app->homeUrl ?>/images/flags/USA.png"/></span> English</a></li>
                                <li class="language-choose" id="Arabic"><a  ><span class="country-flag"><img src="<?= Yii::$app->homeUrl ?>/images/flags/UAE.png"/></span> ARABIC</a></li>
                            </ul>
                        </div>



                    </div>
                    <!--                    <div class="language">
                                            <ul>
                                                <li><span class="country-flag"><img src="<?= Yii::$app->homeUrl ?>/images/flags/USA.png"/></span><a href="#">English</a><span class="arrow-down"><i class="fa fa-caret-down" aria-hidden="true"></i></span></li>
                                                <li><span class="country-flag"><img src="<?= Yii::$app->homeUrl ?>/images/flags/USA.png"/></span><a href="#">English</a><span class="arrow-down"><i class="fa fa-caret-down" aria-hidden="true"></i></span></li>
                                            </ul>
                                        </div>-->
                    <!--                                        <table>
                                                                <tr>
                                                                    <td valign="top">
                                                                        <div class="ddOutOfVision" id="countries_msddHolder" style="height: 0px; overflow: hidden; position: absolute;">
                                                                            <select data-width="fit" name="countries" id="countries" style="width:300px;" tabindex="-1">
                                                                                <option  class=" language lang" value="us" data-image="<?= Yii::$app->homeUrl ?>/images/msdropdown/icons/blank.gif" data-imagecss="flag us" data-title="United States">English</option>
                                                                                <option  class=" language lang" value="ae" data-image="<?= Yii::$app->homeUrl ?>/images/msdropdown/icons/blank.gif" data-imagecss="flag ae" data-title="United Arab Emirates">Arabic</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="dd ddcommon borderRad    iusTp" id="countries_msdd" tabindex="0" style="width: 100%;"><div class="ddTitle borderRadiusTp"><span class="divider"></span><span class="ddArrow arrowoff"></span><span class="ddTitleText " id="countries_title"><img src="<?= Yii::$app->homeUrl ?>/images/msdropdown/icons/blank.gif" class="flag us fnone"><span class="ddlabel">ENGLISH</span><span class="description" style="display: none;"></span></span></div><input id="countries_titleText" type="text" autocomplete="off" class="text shadow borderRadius" style="display: none;"><div class="ddChild ddchild_ border shadow" id="countries_child" style="z-index: 9999; position: absolute; height: 64px; top: 29px; display: block;"><ul><li class="enabled _msddli_ selected" title="United States"><img src="<?= Yii::$app->homeUrl ?>/images/msdropdown/icons/blank.gif" class="flag us fnone"><span class="ddlabel">ENGLISH</span><div class="clear"></div></li><li class="enabled _msddli_" title="United Arab Emirates"><img src="<?= Yii::$app->homeUrl ?>/images/msdropdown/icons/blank.gif" class="flag ae fnone"><span class="ddlabel">ARABIC</span><div class="clear"></div></li></ul></div></div></td>
                                                                </tr>
                                                            </table>-->
                    <div class="other-options">
                        <ul class="options">
                            <li><a href="#">Call us now +123 5678 890</a></li>
                            <li><a href="#">Sell with us</a></li>
                            <li><a href="#">Track order</a></li>
                            <?php if (Yii::$app->user->identity->id == '') { ?>
                                <li><a class="log-sign">Signup</a></li>
                                <li><a class="log-sign">Log in</a></li>
                            <?php } else {
                                ?>
                                <li class="dropdown user-profile">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <span>
                                            <?= Yii::$app->user->identity->first_name ?>
                                            <i class="fa fa-angle-down"></i>
                                        </span>
                                    </a>

                                    <ul class="dropdown-menu user-profile-menu list-unstyled">

                                        <li>
                                            <?= Html::a('Account', ['/myaccounts/my-account/index'], ['class' => 'title']) ?>
                                        </li>
                                        <li>
                                            <?= Html::a('Order', ['/myaccounts/my-account/my-orders'], ['class' => 'title']) ?>
                                        </li>
                                        <li>
                                            <?= Html::a('Wishlist', ['/myaccounts/my-account/wish-list'], ['class' => 'title']) ?>
                                        </li>
                                        <li>
                                            <?= Html::a('Reviews & Ratings', ['/myaccounts/my-account/reviews'], ['class' => 'title']) ?>
                                        </li>
                                        <?php
                                        echo '<li class="last">'
                                        . Html::beginForm(['/site/logout'], 'post') . '<a>'
                                        . Html::submitButton(
                                                'Logout', ['style' => 'background: white;padding-left: 19px;padding: 10px 20px;border: none;']
                                        ) . '</a>'
                                        . Html::endForm()
                                        . '</li>';
                                        ?>


                                    </ul>
                                </li>
                            <?php }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="Login" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 left-img">
                            <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/Login-left.png" />
                            <img class="logo" src="<?= Yii::$app->homeUrl ?>/images/Login-left-logo.png"/>
                            <p class="msg">
                                <strong>Welcome</strong><br>
                                Get access to your Orders,
                                Wishlist and Recommendations
                            </p>
                        </div>
                        <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12 form">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#log">Login</a></li>
                                <li><a data-toggle="tab" href="#signup">Signup</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="log" class="tab-pane fade in active">
                                    <?php
                                    $modellogin = new LoginForm();
                                    ?>
                                    <?php $form_login = ActiveForm::begin(['action' => Yii::$app->homeUrl . 'site/login', 'id' => 'login-form', 'options' => ['class' => 'form-horizontal']]); ?>
                                    <!--<form class="form-horizontal" action=" " method="post"  id="login_form">-->
                                    <fieldset>
                                        <div class="form-group">
                                            <div class="col-md-12 inputGroupContainer">
                                                <div class="input-group">
                                                    <input  id="user-email" name="LoginForm[username]" placeholder="Email" class="form-control" type="text">
                                                    <span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>
                                                </div>
                                                <!--<div class="error-block">This field is required</div>-->
                                            </div>
                                        </div>

                                        <!-- Text input-->

                                        <div class="form-group">
                                            <div class="col-md-12 inputGroupContainer">
                                                <div class="input-group">
                                                    <input id="user-password" name="LoginForm[password]" placeholder="Password" class="form-control" type="password">
                                                    <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="log-popup-err">Invalid Username or Password</div>
                                        <!-- Button -->
                                        <div class="form-group login-group-checkbox">
                                            <label for="lg_remember">
                                                <input type="checkbox" id="lg_remember" name="LoginForm[rememberMe]" value="1" checked="">
                                                Remember Me
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <?= Html::submitButton('Login', ['class' => 'btn btn-warning', 'name' => 'login-button']) ?>
                                                <!--<button type="submit" class="btn btn-warning" >Login</button>-->
                                            </div>
                                        </div>
                                        <ul class="qstn">
                                            <li><a data-toggle="tab" href="#signup">Don't have an <span>account?</span></a></li>
                                            <li><a href="#">Forgot <span>password?</span></a></li>
                                        </ul>
                                    </fieldset>
                                    <?php ActiveForm::end(); ?>
                                    <!--</form>-->
                                </div>
                                <div id="signup" class="tab-pane fade">
                                    <?php
                                    $modelregister = new User();
                                    ?>
                                    <?php $form_signin = ActiveForm::begin(['action' => Yii::$app->homeUrl . 'site/register', 'id' => 'signup-form', 'options' => ['class' => 'form-horizontal']]); ?>
                                    <!--<form class="form-horizontal" action=" " method="post"  id="signup_form">-->
                                    <fieldset>
                                        <div class="form-group">
                                            <div class="col-md-6 inputGroupContainer">
                                                <div class="input-group">
                                                    <?php // $form_signin->field($modelregister, 'first_name')->textInput(['maxlength' => true])  ?>
                                                    <input id="signup-first_name" name="User[first_name]" placeholder="First Name" class="form-control" type="text">
                                                    <span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 inputGroupContainer">
                                                <div class="input-group">
                                                    <input id="signup-last_name" name="User[last_name]" placeholder="Last Name" class="form-control" type="text">
                                                    <span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12 inputGroupContainer">
                                                <div class="input-group">
                                                    <input id="signup-email" name="User[email]" placeholder="Email" class="form-control" type="text">
                                                    <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12 inputGroupContainer">
                                                <div class="input-group">
                                                    <input id="signup-mobile_number" name="User[mobile_number]" placeholder="Phone" class="form-control" type="text">
                                                    <span class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Text input-->

                                        <div class="form-group">
                                            <div class="col-md-12 inputGroupContainer">
                                                <div class="input-group">
                                                    <input id="signup-password" name="User[password]" placeholder="Password" class="form-control" type="password">
                                                    <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="email-check" id="email-check" value="0">
                                        <!-- Button -->
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <?= Html::submitButton('Register', ['class' => 'btn btn-warning']) ?>
                                                <!--<button type="submit" class="btn btn-warning" >Register</button>-->
                                            </div>
                                        </div>
                                        <ul class="qstn">
                                            <li style="float: none; text-align: center;"><a data-toggle="tab" href="#log">Already have an account? <span>Login!</span></a></li>
                                        </ul>
                                    </fieldset>

                                    <?php ActiveForm::end(); ?>
                                    <!--</form>-->
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-default clos" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
                    </div>

                </div>
            </div>
            <?php
            unset(Yii::$app->session['log-return']);
            ?>
            <div class="top-header-2">
                <div class="container">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="logo">
                            <a href="index.php"><img src="<?= Yii::$app->homeUrl ?>/images/logo.png"/></a>
                        </div>
                    </div>

                    <?= common\components\SearchWidget::widget(['type' => '2']); ?>

                    <div class="col-md-2 col-sm-2 col-xs-4 cart">
                        <button><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>CART</span></button><label class="cart_count">0</label>
                        <!--<div class="container">-->
                        <div class="shopping-cart">


                            <ul class="shopping-cart-items">

                            </ul><!--
                            -->                            <div class="col-md-12 checkout-btn-space">
                                <?= Html::a('<button class="green2">check out</button>', ['/cart/mycart'], ['class' => '']) ?>
                                <!--<button class="green2">check out</button>-->
                            </div>
                            <!--</div>-->
                            <!--</div>-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="nav-header">
                <div class="menu-container">
                    <div class="menu">
                        <ul>
                            <li id="main-div"><a href="#"><?= $words->electronics ?><span class="dropdown-arrow hidden-xs"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                                <ul class="list">
                                    <li><a href="#">Mobiles</a>
                                        <ul>
                                            <li><a href="#">Lidership</a></li>
                                            <li><a href="#">History</a></li>
                                            <li><a href="#">Locations</a></li>
                                            <li><a href="#">Careers</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Mobile Accessories</a>
                                        <ul>
                                            <li><a href="#">Undergraduate</a></li>
                                            <li><a href="#">Masters</a></li>
                                            <li><a href="#">International</a></li>
                                            <li><a href="#">Online</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Laptops</a>
                                        <ul>
                                            <li><a href="#">Undergraduate research</a></li>
                                            <li><a href="#">Masters research</a></li>
                                            <li><a href="#">Funding</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Televisions</a>
                                        <ul>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="#"><?= $words->appliances ?><span class="dropdown-arrow hidden-xs"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                                <ul>
                                    <li><a href="#">Televisions</a>
                                        <ul>
                                            <li><a href="#">Lidership</a></li>
                                            <li><a href="#">History</a></li>
                                            <li><a href="#">Locations</a></li>
                                            <li><a href="#">Careers</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Washing Machine</a>
                                        <ul>
                                            <li><a href="#">Undergraduate</a></li>
                                            <li><a href="#">Masters</a></li>
                                            <li><a href="#">International</a></li>
                                            <li><a href="#">Online</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Kitchen Appliances</a>
                                        <ul>
                                            <li><a href="#">Undergraduate research</a></li>
                                            <li><a href="#">Masters research</a></li>
                                            <li><a href="#">Funding</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Small Home Appliances</a>
                                        <ul>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li><a href="#"><?= $words->men ?><span class="dropdown-arrow hidden-xs"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                                <ul>
                                    <li><a href="#">Televisions</a>
                                        <ul>
                                            <li><a href="#">Lidership</a></li>
                                            <li><a href="#">History</a></li>
                                            <li><a href="#">Locations</a></li>
                                            <li><a href="#">Careers</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Washing Machine</a>
                                        <ul>
                                            <li><a href="#">Undergraduate</a></li>
                                            <li><a href="#">Masters</a></li>
                                            <li><a href="#">International</a></li>
                                            <li><a href="#">Online</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Kitchen Appliances</a>
                                        <ul>
                                            <li><a href="#">Undergraduate research</a></li>
                                            <li><a href="#">Masters research</a></li>
                                            <li><a href="#">Funding</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Small Home Appliances</a>
                                        <ul>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li><a href="#"><?= $words->women ?><span class="dropdown-arrow hidden-xs"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                                <ul>
                                    <li><a href="#">Televisions</a>
                                        <ul>
                                            <li><a href="#">Lidership</a></li>
                                            <li><a href="#">History</a></li>
                                            <li><a href="#">Locations</a></li>
                                            <li><a href="#">Careers</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Washing Machine</a>
                                        <ul>
                                            <li><a href="#">Undergraduate</a></li>
                                            <li><a href="#">Masters</a></li>
                                            <li><a href="#">International</a></li>
                                            <li><a href="#">Online</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Kitchen Appliances</a>
                                        <ul>
                                            <li><a href="#">Undergraduate research</a></li>
                                            <li><a href="#">Masters research</a></li>
                                            <li><a href="#">Funding</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Small Home Appliances</a>
                                        <ul>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li><a href="#"><?= $words->baby ?><span class="dropdown-arrow hidden-xs"><i class="fa fa-chevron-down" aria-hidden="true"></i></span> </a>
                                <ul>
                                    <li><a href="#">Televisions</a>
                                        <ul>
                                            <li><a href="#">Lidership</a></li>
                                            <li><a href="#">History</a></li>
                                            <li><a href="#">Locations</a></li>
                                            <li><a href="#">Careers</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Washing Machine</a>
                                        <ul>
                                            <li><a href="#">Undergraduate</a></li>
                                            <li><a href="#">Masters</a></li>
                                            <li><a href="#">International</a></li>
                                            <li><a href="#">Online</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Kitchen Appliances</a>
                                        <ul>
                                            <li><a href="#">Undergraduate research</a></li>
                                            <li><a href="#">Masters research</a></li>
                                            <li><a href="#">Funding</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Small Home Appliances</a>
                                        <ul>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li><a href="#"><?= $words->home ?><span class="dropdown-arrow hidden-xs"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                                <ul>
                                    <li><a href="#">Televisions</a>
                                        <ul>
                                            <li><a href="#">Lidership</a></li>
                                            <li><a href="#">History</a></li>
                                            <li><a href="#">Locations</a></li>
                                            <li><a href="#">Careers</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Washing Machine</a>
                                        <ul>
                                            <li><a href="#">Undergraduate</a></li>
                                            <li><a href="#">Masters</a></li>
                                            <li><a href="#">International</a></li>
                                            <li><a href="#">Online</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Kitchen Appliances</a>
                                        <ul>
                                            <li><a href="#">Undergraduate research</a></li>
                                            <li><a href="#">Masters research</a></li>
                                            <li><a href="#">Funding</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Small Home Appliances</a>
                                        <ul>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li><a href="#"><?= $words->books ?><span class="dropdown-arrow hidden-xs"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                                <ul>
                                    <li><a href="#">Televisions</a>
                                        <ul>
                                            <li><a href="#">Lidership</a></li>
                                            <li><a href="#">History</a></li>
                                            <li><a href="#">Locations</a></li>
                                            <li><a href="#">Careers</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Washing Machine</a>
                                        <ul>
                                            <li><a href="#">Undergraduate</a></li>
                                            <li><a href="#">Masters</a></li>
                                            <li><a href="#">International</a></li>
                                            <li><a href="#">Online</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Kitchen Appliances</a>
                                        <ul>
                                            <li><a href="#">Undergraduate research</a></li>
                                            <li><a href="#">Masters research</a></li>
                                            <li><a href="#">Funding</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Small Home Appliances</a>
                                        <ul>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                            <li><a href="#">Sub something</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li><a href="#"><?= $words->offer_zone ?></a></li>

                        </ul>
                    </div>
                </div>
            </div>

        </header>
        <?= $content ?>
        <div class="page-loading-overlay loaded">
            <div class="loader-2"></div>
        </div>
        <footer>

            <section id="footer">
                <div class="container">
                    <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
                        <div class="footer-logo">
                            <img class="img-responsive" src="<?= Yii::$app->homeUrl ?>/images/logo.png">
                        </div>
                        <div class="footer-about">
                            <p>
                                <span>The standard Lorem Ipsum passage</span><br/>
                                Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                                accusantium doloremque laudantium, totam rem aperiam, eaque ipsa
                                quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt
                                explicabo. <a href="#">Read more</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="footer-links">
                            <div class="heading">Quick Links
                                <div class="heading-bottom">
                                    <hr/>
                                </div>
                            </div>
                            <ul>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Careers</a></li>
                                <li><a href="#">Tjar Stories</a></li>
                                <li><a href="#">Press</a></li>
                                <li><a href="#">Sell On Tjar</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-3 col-sm-4 col-xs-6">
                        <div class="footer-links">
                            <div class="heading">Help
                                <div style="width: 40px;" class="heading-bottom">
                                    <hr/>
                                </div>
                            </div>
                            <ul>
                                <li><a href="#">Payments</a></li>
                                <li><a href="#">Saved Cards</a></li>
                                <li><a href="#">Shippping</a></li>
                                <li><a href="#">Cancelation & Returns</a></li>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Report Infringement</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="footer-links">
                            <div class="heading">Contact Us
                                <div class="heading-bottom">
                                    <hr/>
                                </div>
                            </div>
                            <ul class="address">
                                <li><span class="round-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>Addresss: 123 Somewhere, Anywhere</li>
                                <li><span class="round-icon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>Mail: tjar@gmail.com</li>
                                <li><span class="round-icon"><i class="fa fa-phone" aria-hidden="true"></i></span>Phone: 890 456 321</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <section id="bottom-footer" class="txt-cntr">
                <div class="container">
                    <div class="col-lg-5 col-md-5 col-sm-7 col-xs-12">
                        <ul class="sm-align-center xs-align-center">
                            <li>Policies:</li>
                            <li><a href="#">Returns Policy</a></li>
                            <li><a href="#">Terms of use</a></li>
                            <li><a href="#">Security</a></li>
                            <li><a href="#">Privacy</a></li>
                            <li><a href="#">Infringement</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-2 hidden-sm hidden-xs sm-align-center xs-align-center">
                        <p>&copy; 2017 Tjar.com</p>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 social-links">
                        <ul class="sm-align-center xs-align-center">
                            <li class="hidden-sm hidden-xs">Keep in touch</li>
                            <li><a href="#"><span class="round-icon"><i class="fa fa-facebook" aria-hidden="true"></i></span></a></li>
                            <li><a href="#"><span class="round-icon"><i class="fa fa-twitter" aria-hidden="true"></i></span></a></li>
                            <li><a href="#"><span class="round-icon"><i class="fa fa-linkedin" aria-hidden="true"></i></span></a></li>
                            <li><a href="#"><span class="round-icon"><i class="fa fa-google-plus" aria-hidden="true"></i></span></a></li>
                        </ul>
                    </div>
                    <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                        <p>&copy; 2017 Tjar.com</p>
                    </div>
                </div>
            </section>

        </footer>
        <!--        <script>
                    $(function () {
                        $('.selectpicker').selectpicker();
                    });
                </script>-->
        <script>
            /* When the user clicks on the button,
             toggle between hiding and showing the dropdown content */
            function myFunction() {
                document.getElementById("myDropdown").classList.toggle("show");
            }

            // Close the dropdown if the user clicks outside of it
            window.onclick = function (event) {
                if (!event.target.matches('.dropbtn')) {

                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    var i;
                    for (i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                    }
                }
            }
        </script>
        <!--<script>
            $(window).on("scroll", function () {
                if ($(window).scrollTop() > 100) {
                    $(".nav-header").addClass("hide");
                } else {
                    //remove the background property so it comes transparent again (defined in your css)
                    $(".nav-header").removeClass("hide");
                }
            });</script>-->
        <script>
            jQuery.noConflict();
            jQuery(document).ready(function ($) {
                $('#buttonreview').on('click', function (e) {
                    $("#addreview").toggle();
                    $(this).toggleClass('class1')
                });
                $('#radio-toggle').change(function () {
                    $('#div').toggle(this.checked);
                });
            });
        </script>
        <script>

            jQuery(document).ready(function ($) {
                $('#login-form').on('submit', function (e) {
                    if (validateLogin() == 0) {
                        return true;
                    } else {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                    }
                });
                $('#signup-form').on('submit', function (e) {
                    if (validateSignup() == 0) {
                        return true;
                    } else {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                    }
                });
                $('#signup-email').on('blur', function (e) {
                    if ($('#signup-email').val()) {
                        if (!validateMail($(this).val())) {
                            if ($("#signup-email").parent().next(".validation").length != 0) // only add if not added
                            {
                                $("#signup-email").parent().next(".validation").remove(); // remove it
                            }
                            $("#signup-email").parent().after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>This email is already used.</div>");
                        }
                    }
                });
                //                $('#signup-first_name').on('keyup', function (e) {
                //                    if (!validateLetter($(this).val())) {
                //                        $("#signup-first_name").parent().next(".validation").remove(); // remove it
                //                        $("#signup-first_name").parent().after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>First name contain letters only.</div>");
                //                    } else {
                //                        if ($("#signup-first_name").parent().next(".validation").length != 0) // only add if not added
                //                        {
                //                            $("#signup-first_name").parent().next(".validation").remove(); // remove it
                //                        }
                //                    }
                //                });
                function validateMail(email) {
                    $.ajax({
                        type: 'POST',
                        cache: false,
                        data: {email: email},
                        url: homeUrl + 'ajax/email-check',
                        success: function (data) {
                            $("#email-check").val(data);
                            if (data == 0) {
                                return false
                            } else {
                                if ($("#signup-email").parent().next(".validation").length != 0) // only add if not added
                                {
                                    $("#signup-email").parent().next(".validation").remove(); // remove it
                                }
                            }
                        }
                    });
                }
                function validateLetter(txt)
                {
                    var letters = /^[A-Za-z]+$/;
                    if (txt.match(letters))
                    {
                        return true;
                    } else
                    {
                        return false;
                    }
                }
                function validateSignup() {
                    var valid = 0;
                    if (!$('#signup-email').val()) {
                        if ($("#signup-email").parent().next(".validation").length == 0) // only add if not added
                        {
                            $("#signup-email").parent().after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>Email cannot be blank.</div>");
                        }
                        $('#signup-email').focus();
                        var valid = 1;
                    } else {
                        var emailaddress = $('#signup-email').val();
                        if (!isValidEmailAddress(emailaddress)) {
                            if ($("#signup-email").parent().next(".validation").length != 0) // only add if not added
                            {
                                $("#signup-email").parent().next(".validation").remove(); // remove it
                            }
                            $("#signup-email").parent().after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>Enter valid email.</div>");
                            var valid = 1;
                        } else {
                            if (!validateMail(emailaddress)) {
                                var res = $("#email-check").val();
                                if (res == 0) {
                                    if ($("#signup-email").parent().next(".validation").length != 0) // only add if not added
                                    {
                                        $("#signup-email").parent().next(".validation").remove(); // remove it
                                    }
                                    $("#signup-email").parent().after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>This email is already used.</div>");
                                    var valid = 1;
                                }
                            }
                        }
                    }
                    if (!$('#signup-password').val()) {
                        if ($("#signup-password").parent().next(".validation").length == 0) // only add if not added
                        {
                            $("#signup-password").parent().after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>Password cannot be blank.</div>");
                        }
                        $('#signup-password').focus();
                        var valid = 1;
                    } else {
                        $("#signup-password").parent().next(".validation").remove(); // remove it
                    }
                    if (!$('#signup-first_name').val()) {
                        if ($("#signup-first_name").parent().next(".validation").length == 0) // only add if not added
                        {
                            $("#signup-first_name").parent().after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>First Name cannot be blank.</div>");
                        }
                        $('#signup-first_name').focus();
                        var valid = 1;
                    } else {
                        $("#signup-first_name").parent().next(".validation").remove(); // remove it
                    }
                    if (!$('#signup-last_name').val()) {
                        if ($("#signup-last_name").parent().next(".validation").length == 0) // only add if not added
                        {
                            $("#signup-last_name").parent().after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>Last Name cannot be blank.</div>");
                        }
                        $('#signup-last_name').focus();
                        var valid = 1;
                    } else {
                        $("#signup-last_name").parent().next(".validation").remove(); // remove it
                    }
                    if (!$('#signup-mobile_number').val()) {
                        if ($("#signup-mobile_number").parent().next(".validation").length == 0) // only add if not added
                        {
                            $("#signup-mobile_number").parent().after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>Mobile Number cannot be blank.</div>");
                        }
                        $('#signup-mobile_number').focus();
                        var valid = 1;
                    } else {
                        $("#signup-mobile_number").parent().next(".validation").remove(); // remove it
                    }
                    return valid;
                }
                function validateLogin() {
                    var valid = 0;
                    if (!$('#user-email').val()) {
                        if ($("#user-email").parent().next(".validation").length == 0) // only add if not added
                        {
                            $("#user-email").parent().after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>Email cannot be blank.</div>");
                        }
                        $('#user-email').focus();
                        var valid = 1;
                    } else {
                        var emailaddress = $('#user-email').val();
                        if (!isValidEmailAddress(emailaddress)) {
                            if ($("#user-email").parent().next(".validation").length != 0) // only add if not added
                            {
                                $("#user-email").parent().next(".validation").remove(); // remove it
                            }
                            $("#user-email").parent().after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>Enter valid email.</div>");
                            var valid = 1;
                        } else {
                            $("#user-email").parent().next(".validation").remove(); // remove it
                        }
                    }
                    if (!$('#user-password').val()) {
                        if ($("#user-password").parent().next(".validation").length == 0) // only add if not added
                        {
                            $("#user-password").parent().after("<div class='validation' style='color:red;margin-left: 4px;font-size: 10px;'>Password cannot be blank.</div>");
                        }
                        $('#user-password').focus();
                        var valid = 1;
                    } else {
                        $("#user-password").parent().next(".validation").remove(); // remove it
                    }
                    return valid;
                }
                function isValidEmailAddress(emailAddress) {
                    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
                    return pattern.test(emailAddress);
                }
                function allLetter(inputtxt)
                {
                    var letters = /^[A-Za-z]+$/;
                    if (inputtxt.value.match(letters))
                    {
                        return true;
                    } else
                    {
                        return false;
                    }
                }
            });
        </script>
        <script>
            jQuery(document).ready(function ($) {
                $('#btAnimate').click(function () {
                    // ANIMATE THE CONTAINER. DURATION SET TO 500 MILLISECONDS.
                    $("#divAnim").animate(500);
                    $('#divC').show('slow');          // ALSO SHOW THE DIV.
                    $('#divC').css('display', 'inline-block');          // ALSO SHOW THE DIV.
                });

                // REVERSE ANIMATE.
                $('#btHide').click(function () {
                    $("#divAnim").animate(500);
                    $('#divC').hide('slow');          // HIDE THE DIV.
                });
                $('.option-btn').hover(function () {
                    $(this).find('.options').stop(true, true).delay(100).fadeIn(100);
                }, function () {
                    $(this).find('.options').stop(true, true).delay(100).fadeOut(100);
                });
                $('.log-sign').click(function () {
                    $('.modal').css('display', 'block');
                    $('.modal').addClass('in');
                });
                $('.clos').click(function () {
                    $('.modal').css('display', 'none');
                    $('.log-popup-err').css('display', 'none');
                    $('.modal').removeClass('in');
                    $('#user-email').val('');
                    $('#user-password').val('');
                    $.ajax({
                        type: 'POST',
                        cache: false,
                        url: homeUrl + 'ajax/remove-login-session',
                        success: function (data) {
                            return true;
                        }
                    });
                });
            });
        </script>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
