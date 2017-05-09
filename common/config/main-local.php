<?php
/**
 * Created by PhpStorm.
 * User: ioioj5
 * Date: 2017/5/8
 * Time: 16:24
 */
$config = [
	'components'=>[
		'request'=>[
			'cookieValidationKey'=>'lRn8YHvQtEl3'
		]
	]
];

if (YII_ENV_DEV) {
	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
	];
}

return $config;