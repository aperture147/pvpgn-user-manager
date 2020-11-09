<?php


namespace app\controllers;


use app\helpers\PvpgnHash;
use app\models\BnetUser;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class MobazLoginController extends Controller
{
    function actionIndex()
    {
        $request = Yii::$app->request;
        $username = strtolower(trim($request->post("username")));
        $password = strtolower(trim($request->post("password")));
        if ($username && $password) {
            $user = BnetUser::find()->where(["username" => $username])->one();
            if ($user) {
                $hash = $user->acct_passhash1;
                if (PvpgnHash::get_hash($password) === $hash) {
                    return [
                        'statusCode' => 200,
                        'message' => "Verify succeeded"
                    ];
                }
            }
        }
        return [
            'statusCode' => 400,
            'message' => "Wrong username or password"
        ];
    }

    function actionSignup()
    {
        $request = Yii::$app->request;
        $username = strtolower(trim($request->post("username")));
        $password = strtolower(trim($request->post("password")));
        if ($username && $password) {
            if (!BnetUser::find()->where(["username" => $username])->exists()) {
                $lastUser = BnetUser::find()->orderBy(['uid' => SORT_DESC])->limit(1)->one();
                $uid = 1;
                if ($lastUser) $uid = $lastUser->uid + 1;
                $user = new BnetUser();
                $user->uid = $uid;
                $user->acct_userid = $uid;
                $user->username = $username;
                $user->acct_username = $username;
                $user->acct_passhash1 = PvpgnHash::get_hash($password);
                if ($user->save())
                    return [
                        'statusCode' => 200,
                        'message' => "User created"
                    ];
                return [
                    'statusCode' => 500,
                    'message' => "Server error, cannot create user"
                ];
            } else return [
                'statusCode' => 400,
                'message' => "User already existed"
            ];
        }
        return [
            'statusCode' => 400,
            'message' => "No username or password entered"
        ];
    }
}