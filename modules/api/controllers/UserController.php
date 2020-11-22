<?php


namespace app\modules\api\controllers;


use app\components\EmailSender;
use app\models\BnetUser;
use app\modules\api\models\LoginForm;
use app\modules\api\models\SigninForm;
use SendGrid\Mail\TypeException;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;

class UserController extends Controller
{

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
     * @return string[]
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post(), '')) {
            $user = BnetUser::findOne(["username" => $model]);
            if ($user->checkPassword($model->password)) {
                if ($user->isBanned()) {
                    if ($user->isVerified())
                        throw new ForbiddenHttpException("User banned");
                    throw new ForbiddenHttpException("User not verified");
                }
                return [
                    "message" => "Login succeeded"
                ];
            }
        }
        throw new BadRequestHttpException("Cannot login, wrong user credential");
    }

    /**
     * @return string[]
     * @throws BadRequestHttpException
     * @throws Exception
     * @throws TypeException
     */
    public function actionSignup()
    {
        $model = new SigninForm();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return [
                "message" => "Check your email for verification"
            ];
        }

        throw new BadRequestHttpException("Cannot create new User");
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
            if ($user && strcmp($user->auth_lock, 'true') === 0) {
                if (!$user->isVerified()) {
                    EmailSender::sendVerification($user);
                    return [
                        "message" => "Check your email for verification"
                    ];
                }
                throw new BadRequestHttpException("User banned");
            }
        }
        throw new BadRequestHttpException("Invalid email");
    }
}