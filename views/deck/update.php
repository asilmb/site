<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Update Deck: ' . $model->getDeckName();
$this->params['breadcrumbs'][] = ['label' => 'Decks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getDeckName(), 'url' => ['view', 'deckId' => $model->getId()]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
