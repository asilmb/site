
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'email')->input('email') ?>
<?= $form->field($model, 'pidr')->input('text') ?>
    <div class="form-group">
        <div>
            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>