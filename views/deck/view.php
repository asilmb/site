<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View
 * @var $model app\models\Deck
 * @var $dataProvider DataProvider
 * @var $isEmpty boolean
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Decks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?php
        if (!$isEmpty){
            echo Html::a('Study Now', ['study', 'deckId' => $model->getId()], ['class' => 'btn btn-success']);
        } else {
            echo Html::a('Create', ['card/create', 'deckId' => $model->getId()], ['class' => 'btn btn-primary']);
        }
         ?>

    </p>


    <?= $this->render('/card/_cardList', [
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
