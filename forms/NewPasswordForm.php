<?php


namespace app\forms;


use app\models\Mail;
use yii\base\Model;

class NewPasswordForm extends Model
{
    public $id;
    public $password;
    public $hash;
    public $password_repeat;

    public function rules()
    {
        return [
            ['hash', 'exist', 'targetClass' => Mail::className(), 'message' => 'This login is already taken'],
            [['password', 'password_repeat'], 'required', 'message' => 'Fill in the field'],
            ['password', 'match', 'pattern' => '/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]/','message'=>'Password
Use a combination of at least 3 types of characters:lowercase letters, uppercase letters, numbers, symbols, and other letters'],
            ['password','string','length'=>[6,20],'message'=>'Use 6 to 20 characters'],
            ['password', 'compare', 'message' => 'Passwords do not match'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Password',
            'password_repeat' => 'Confirm the password'
        ];
    }
}