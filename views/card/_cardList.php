<?php

use yii\grid\GridView;

?>


<?php /** @var \yii\debug\models\timeline\DataProvider $dataProvider */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'front',
        'back',
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'card',
            'template' => '{update}&nbsp;&nbsp;&nbsp;{delete}',
        ],
    ],
]); ?>
