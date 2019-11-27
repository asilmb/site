<?php


namespace app\models;
use yii\base\Model;

class SignupFormMail extends Model
{
    public $email;
    public $pidr;

    public function rules() {
        return [
            [['email'], 'required','message' => 'Заполните поле'],
            ['email', 'email','message'=>"The email isn't correct"],
        ];
    }
    public function attributeLabels() {
        return [
            'email' => 'Enter Email',

        ];
    }
}