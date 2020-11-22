<?php

namespace app\models;

use app\helpers\PvpgnHash;
use app\models\queries\BnetUserQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pvpgn_bnet".
 *
 * @property int $uid
 * @property string|null $acct_username
 * @property string|null $username
 * @property int|null $acct_userid
 * @property string|null $acct_passhash1
 * @property string|null $acct_email
 * @property string|null $auth_admin
 * @property string|null $auth_normallogin
 * @property string|null $auth_changepass
 * @property string|null $auth_changeprofile
 * @property string|null $auth_botlogin
 * @property string|null $auth_operator
 * @property int|null $new_at_team_flag
 * @property string|null $auth_lock
 * @property int|null $auth_locktime
 * @property string|null $auth_lockreason
 * @property string|null $auth_mute
 * @property int|null $auth_mutetime
 * @property string|null $auth_mutereason
 * @property string|null $auth_command_groups
 * @property int|null $acct_lastlogin_time
 * @property string|null $acct_lastlogin_owner
 * @property string|null $acct_lastlogin_clienttag
 * @property string|null $acct_lastlogin_ip
 */
class BnetUser extends ActiveRecord
{
    /**
     * Text is used as the ban message
     */
    const EMAIL_NOT_VERIFIED = "Email not verified";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pvpgn_BNET';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'acct_userid', 'new_at_team_flag', 'auth_locktime', 'auth_mutetime', 'acct_lastlogin_time'], 'integer'],
            [['acct_username', 'username'], 'string', 'max' => 32],
            [['acct_passhash1'], 'string', 'max' => 40],
            [['acct_email', 'auth_lockreason', 'auth_mutereason', 'acct_lastlogin_owner'], 'string', 'max' => 128],
            [['auth_admin', 'auth_normallogin', 'auth_changepass', 'auth_changeprofile', 'auth_botlogin', 'auth_operator', 'auth_lock', 'auth_mute'], 'string', 'max' => 6],
            [['auth_command_groups', 'acct_lastlogin_ip'], 'string', 'max' => 16],
            [['acct_lastlogin_clienttag'], 'string', 'max' => 4],
            [['username'], 'unique'],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'acct_username' => 'Acct Username',
            'username' => 'Username',
            'acct_userid' => 'User ID',
            'acct_passhash1' => 'Acct Passhash1',
            'acct_email' => 'Email',
            'auth_admin' => 'Is Admin',
            'auth_normallogin' => 'Auth Normallogin',
            'auth_changepass' => 'Auth Changepass',
            'auth_changeprofile' => 'Auth Changeprofile',
            'auth_botlogin' => 'Auth Botlogin',
            'auth_operator' => 'Auth Operator',
            'new_at_team_flag' => 'New At Team Flag',
            'auth_lock' => 'Banned',
            'auth_locktime' => 'Ban Duration',
            'auth_lockreason' => 'Ban Reason',
            'auth_mute' => 'Auth Mute',
            'auth_mutetime' => 'Auth Mutetime',
            'auth_mutereason' => 'Auth Mutereason',
            'auth_command_groups' => 'Auth Command Groups',
            'acct_lastlogin_time' => 'Last Login Time',
            'acct_lastlogin_owner' => 'Last Login Computer Name',
            'acct_lastlogin_clienttag' => 'Acct Lastlogin Clienttag',
            'acct_lastlogin_ip' => 'Last Login IP',
        ];
    }

    /**
     * {@inheritdoc}
     * @return BnetUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BnetUserQuery(get_called_class());
    }


    public function isBanned() {
        return (strcmp($this->auth_lock, 'true') === 0);
    }

    /**
     * @param string|null $reason
     * @return bool
     */
    public function ban($reason = null)
    {
        $this->auth_lock = 'true';
        if ($reason) $this->auth_lockreason = $reason;
        return $this->save();
    }

    /**
     * @return bool
     */
    public function verifyBan()
    {
        return $this->ban(self::EMAIL_NOT_VERIFIED);
    }

    /**
     * @return bool
     */
    public function isVerified()
    {
        return strcmp(self::EMAIL_NOT_VERIFIED, $this->auth_lockreason) !== 0;
    }

    /**
     * @return bool
     */
    public function unban()
    {
        $this->auth_lock = 'false';
        $this->auth_lockreason = '';
        return $this->save();
    }

    /**
     * @param string $password
     * @return bool
     */
    public function checkPassword(string $password)
    {
        return strcmp(PvpgnHash::get_hash($password), $this->acct_passhash1) === 0;
    }
}
