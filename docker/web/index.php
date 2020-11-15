<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

defined('SENDGRID_TEMPLATE_ID') or define('SENDGRID_TEMPLATE_ID', 'd-bd71054894154f7a940dd0a8fa21e18b');
defined('SENDGRID_APIKEY') or define('SENDGRID_APIKEY', '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');
defined('SENDGRID_ASM') or define('SENDGRID_ASM', 15001);

(new yii\web\Application($config))->run();
