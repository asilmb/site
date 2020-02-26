<?php


namespace app\models;
namespace app\forms;
/**
 * Class SignUpForm
 *
 * This is the form class "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $role
 * @property string $mail
 */

use app\models\Mail;
use app\models\User;
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
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]{3,16}$/', 'message' => 'Login length from 3 to 16 characters'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => 'This login is already taken'],
            ['password', 'match', 'pattern' => '/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]/','message'=>'Use a combination of at least 3 types of characters:lowercase letters, uppercase letters, numbers, symbols, and other letters'],
            ['password','string','length'=>[6,20],'message'=>'Use 6 to 20 characters'],
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