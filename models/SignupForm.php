<?php


namespace app\models;


use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $passwordConfirmation;
    public function rules() {
        return [
            [['username', 'password','passwordConfirmation'], 'required', 'message' => 'Заполните поле'],
            ['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
            ['passwordConfirmation','compare', 'compareAttribute' => 'password','message' => 'Пароли не совпадают'],

        ];
    }
    public function attributeLabels() {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'passwordConfirmation' => 'Подтвердите пароль'

        ];
    }
}