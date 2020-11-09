<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BnetUser */

$this->title = 'Update MobaZ User: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'MobaZ Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->uid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bnet-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
