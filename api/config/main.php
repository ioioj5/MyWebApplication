<?php
$params = array_merge (
	require ( __DIR__ . '/../../common/config/params.php' ),
	require ( __DIR__ . '/../../common/config/params-local.php' ),
	require ( __DIR__ . '/params.php' ), require ( __DIR__ . '/params-local.php' )
);

return [
	'id'                  => 'api-frontend',
	'basePath'            => dirname ( __DIR__ ),
	'bootstrap'           => [
		'log'
	],
	'defaultRoute'        => 'site', // 默认控制器
	'controllerNamespace' => 'api\controllers',
	'modules' => [
		'v1' => [
			'class' => 'api\modules\v1\Module',
		],
	],
	'components'          => [
		'user'         => [
			'identityClass'   => 'common\models\User',
			'enableAutoLogin' => false,
			'enableSession'=>true,
		],
		'log'          => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets'    => [
				[
					'class'  => 'yii\log\FileTarget',
					'levels' => [
						'error',
						'warning'
					]
				]
			]
		],
		'errorHandler' => [
			'errorAction' => 'site/error'
		],
	]
	// 'index' => 'site/index',

	/*
	 * 'urlManager' => [
	 * 'enablePrettyUrl' => true,
	 * 'showScriptName' => false,
	 * 'rules' => [
	 * ],
	 * ],
	 */
	,
	'params'              => $params
];
