<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\BnetUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'MobaZ Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bnet-user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
//            'acct_userid',
            'acct_email:email',
//            'auth_admin',
            //'auth_normallogin',
            //'auth_changepass',
            //'auth_changeprofile',
            //'auth_botlogin',
            //'auth_operator',
            //'new_at_team_flag',
            'auth_lock',
            //'auth_locktime:datetime',
//            'auth_lockreason',
            //'auth_mute',
            //'auth_mutetime:datetime',
            //'auth_mutereason',
            //'auth_command_groups',
            'acct_lastlogin_time:datetime',
            'acct_lastlogin_owner',
//            'acct_lastlogin_clienttag',
            'acct_lastlogin_ip',
//            'auth_announce',
            //'acct_userlang',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
