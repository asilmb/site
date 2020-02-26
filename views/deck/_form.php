<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


?>
    <div class="form-group col-lg-5">

        <h1><?= HTML::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'name')->input('',['autofocus' => true]) ?>

        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

        <?php $form = ActiveForm::end() ?>
    </div>
<?php
