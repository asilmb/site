<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin() ?>
<h1>Sign up</h1>
<p>Create a free account.</p>

<p>We'll send you an email to confirm your address, so please ensure your email
    address is correct.
</p>
<?= $form->field($model, 'mail')->input('email') ?>
<div class="form-group">
    <div>
        <?= Html::submitButton('Sign Up', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>