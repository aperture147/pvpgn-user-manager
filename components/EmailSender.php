<?php

namespace app\components;

use app\models\BnetUser;
use SendGrid;
use SendGrid\Mail\Mail;
use SendGrid\Mail\TypeException;
use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class EmailSender
{

    /**
     * @param $bnetUser BnetUser
     * @return string
     * @throws Exception
     * @throws ServerErrorHttpException
     * @throws TypeException
     */
    static public function sendVerification($bnetUser)
    {
        $confirmToken = Yii::$app->security->generateRandomString();

        $email = new Mail();
        $email->setFrom("verify@mobavietnam.com", "Mobavietnam");
        $email->addTo($bnetUser->acct_email, $bnetUser->username);
        $email->setTemplateId(SENDGRID_TEMPLATE_ID);
        $email->addDynamicTemplateDatas([
            "username" => $bnetUser->username,
            "confirm_url" => Url::home() . Url::to(['/api/user/verify', 'token' => $confirmToken])
        ]);
        $email->setAsm(SENDGRID_ASM);
        $sendgrid = new SendGrid(SENDGRID_APIKEY);
        $response = $sendgrid->send($email);
        if ($response->statusCode() >= 400)
            throw new ServerErrorHttpException("Cannot send verification email");
        // Cache for 15 mins, but we give it one more minutes
        Yii::$app->cache->add($confirmToken, $bnetUser->uid, 960);
        return $confirmToken;
    }

    /**
     * @param $confirmToken string
     * @return bool
     * @throws BadRequestHttpException
     */
    static public function checkVerification($confirmToken)
    {
        $cache = Yii::$app->getCache();
        if ($cache->exists($confirmToken)) {
            $user = BnetUser::find()->where(["uid" => $cache->get($confirmToken)])->one();
            Yii::$app->cache->delete($confirmToken);
            return $user && $user->unban();
        }
        throw new BadRequestHttpException("Invalid token");
    }
}