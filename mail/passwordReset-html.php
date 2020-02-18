<?php

use yii\helpers\Html;

?>
<div class="password-reset">
    <p>Hello <?= $user->username ?> </p>

    <p>Follow the link below to change your password.:</p>

    <p><?= Html::a('Click here', $confirmLink) ?></p>
</div>


