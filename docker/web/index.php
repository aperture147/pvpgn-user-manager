<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

defined('SENDGRID_TEMPLATE_ID') or define('SENDGRID_TEMPLATE_ID', getenv('SENDGRID_TEMPLATE_ID'));
defined('SENDGRID_VERIFIED_TEMPLATE_ID') or define('SENDGRID_VERIFIED_TEMPLATE_ID', getenv('SENDGRID_TEMPLATE_ID'));
defined('SENDGRID_APIKEY') or define('SENDGRID_APIKEY', getenv('SENDGRID_APIKEY'));
defined('SENDGRID_ASM') or define('SENDGRID_ASM', intval(getenv('SENDGRID_ASM')));

(new yii\web\Application($config))->run();
