<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\forms\MailForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Registration';
?>

<div class="form-group col-lg-6">
    <h1>Sign up</h1>
    <p>Create a free account.</p>

    <p>We'll send you an email to confirm your address, so please ensure your email
        address is correct.
    </p>
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'mail')->input('email', ['autofocus' => true]) ?>
    <div>
        <?= Html::submitButton('Sign Up', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
