<?php

use yii\helpers\Html;


$this->title = 'Create a Card';
$this->params['breadcrumbs'][] = ['label' => 'Decks', 'url' => ['deck/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'deckList' => $deckList,
        'imgModel' => $imgModel,
    ]) ?>
</div>
