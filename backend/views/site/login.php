<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<!--<form method="post" role="form" id="login" class="login-form fade-in-effect">-->
<?php
$form = ActiveForm::begin(
                [
//                    'id' => 'login',
                    'method' => 'post',
                    'options' => [
                        'class' => 'login-form fade-in-effect'
                    ]
                ]
);
?>
<div class="login-header">
    <a href="#" class="logo">
        <img src="<?= yii::$app->homeUrl; ?>images/Login-left-logo.png" alt="" width="80" />
    </a>

    <p>Dear user, log in to access the admin area!</p>
</div>


<div class="form-group">

    <?= $form->field($model, 'user_name')->textInput(['class' => 'form-control input-dark'], ['autofocus' => true, 'placeholder' => "Username"]) ?>
</div>

<div class="form-group">
    <?= $form->field($model, 'password')->passwordInput(['id' => "password", 'class' => 'form-control input-dark'], ['placeholder' => "Password"]) ?>
</div>

<div class="form-group">
    <?= Html::submitButton('<i class="fa-lock"></i>Log In', ['class' => 'btn btn-dark  btn-block text-left']) ?>
</div>

<div class="login-footer">
    <?= Html::a('Forgot your password?', ['/site/forgot'], ['class' => 'title']) ?>

    <!--    <div class="info-links">
            <a href="#">ToS</a> -
            <a href="#">Privacy Policy</a>
        </div>-->

</div>

<?php ActiveForm::end(); ?>




