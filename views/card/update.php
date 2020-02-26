<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Update a Card';
$this->params['breadcrumbs'][] = ['label' => 'Decks', 'url' => ['deck/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="text-center">
         <?= Html::img($model->getImage(),['width'=>200]);?>
    </div>




    <?= $this->render('_form', [
        'model' => $model,
        'deckList' => $deckList,
        'uploadModel' => $uploadModel,
    ]) ?>

</div>
