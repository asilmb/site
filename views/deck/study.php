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

    <h2><?= $model['front']; ?></h2>
    <hr>
    <h2 class="invisible">
        <?= $model['back']; ?>
    </h2>

    <?php Pjax::end(); ?>
    <div class="invisible ">
        <p>
            Remember this word?
        </p>

        <?= Html::submitButton('Yes', ['id' => $model['deck_id'], 'class' => 'btn btn-success']) ?>

        <?= Html::a("No", ['study', 'id' => $model['deck_id']], ['class' => 'btn  btn-danger']); ?>

    </div>
    <hr>
    <?= Html::button('Show Answer', ['class' => 'btn btn-lg btn-primary']) ?>

</div>
