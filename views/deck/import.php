<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\forms\MailForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'File import';
?>

<div class="form-group col-lg-6">
    <h1>File import</h1>

    <p>Imported file must be in .xls format</p>

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'file')->fileInput() ?>
    <div>
        <?= Html::submitButton('Import', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
