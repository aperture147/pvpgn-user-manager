<?php

namespace app\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BnetUser;

/**
 * BnetUserSearch represents the model behind the search form of `app\models\BnetUser`.
 */
class BnetUserSearch extends BnetUser
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'acct_userid', 'new_at_team_flag', 'auth_locktime', 'auth_mutetime', 'acct_lastlogin_time'], 'integer'],
            [['acct_username', 'username', 'acct_passhash1', 'acct_email', 'auth_admin', 'auth_normallogin', 'auth_changepass', 'auth_changeprofile', 'auth_botlogin', 'auth_operator', 'auth_lock', 'auth_lockreason', 'auth_mute', 'auth_mutereason', 'auth_command_groups', 'acct_lastlogin_owner', 'acct_lastlogin_clienttag', 'acct_lastlogin_ip', 'auth_announce', 'acct_userlang'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BnetUser::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'uid' => $this->uid,
            'acct_userid' => $this->acct_userid,
            'new_at_team_flag' => $this->new_at_team_flag,
            'auth_locktime' => $this->auth_locktime,
            'auth_mutetime' => $this->auth_mutetime,
            'acct_lastlogin_time' => $this->acct_lastlogin_time,
        ]);

        $query->andFilterWhere(['like', 'acct_username', $this->acct_username])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'acct_passhash1', $this->acct_passhash1])
            ->andFilterWhere(['like', 'acct_email', $this->acct_email])
            ->andFilterWhere(['like', 'auth_admin', $this->auth_admin])
            ->andFilterWhere(['like', 'auth_normallogin', $this->auth_normallogin])
            ->andFilterWhere(['like', 'auth_changepass', $this->auth_changepass])
            ->andFilterWhere(['like', 'auth_changeprofile', $this->auth_changeprofile])
            ->andFilterWhere(['like', 'auth_botlogin', $this->auth_botlogin])
            ->andFilterWhere(['like', 'auth_operator', $this->auth_operator])
            ->andFilterWhere(['like', 'auth_lock', $this->auth_lock])
            ->andFilterWhere(['like', 'auth_lockreason', $this->auth_lockreason])
            ->andFilterWhere(['like', 'auth_mute', $this->auth_mute])
            ->andFilterWhere(['like', 'auth_mutereason', $this->auth_mutereason])
            ->andFilterWhere(['like', 'auth_command_groups', $this->auth_command_groups])
            ->andFilterWhere(['like', 'acct_lastlogin_owner', $this->acct_lastlogin_owner])
            ->andFilterWhere(['like', 'acct_lastlogin_clienttag', $this->acct_lastlogin_clienttag])
            ->andFilterWhere(['like', 'acct_lastlogin_ip', $this->acct_lastlogin_ip]);

        return $dataProvider;
    }
}
