<?php

use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View
 * @var $model app\models\Deck
 * @var $dataProvider DataProvider
 * @var $isEmpty boolean
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Decks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerJsFile(
    '@web/js/scripts.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
<!--<div>-->
<!--    --><?php //Modal::begin([
//        'size' => 'modal-lg',
//        'header' => '<h2>Study Now</h2>',
//        'toggleButton' => ['label' => 'click me'],
//    ]);
//
//    echo 'Choose the number of words to learn' . ' ' .
//        Html::dropDownList('wordCount', 4, [5, 10, 20, 50, 100]);
//    echo Html::submitButton('Study Now', ['class' => 'btn btn-success']);
//    Modal::end(); ?>
<!---->
<!--</div>-->
<div>
<!--    --><?php //Pjax::begin(); ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?php
        if (!$isEmpty) {
            echo Html::a('Study Now', ['study', 'deckId' => $model->getId()], ['class' => 'btn btn-success']);
        } else {
            echo Html::a('Create', ['card/create', 'deckId' => $model->getId()], ['class' => 'btn btn-primary']);
        }
        echo Html::a('Import card', ['deck/import', 'deckId' => $model->getId()], ['class' => 'btn btn-primary', 'style' => 'margin: 0px 10px;']);
        ?>

    </p>

    <p>
        Choose the number of words to learn
        <?= Html::dropDownList('limit', 20,
            [
                5 => 5,
                10 => 10,
                20 => 20,
                50 => 50,
                100 => 100
            ],
            ['id' => 'limit']) ?>;
    </p>

    <div id="cards">
        <?php echo GridView::widget([
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
            ]
        ]); ?>

    </div>



<!--    --><?php //Pjax::end(); ?>

</div>
<?php

$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;
$url = Url::to(['/deck/view', 'deckId' => $model->getId()]);
$js = <<<JS
$('#limit').on('change',function () {
    let limit = $(this).val();
    ;
    $.ajax({
    url: '$url',
    type: 'POST',
    dataType:'html',
    data: {limit: $(this).val() ,$csrfParam: '$csrfToken'},
    success: function(res) {
      $('#cards').html(res);
    },
    error:function(error){
        alert(error);
    }
    })
    
})
JS;
$this->registerJs($js);



