<?php
use yii\helpers\Html;
use app\controllers\AnkiController;


$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['anki/sign-up', 'hash' => $mail->hash]);
?>
<div class="password-reset">
    <p>Hello friend,</p>

    <p>Follow the link below to confirm your email:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>


