<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php', require __DIR__ . '/params.php', require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'], // adjust this to your needs
            'generators' => [//here
                'crud' => [// generator name
                    'class' => 'yii\gii\generators\crud\Generator', // generator class
                    'templates' => [//setting for out templates
                        'custom' => '@common/myTemplates/crud/custom', // template name => path to template
                    ]
                ]
            ],
        ],
        'admin' => [
            'class' => 'backend\modules\admin\Module',
        ],
        'product' => [
            'class' => 'backend\modules\product\Module',
        ],
        'vendors' => [
            'class' => 'backend\modules\vendors\Module',
        ],
        'zpm' => [
            'class' => 'backend\modules\zpm\Module',
        ],
        'master' => [
            'class' => 'backend\modules\master\Module',
        ],
        'user' => [
            'class' => 'backend\modules\user\Module',
        ],
        'promotions' => [
            'class' => 'backend\modules\promotions\Module',
        ],
        'reviews' => [
            'class' => 'backend\modules\reviews\Module',
        ],
        'orders' => [
            'class' => 'backend\modules\orders\Module',
        ],
        'reports' => [
            'class' => 'backend\modules\reports\Module',
        ],
        'cms' => [
            'class' => 'backend\modules\cms\Module',
        ],
        'menumanagement' => [
            'class' => 'backend\modules\menumanagement\Module',
        ],
        'commissionmanagement' => [
            'class' => 'backend\modules\commissionmanagement\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\AdminUsers',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => []],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
    ],
    'params' => $params,
];
