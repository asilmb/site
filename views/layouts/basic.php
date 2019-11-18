<?php
use app\assets\AppAsset;
use yii\helpers\Html;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <div class="container">
            <ul class="nav nav-pills">
                <li role="pesentation" ><?= Html::a('Страны','../country')?></li>
                <li role="pesentation" ><?= Html::a('Регистрация','../site/signup')?></li>
                <li role="pesentation" class="active"><?= Html::a('Show','show')?></li>
                <li role="pesentation" ><?= Html::a('POST-TEST','test')?></li>
                <li role="pesentation" ><?= Html::a('My','../my/')?></li>
                <li role="pesentation" ><?= Html::a('Admin','../admin/user')?></li>
                <li role="pesentation" ><?= Html::a('ANKI','../anki/registration')?></li>
            </ul>
            <?= $content ?>
        </div>
    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
