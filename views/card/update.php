<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Update a Card';
$this->params['breadcrumbs'][] = ['label' => 'Decks', 'url' => ['deck/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'deck_id')->dropdownList(\yii\helpers\ArrayHelper::map($deckList, 'id', 'name')); ?>

    <?= $form->field($model, 'front') ?>

    <?= $form->field($model, 'back') ?>

    <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>

    <?php $form = ActiveForm::end() ?>

</div>
