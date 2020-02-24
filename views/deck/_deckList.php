<?php

use yii\helpers\Html;

?>

<div class="deck-index">
    <?php

    foreach ($model as $deck) {
        echo '<pre>' .
            Html::a(print_r($deck['name'], true), ['view', 'deckId' => $deck['id']], ['class' => 'btn btn-outline-secondary col-xs-8']) .
            Html::a('Update', ['update', 'deckId' => $deck['id']], ['class' => 'btn btn-primary col-md-offset-2']) .
            Html::a('Delete', ['delete', 'deckId' => $deck['id']], [
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
