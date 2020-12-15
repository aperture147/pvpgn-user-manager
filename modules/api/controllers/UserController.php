<?php


namespace app\modules\api\controllers;


use app\components\EmailSender;
use app\models\BnetUser;
use app\modules\api\models\LoginForm;
use app\modules\api\models\SignupForm;
use SendGrid\Mail\TypeException;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

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
            $user = BnetUser::findOne(["username" => $model->username]);
            if ($user && $user->checkPassword($model->password)) {
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
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            if ($model->save())
                return [
                    "message" => "Check your email for verification"
                ];
            throw new ServerErrorHttpException('Cannot create new User');
        }
        throw new BadRequestHttpException('Invalid input, please fill and correct all fields');
    }

    /**
     * @param null $token
     * @return Response
     * @throws BadRequestHttpException
     * @throws TypeException
     * @throws ServerErrorHttpException
     */
    public function actionVerify($token = null)
    {
        if ($token) {
            if (EmailSender::checkVerification($token)) {
                return $this->redirect(['/verified']);
            }
        }
        throw new BadRequestHttpException("Invalid token");
    }

    /**
     * @param string|null $email
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