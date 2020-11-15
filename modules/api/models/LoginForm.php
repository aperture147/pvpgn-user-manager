<?php

namespace app\modules\api\models;

use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['password', 'username'], 'required'],
            ['username', 'trim'],
            ['password', 'string', 'max' => 255]
        ];
    }
}