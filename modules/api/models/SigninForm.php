<?php

namespace app\modules\api\models;

use app\components\EmailSender;
use app\helpers\PvpgnHash;
use app\models\BnetUser;
use SendGrid\Mail\TypeException;
use yii\base\Exception;
use yii\base\Model;
use yii\web\BadRequestHttpException;

class SigninForm extends Model
{
    public $email;
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password', 'username'], 'required'],
            ['email', 'email'],
            ['username', 'trim'],
            ['password', 'string', 'max' => 255]
        ];
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     * @throws BadRequestHttpException
     * @throws TypeException
     * @throws Exception
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $emailDomain = explode('@', $this->email);
        if (strcmp(trim(array_pop($emailDomain)), 'gmail.com') !== 0)
            throw new BadRequestHttpException("Only gmail is accepted");

        if (!BnetUser::find()->where(["or", ["username" => $this->username], ["acct_email" => $this->email]])->limit(1)->exists()) {
            $lastUser = BnetUser::find()->orderBy(['uid' => SORT_DESC])->limit(1)->one();
            $uid = $lastUser->uid + 1;
            $user = new BnetUser();
            $user->uid = $uid;
            $user->acct_userid = $uid;
            $user->acct_email = $this->email;
            $user->username = $this->username;
            $user->acct_username = $this->username;
            $user->acct_passhash1 = PvpgnHash::get_hash($this->password);
            $user->verifyBan();
            EmailSender::sendVerification($user);
            return $user->save($runValidation, $attributeNames);

        } else throw new BadRequestHttpException("User existed");
    }
}