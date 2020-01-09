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

    foreach ($model as $deck) {
        echo '<pre>' .
            Html::a(print_r($deck['name'], true), ['view', 'id' => $deck['id']], ['class' => 'btn btn-outline-secondary']) .
            Html::a('Rename', ['rename', 'id' => $deck['id']], ['class' => 'btn btn-primary']) .
            Html::a('Delete', ['delete', 'id' => $deck['id']], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            . '</pre>';
    }
    ?>
</div>
