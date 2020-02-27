<?php

use yii\grid\GridView;

?>

<div>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'front',
            'back',
            'study_time',
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'card',
                'template' => '{update}&nbsp;&nbsp;&nbsp;{delete}',
            ],
        ]
    ]); ?>
</div>