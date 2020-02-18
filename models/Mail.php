<?php


namespace app\models;
/**
 * This is the model class for table "mail".
 *
 * @property int $id
 * @property string $mail
 * @property string $hash
 */

use Yii;
use yii\db\ActiveRecord;


class Mail extends ActiveRecord
{

    public static function tableName()
    {
        return '{{mail}}';
    }

    public function setMail($mail){
        $this->mail = $mail;
    }

    public function getMail(){
        return $this->mail;
    }

    public function setHash($mail){
        $this->hash = hash("md5", $mail);
    }

    public function getHash(){
        return $this->hash;
    }

    public static function primaryKey()
    {
        return ['mail'];
    }

    public function sendEmail()
    {
        $user = User::findOne(['mail' => $this->mail,]);

        if (!$user) {
            return false;
        }
        $confirmLink = Yii::$app->urlManager->createAbsoluteUrl([YII::$app->params['resetPassword'], 'hash' => $this->hash]);
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordReset-html'],
                [
                    'user' => $user,
                    'confirmLink'=>$confirmLink
                ]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->mail)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }

}