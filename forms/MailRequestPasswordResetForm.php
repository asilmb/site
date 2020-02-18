<?php


namespace app\forms;


use app\models\Mail;
use app\models\User;
use Yii;
use yii\base\Model;

class MailRequestPasswordResetForm extends Model
{
    public $mail;

    public function rules()
    {
        return [
            [['mail'], 'required', 'message' => 'Fill in the field'],
            ['mail', 'email', 'message' => "The email isn't correct"],
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