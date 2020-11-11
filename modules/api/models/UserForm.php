<?php

namespace app\modules\api\models;

use app\components\EmailSender;
use app\helpers\PvpgnHash;
use app\models\BnetUser;
use SendGrid\Mail\TypeException;
use yii\base\Exception;
use yii\base\Model;
use yii\web\BadRequestHttpException;

class UserForm extends Model
{
    public $email;
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password', 'username'], 'required'],
            ['email', 'email'],
            ['username', 'trim', 'max' => 255],
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
            $user->ban("Chua xac thuc email");
            EmailSender::sendVerification($user);
            return $user->save($runValidation, $attributeNames);

        } else throw new BadRequestHttpException("User existed");
    }
}