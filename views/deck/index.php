<?php

use yii\helpers\Html;

$this->title = 'Decks';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="deck-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create a Deck', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <h4>
        <?= 'The number of your decks: ' . $decksNumber ?>
    </h4>
    <?php
    echo $this->render('_deckList', [
        'model' => $model,
    ])
    ?>
</div>
