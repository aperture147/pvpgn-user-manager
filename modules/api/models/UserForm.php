<?php

namespace app\modules\api\models;

use app\helpers\PvpgnHash;
use app\models\BnetUser;
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
            [['password', 'username'], 'trim', 'max' => 255],
        ];
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     * @throws BadRequestHttpException
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if (!BnetUser::find()->where(["username" => $this->username])->exists()) {
            $lastUser = BnetUser::find()->orderBy(['uid' => SORT_DESC])->limit(1)->one();
            $uid = $lastUser + 1;
            $user = new BnetUser();
            $user->uid = $uid;
            $user->acct_userid = $uid;
            $user->username = $this->username;
            $user->acct_username = $this->username;
            $user->acct_passhash1 = PvpgnHash::get_hash($this->password);
            $user->ban("Chua xac thuc email");
            return $user->save($runValidation, $attributeNames);
        } else throw new BadRequestHttpException("User existed");
    }
}