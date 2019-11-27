<?php

namespace app\controllers;

use yii\db\ActiveRecord;
use yii\web\Controller;
use app\models\SignupFormMail;
use Yii;
use app\models\User;
use yii\web\IdentityInterface;
//use yii\controllers\Mail;

class AnkiController extends Controller
{
    public function actionRegistration(){
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new SignUpFormMail();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){

            $mail = new Mail();
            $mail->mail = $model->email;
            $mail->hash = hash("md5",$model->email);
            if($mail->save()){
                $this->sentEmail($mail);
                return $this->goHome();
            }

        }

        return $this->render('registration', compact('model'));
    }
    public function sentEmail(Mail $mail){
        $confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/sign-up', 'hash' => $mail->hash]);
        $msg_html  = "<html><body style='font-family:Arial,sans-serif;'>";
        $msg_html .= "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>Здравствуйте!</a></h2>\r\n";
        $msg_html .= "<p><strong>Подтвердите свой e-mail.</strong></p>\r\n";
        $msg_html .= "<p><strong>Для этого перейдите по ссылке </strong><a href='". $confirmLink."'>$confirmLink</a></p>\r\n";
        $msg_html .= "</body></html>";

        Yii::$app->mailer->compose()
            ->setTo($mail->mail)
            ->setFrom('anki@gmail.com')
            ->setSubject('Confirmation of registration')
            ->setHtmlbody("Follow the link below to confirm your email: $msg_html")
            ->send();

    }

}
