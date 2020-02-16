<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request Password reset';
?>
<h1>Request password reset</h1>

<p>If you have forgotten your password, please enter your email address to reset password.</p>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'mail')->input('email', ['autofocus' => true]) ?>

        <div class="form-group">

            <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>