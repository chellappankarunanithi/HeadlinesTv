<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers', 
   // 'defaultRoute' => 'site/index',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\Frontend',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_frontendUser', // unique for frontend
            ]
        ],
        'session' => [
            'name' => 'Swim987963frontend',
            'savePath' => sys_get_temp_dir(),
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'sdfafsdsd',
            'csrfParam' => '_frontendCSRF',
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
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [            	
                'login' => 'site/login',
                'logout' => 'site/logout', 
                'dashboard'=>'site/dashboard', 
                'leftmenu'=>'swim-service-advisor/view',
                'serviceadviserlist'=>'swim-customerapi/adviserlist',
                'allocatedlist'=>'swim-branchapi/allocatedlist',
                'customerdetails'=>'swim-branchapi/customerdetails',
                'tokenstatuscheck'=>'swim-customerapi/tokenstatuscheck',
                'tokengeneration'=>'swim-customerapi/tokengeneration',
				'branchadvisor'=>'swim-branchapi/branchadvisor',
				'dealersuperadminlogin'=>'swim-branchapi/dealersuperadminlogin',
				'dealerbranchlist'=>'swim-branchapi/dealerbranchlist',
				'tokenlistall'=>'swim-branchapi/tokenlistall',
				'tokenlistservice'=>'swim-branchapi/tokenlistservice',
				'tokenlistpickup'=>'swim-branchapi/tokenlistpickup',
				'tokenstatusupdate'=>'swim-branchapi/tokenstatusupdate',
				'availableadvisorlist'=>'swim-branchapi/availableadvisorlist',
				'advisorlist'=>'swim-branchapi/advisorlist',
				'advisorstatusupdate'=>'swim-branchapi/advisorstatusupdate',
				'advisoractivestatusupdate'=>'swim-branchapi/advisoractivestatusupdate',
				'availablestatusupdate'=>'swim-branchapi/availablestatusupdate',
                'swimcustomerstatus'=>'swim-customer/status',
                'swimcustomerpopup'=>'swim-customer/popup',
                'swimcustomerinsert'=>'swim-customer/insert',
                'swimcustomerdetail'=>'swim-customer/create',
                'swimservicedetail'=>'swim-service-advisor/advisorpopup',
                'swimadvisorstatuschange'=>'swim-service-advisor/statuschange',
                'swimadvisordetail'=>'swim-service-advisor/index',
                'swimcustomeravgtime'=>'swim-customer-avg-time/avgtime',
                 'youtubecategory'=>'category-management/categorylistyoutube',

                //New
                'videolist'=>'customer-api/categorylistyoutube',
                'relatedvideo'=>'customer-api/categorylistrelatedvideo',
                'categorylist'=>'customer-api/categorylist',
                'categoryfav'=>'customer-api/categorylistfav',
                'categoryfavhome'=>'customer-api/categorylistfavhome',
                

//'news/<id:\w+>' => 'newslisting/index', 
				
            ],  
        ],
        
    ],
    'params' => $params,
];
