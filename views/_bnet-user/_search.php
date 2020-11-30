<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\searches\BnetUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bnet-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'acct_username') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'acct_userid') ?>

    <?= $form->field($model, 'acct_passhash1') ?>

    <?php // echo $form->field($model, 'acct_email') ?>

    <?php // echo $form->field($model, 'auth_admin') ?>

    <?php // echo $form->field($model, 'auth_normallogin') ?>

    <?php // echo $form->field($model, 'auth_changepass') ?>

    <?php // echo $form->field($model, 'auth_changeprofile') ?>

    <?php // echo $form->field($model, 'auth_botlogin') ?>

    <?php // echo $form->field($model, 'auth_operator') ?>

    <?php // echo $form->field($model, 'new_at_team_flag') ?>

    <?php // echo $form->field($model, 'auth_lock') ?>

    <?php // echo $form->field($model, 'auth_locktime') ?>

    <?php // echo $form->field($model, 'auth_lockreason') ?>

    <?php // echo $form->field($model, 'auth_mute') ?>

    <?php // echo $form->field($model, 'auth_mutetime') ?>

    <?php // echo $form->field($model, 'auth_mutereason') ?>

    <?php // echo $form->field($model, 'auth_command_groups') ?>

    <?php // echo $form->field($model, 'acct_lastlogin_time') ?>

    <?php // echo $form->field($model, 'acct_lastlogin_owner') ?>

    <?php // echo $form->field($model, 'acct_lastlogin_clienttag') ?>

    <?php // echo $form->field($model, 'acct_lastlogin_ip') ?>

    <?php // echo $form->field($model, 'auth_announce') ?>

    <?php // echo $form->field($model, 'acct_userlang') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
