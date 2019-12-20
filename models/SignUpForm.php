<?php


namespace app\models;


use yii\base\Model;

class SignUpForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;
    public $hash;


    public function rules()
    {
        return [
            ['hash', 'unique', 'targetClass' => Mail::className(), 'message' => 'This login is already taken'],
            [['username', 'password', 'password_repeat'], 'required', 'message' => 'Fill in the field'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]{3,16}$/', 'message' => 'Invalid login'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => 'This login is already taken'],
            ['password', 'compare', 'message' => 'Passwords do not match'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Login',
            'password' => 'Password',
            'password_repeat' => 'Confirm the password'
        ];
    }
}