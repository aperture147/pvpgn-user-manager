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
        $confirmToken = md5(Yii::$app->security->generateRandomString() . $bnetUser->acct_email . time());

        $email = new Mail();
        $email->setFrom("verify@mobavietnam.com", "Mobavietnam");
        $email->addTo($bnetUser->acct_email, $bnetUser->username);
        $email->setTemplateId(SENDGRID_TEMPLATE_ID);
        $email->addDynamicTemplateDatas([
            "username" => $bnetUser->username,
            "confirm_url" => getenv("HOST") . Url::to(['/api/user/verify', 'token' => $confirmToken])
        ]);
        $email->setAsm(SENDGRID_ASM);
        $sendgrid = new SendGrid(SENDGRID_APIKEY);
        $response = $sendgrid->send($email);
        if ($response->statusCode() >= 400)
            throw new ServerErrorHttpException("Cannot send verification email");
        // Cache for 15 mins, but we give it five more minutes if email sending is delayed
        Yii::$app->cache->add($confirmToken, $bnetUser->uid, 1200);
        return $confirmToken;
    }

    /**
     * @param $bnetUser
     * @throws ServerErrorHttpException
     * @throws TypeException
     */
    static public function sendVerified($bnetUser)
    {
        $email = new Mail();
        $email->setFrom("verify@mobavietnam.com", "Mobavietnam");
        $email->addTo($bnetUser->acct_email, $bnetUser->username);
        $email->setTemplateId(SENDGRID_VERIFIED_TEMPLATE_ID);
        $email->addDynamicTemplateDatas([
            "username" => $bnetUser->username,
        ]);
        $email->setAsm(SENDGRID_ASM);
        $sendgrid = new SendGrid(SENDGRID_APIKEY);
        $response = $sendgrid->send($email);
        if ($response->statusCode() >= 400)
            throw new ServerErrorHttpException("Cannot send verified email");
    }

    /**
     * @param $confirmToken string
     * @return bool
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     * @throws TypeException
     */
    static public function checkVerification($confirmToken)
    {
        $cache = Yii::$app->getCache();
        if ($cache->exists($confirmToken)) {
            if ($user = BnetUser::findOne(["uid" => $cache->get($confirmToken)])) {
                Yii::$app->cache->delete($confirmToken);
                self::sendVerified($user);
                return $user->unban();
            }
        }
        throw new BadRequestHttpException("Invalid token");
    }
}