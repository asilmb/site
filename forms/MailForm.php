<?php


namespace app\models;
namespace app\forms;

/**
 * Class MailForm
 *
 * This is the form class "mail".
 *
 * @property int $id
 * @property string $mail
 * @property string $hash
 */

use app\models\Mail;
use app\models\User;
use yii\base\Model;


class MailForm extends Model
{
    public $mail;

    public function rules()
    {
        return [

            [['mail'], 'required', 'message' => 'Fill in the field'],
            [['mail'],'filter','filter' => function ($value) { return strtolower($value); }],
            ['mail', 'unique', 'targetClass' => Mail::className(), 'message' => 'Сonfirm your email. Check your email.'],
            ['mail', 'unique', 'targetClass' => User::className(), 'message' => 'A user with this mail already exists.'],
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