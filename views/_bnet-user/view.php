<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BnetUser */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'MobaZ Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="bnet-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (filter_var($model->auth_lock, FILTER_VALIDATE_BOOLEAN))
            echo Html::a('Unban', ['unban', 'id' => $model->uid], [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Are you sure you want to unban this user?',
                ]
            ]);
        else
            echo Html::a('Ban', ['ban', 'id' => $model->uid], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => 'Are you sure you want to ban this user?',
                ],
            ]);
        ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->uid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this user?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'uid',
//            'acct_username',
            'acct_userid',
            'username',
//            'acct_passhash1',
            'acct_email:email',
//            'auth_admin',
//            'auth_normallogin',
//            'auth_changepass',
//            'auth_changeprofile',
//            'auth_botlogin',
//            'auth_operator',
//            'new_at_team_flag',
            'auth_lock',
//            'auth_locktime',
            'auth_lockreason',
//            'auth_mute',
//            'auth_mutetime:datetime',
//            'auth_mutereason',
//            'auth_command_groups',
            'acct_lastlogin_time:datetime',
            'acct_lastlogin_owner',
//            'acct_lastlogin_clienttag',
            'acct_lastlogin_ip',
//            'auth_announce',
//            'acct_userlang',
        ],
    ]) ?>

</div>
