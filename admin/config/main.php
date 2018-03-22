<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'admin\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-admin',
        ],
        'user' => [
            'identityClass' => 'admin\models\Adminuser',
            'enableAutoLogin' => true,
            'enableSession'=>false,
//            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
//        'session' => [
//            // this is the name of the session cookie used for login on the backend
//            'name' => 'advanced-backend',
//        ],
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
                //权限
                [
                    'class'=>'yii\rest\UrlRule',
                    'controller'=>'permission',
                    'tokens' => [
                        '{id}' => '<id:\\w+>',
                    ],
                    'pluralize'=>false,
                    'extraPatterns'=>[
                        'POST search'=>'search',
                    ]
                ],
                //模块
                [
                    'class'=>'yii\rest\UrlRule',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'controller'=>'mymodule',
                    'pluralize'=>false,
                    'extraPatterns'=>[
                        'POST search'=>'search',
                    ]
                ],
                // 权限——角色
                [
                    'class'=>'yii\rest\UrlRule',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'controller'=>['permissionRole'=>'permission-role'],
                    'pluralize'=>false,
                    'extraPatterns'=>[
                        'POST search'=>'search',
                    ]
                ],
                //角色——管理员
                [
                    'class'=>'yii\rest\UrlRule',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'controller'=>[
                        'roleUser'=>'role-user'
                    ],
                    'pluralize'=>false,
                    'extraPatterns'=>[
                        'POST search'=>'search',
                    ]
                ],
                //角色
                [
                    'class'=>'yii\rest\UrlRule',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'controller'=>'role',
                    'pluralize'=>false,
                    'extraPatterns'=>[
                        'POST empower'=>'empower',
                        'POST roleModule'=>'role-module',
                        'POST distributionRole'=>'distribution-role',
                    ]
                ],
                //管理员
                [
                    'class'=>'yii\rest\UrlRule',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'controller'=>'adminuser',
                    'pluralize'=>false,
                    'extraPatterns'=>[
                        'POST empower'=>'empower',
                    ]
                ],
                //字典表
                [
                    'class'=>'yii\rest\UrlRule',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'controller'=>[
                        'dictionaryType'=>'dictionary-type',
                        ],
                    'pluralize'=>false,
                ],
                //字典表子表
                [
                    'class'=>'yii\rest\UrlRule',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'controller'=>[
                        'dictionaryItem'=>'dictionary-item',
                        ],
                    'pluralize'=>false,
                ],
                //登陆
                [
                    'class'=>'yii\rest\UrlRule',
                    'controller'=>'admin',
                    'except'=>['delete','update','view','create'],
                    'pluralize'=>false,
                    'extraPatterns'=>[
                        'POST login'=>'login'
                    ]
                ],
            ],
        ],
    ],
    'params' => $params,
];
