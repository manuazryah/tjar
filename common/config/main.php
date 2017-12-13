<?php

return [
//    'timeZone' => 'Asia/Kolkata',
    'aliases' => [
	'@bower' => '@vendor/bower-asset',
	'@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
	'cache' => [
	    'class' => 'yii\caching\FileCache',
	],
	'SetValues' => [
	    'class' => 'common\components\SetValues'
	],
	'UploadFile' => [
	    'class' => 'common\components\UploadFile'
	],
	'SetLanguage' => [
	    'class' => 'common\components\SetLanguage'
	],
	'Cartcount' => [
	    'class' => 'common\components\Cartcount'
	],
	'EncryptDecrypt' => [
	    'class' => 'common\components\EncryptDecrypt'
	],
    ],
];
