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
            echo Html::a('Study Now', ['study', 'id' => $model->getId()], ['class' => 'btn btn-success']);
        } else {
            echo Html::a('Create', ['card/create', 'deck_id' => $model->getId()], ['class' => 'btn btn-primary']);
        }
         ?>

        <?= Html::a('Update', ['update', 'id' => $model->getId()], ['class' => 'btn btn-primary']) ?>

        <?= Html::a('Delete', ['delete', 'id' => $model->getId()], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


    <?= $this->render('/card/_cardList', [
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
