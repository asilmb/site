<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Update a Card';
$this->params['breadcrumbs'][] = ['label' => 'Decks', 'url' => ['deck/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <?= Html::img($model->getImage(),['width'=>200]);?>



    <?= $this->render('_form', [
        'model' => $model,
        'deckList' => $deckList,
        'uploadModel' => $uploadModel,
    ]) ?>

</div>
