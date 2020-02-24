<?php


namespace app\forms;

/**
 * Class MailRequestPasswordResetForm
 *
 * This is the form class "mail".
 *
 * @property int $id
 * @property string $mail
 * @property string $hash
 */

use app\models\User;
use yii\base\Model;

class MailRequestPasswordResetForm extends Model
{
    public $mail;

    public function rules()
    {
        return [
            [['mail'], 'required', 'message' => 'Fill in the field'],
            ['mail', 'email', 'message' => "The email isn't correct"],
            [['mail'],'filter','filter' => function ($value) { return strtolower($value); }],
            ['mail', 'exist','targetClass'=>User::className(),'message' => "A user with such mail does not exist."],
        ];
    }

    public function attributeLabels()
    {
        return [
            'mail' => 'Enter Email',
        ];
    }


}