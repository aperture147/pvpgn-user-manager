<?php


namespace app\modules\api\controllers;


use app\components\EmailSender;
use app\models\BnetUser;
use app\modules\api\models\UserForm;
use SendGrid\Mail\TypeException;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class UserController extends Controller
{
    /**
     * @return string[]
     * @throws BadRequestHttpException
     */
    public function actionSignup()
    {
        $model = new UserForm();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return [
                "message" => "Check your email for verification"
            ];
        }

        throw new BadRequestHttpException("Cannot create new User");
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'signup' => ['post'],
                'login' => ['post'],
                'verify' => ['get'],
                'resend-verification' => ['get']
            ]
        ];
        return $behaviors;
    }

    /**
     * @param null $token
     * @return string[]
     * @throws BadRequestHttpException
     */
    public function actionVerify($token = null)
    {
        if ($token) {
            if (EmailSender::checkVerification($token)) {
                return ["message" => "ok"];
            }
        }
        throw new BadRequestHttpException("Invalid token");
    }

    /**
     * @param null $email
     * @return string[]
     * @throws BadRequestHttpException
     * @throws TypeException
     * @throws Exception
     */
    public function actionResendVerification($email = null)
    {
        if ($email) {
            $user = BnetUser::findOne(['acct_email' => $email]);
            if ($user) {
                EmailSender::sendVerification($user);
                return [
                    "message" => "Check your email for verification"
                ];
            }
        }
        throw new BadRequestHttpException("Invalid email");
    }
}