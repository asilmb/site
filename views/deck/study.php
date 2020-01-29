<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Study Now';
$this->registerJsFile(
    '@web/js/scripts.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>

<div class="container" style="text-align: center">
    <?php Pjax::begin(); ?>

    <h2><?= $model[$arrayIndex]['front']; ?></h2>
    <hr>
    <h2 class="invisible">
        <?= $model[$arrayIndex]['back']; ?>
    </h2>

    <div class="invisible ">
        <p>
            Remember this word?
        </p>
        <?= Html::a("Next", ['study','id' => $model[0]['deck_id']], ['class' => 'btn  btn-success']);?>

    </div>
    <?php Pjax::end(); ?>
    <hr>
    <?= Html::button('Show Answer', ['class' => 'btn btn-lg btn-primary']) ?>






</div>
