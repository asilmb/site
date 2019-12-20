<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';

?>

<div>
    <h1><?= HTML::encode($this->title) ?></h1>
    <p>Please fill out the following fields to login:</p>
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= Html::submitButton('Login', ['class' => 'btn btn-success']) ?>
    <?php $form = ActiveForm::end() ?>
</div>

