<?php


namespace app\models;


use yii\base\Model;

class SignUpForm extends Model
{
    public $username;
    public $password;
    public $passwordConfirmation;
    public $hash;

    const HASH = 'hash';
    const REGISTRATION = 'registration';

    public function rules() {
        return [
            [['hash'], 'required', 'on' => self::HASH],

            [['username', 'password','passwordConfirmation'], 'required', 'message' => 'Заполните поле', 'on' => self::REGISTRATION],
            ['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят', 'on' => self::REGISTRATION],
            ['passwordConfirmation','compare', 'compareAttribute' => 'password','message' => 'Пароли не совпадают', 'on' => self::REGISTRATION],

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