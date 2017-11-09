<?php

use yii\helpers\Html;
?>
<html>
    <head>
    </head>
    <body>
        <div class="container">
            <div class="col-lg-2 col-md-2"></div>
            <div class="col-lg-8 col-md-8" style="background: #bb0a0a;color: white;padding-bottom: 10px;border-radius: 5px;">
                <?php //if (Yii::$app->session->hasFlash('exception')): ?>
                <div class="">
                    <h5 style="padding: 0px 25px;font-weight: 600;">Access denied</h5>
                    <div class="col-lg-12">
                        <div style="background: white;padding: 15px 10px;">
                            <div style="border-bottom: 1px dashed green;">
                                <p>You have no permission to access this page.</p>
                                <p>If you think this message is wrong, please consult your administrators about getting the necessary permissions.</p>
                            </div>
                            <div style="padding-top: 15px;">
                                <?= Html::a('<span>Login</span>', ['site/login'], ['class' => 'btn btn-white btn-icon', 'style' => 'border: 1px solid #d0d0d0;color: #0e0d0d !important;padding: 8px 15px;font-weight: 600;']) ?>
                                <?= Html::a('<span>Go to dashboard</span>', ['site/index'], ['class' => 'btn btn-white btn-icon', 'style' => 'border: 1px solid #d0d0d0;color: #0e0d0d !important;padding: 8px 15px;font-weight: 600;']) ?>
                            </div>
                        </div>
                    </div>
                    <?php // Yii::$app->session->getFlash('exception') ?>
                </div>
                <?php //endif; ?>
            </div>
            <div class="col-lg-2 col-md-2"></div>
        </div>
    </body>

</html>

