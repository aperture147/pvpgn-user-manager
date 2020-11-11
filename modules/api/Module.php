<?php

namespace app\modules\api;

use Yii;
use yii\web\Response;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        Yii::$app->user->enableSession = false;
        Yii::$app->user->enableAutoLogin = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->on(Response::EVENT_BEFORE_SEND, function ($event) {
            $response = $event->sender;

            if ($response->data !== null) {
                $response->data = [
                    'success' => $response->isSuccessful,
                    'code' => $response->statusCode,
                    'data' => $response->data,
                ];
                $response->statusCode = 200;
            }
        });
    }
}
