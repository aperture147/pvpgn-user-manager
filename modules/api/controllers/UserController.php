<?php


namespace app\modules\api\controllers;


use app\modules\api\models\UserForm;
use Yii;
use yii\rest\Controller;

class UserController extends Controller
{
    public function actionSignUp() {
        $model = new UserForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return [
                "message" => "Check your email for verification"
            ];
        }

        return [
            "message" => "Cannot create new user"
        ];
    }
}