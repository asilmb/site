<?php


use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


$this->title = 'Create a Deck';
$this->params['breadcrumbs'][] = ['label' => 'Decks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-group">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
