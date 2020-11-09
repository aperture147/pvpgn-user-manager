<?php

namespace app\models\forms;

use yii\base\Model;

class BnetUserPasswordForm extends Model
{
    public $password;

    public function rules()
    {
        return [
            [['password'], 'required']
        ];
    }
}