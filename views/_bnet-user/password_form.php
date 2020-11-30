<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\forms\BnetUserPasswordForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Update password';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bnet-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
