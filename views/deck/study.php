<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Study Now';
$this->registerJsFile(
    '@web/js/scripts.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>

<div id='study' class="container" style="text-align: center">
    <?php Pjax::begin(); ?>

    <h2><?= $model['front']; ?></h2>
    <hr>
    <h2 class="invisible">
        <?= $model['back']; ?>
    </h2>


    <div class="invisible ">
        <p>
            Remember this word?
        </p>

        <?= Html::a("Yes", ['study', 'id' => $model['deck_id'], 'card_id' => $model->id, 'success' => true], ['class' => 'btn  btn-success']); ?>

        <?= Html::a("No", ['study', 'id' => $model['deck_id'], 'card_id' => $model->id, 'success' => false], ['class' => 'btn  btn-danger']); ?>

    </div>
    <hr>
    <?php Pjax::end(); ?>

    <?= Html::button('Show Answer', ['class' => 'btn btn-lg btn-primary']) ?>

</div>
