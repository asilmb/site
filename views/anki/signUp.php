<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Card */
/* @var $imgModel app\models\Card */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-group">
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <div>
        <?= Html::submitButton('Sign Up', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
