<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
        ],
        'user' => [
            'identityClass' => 'api\models\User',
            'enableAutoLogin' => true,
            'enableSession'=>false,
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
            'enableStrictParsing'=>true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class'=>'yii\rest\UrlRule',
                    'controller'=>'article',
                    'extraPatterns'=>[
                        'POST search'=>'search',
                        'GET index'=>'index',
                        'PUT create'=>'create',
                        'GET yan'=>'yan',
                    ]
                ],
                [
                    'class'=>'yii\rest\UrlRule',
                    'controller'=>'user',
                    'except'=>['delete','update','view','create'],
                    'pluralize'=>false,
                    'extraPatterns'=>[
                        'POST login'=>'login'
                    ]
                ],
                [
                    'class'=>'yii\rest\UrlRule',
                    'controller'=>[
                        'commodityType'=>'commodity-type',
                    ],
//                    'except'=>['delete','update','view','create'],
                    'pluralize'=>false,
                    'extraPatterns'=>[
                        'POST test'=>'test'
                    ]
                ],
            ],
        ],
    ],
    'params' => $params,
];
