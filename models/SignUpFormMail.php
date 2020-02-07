<?php


namespace app\models;

use yii\base\Model;


class SignUpFormMail extends Model
{
    public $mail;

    public function rules()
    {
        return [
            [['mail'], 'required', 'message' => 'Fill in the field'],
            ['mail', 'unique', 'targetClass' => User::className(), 'message' => 'A user with this mail already exists.'],
            ['mail', 'unique', 'targetClass' => Mail::className(), 'message' => 'Сonfirm your email. Check your email.'],
            ['mail', 'email', 'message' => "The email isn't correct"],
        ];
    }

    public function attributeLabels()
    {
        return [
            'mail' => 'Enter Email',
        ];
    }
}