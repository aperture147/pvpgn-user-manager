<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BnetUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bnet-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uid')->textInput() ?>

    <?= $form->field($model, 'acct_username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'acct_userid')->textInput() ?>

    <?= $form->field($model, 'acct_passhash1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'acct_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_admin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_normallogin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_changepass')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_changeprofile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_botlogin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_operator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'new_at_team_flag')->textInput() ?>

    <?= $form->field($model, 'auth_lock')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_locktime')->textInput() ?>

    <?= $form->field($model, 'auth_lockreason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_mute')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_mutetime')->textInput() ?>

    <?= $form->field($model, 'auth_mutereason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_command_groups')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'acct_lastlogin_time')->textInput() ?>

    <?= $form->field($model, 'acct_lastlogin_owner')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'acct_lastlogin_clienttag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'acct_lastlogin_ip')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
