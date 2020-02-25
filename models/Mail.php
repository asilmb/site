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

    public function sendEmailForRegistration()
    {
        $confirmLink = Yii::$app->urlManager->createAbsoluteUrl([YII::$app->params['signUp'], 'hash' => $this->getHash()]);
        return Yii::$app->mailer->compose(['html' => 'user-signup-comfirm-html'], ['confirmLink' => $confirmLink])
            ->setTo($this->getMail())
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setSubject('Confirmation of registration')
            ->send();
    }

    public function sendPasswordRecoveryEmail()
    {
        $user = User::findOne(['mail' => $this->getMail(),]);
        if (!$user) {
            return false;
        }
        $confirmLink = Yii::$app->urlManager->createAbsoluteUrl([YII::$app->params['resetPassword'], 'hash' => $this->getHash()]);
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
            ->setTo($this->getMail())
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }

}