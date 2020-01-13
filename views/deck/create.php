<?php


use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


$this->title = 'Create a Deck';
$this->params['breadcrumbs'][] = ['label' => 'Decks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?= HTML::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'name') ?>
    <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    <?php $form = ActiveForm::end() ?>
</div>
