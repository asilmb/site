<?php

namespace app\controllers;

use app\models\SignUpForm;
use yii\web\Controller;
use app\models\SignupFormMail;
use Yii;
use app\models\User;
use app\models\Mail;
use yii\web\IdentityInterface;


class AnkiController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRegistration()
    {
        $model = new SignUpFormMail();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $mail = new Mail();
            $mail->mail = $model->mail;
            $mail->hash = hash("md5", $model->mail);
            $mail->save();
            $this->sentEmail($mail);
            Yii::$app->session->setFlash('success', 'Сonfirm your email. Check your email.');
            return $this->goHome();
        }
        return $this->render('registration', ['model' => $model]);
    }


    public function sentEmail(Mail $mail)
    {
        Yii::$app->mailer->compose(['html' => 'user-signup-comfirm-html'], ['mail' => $mail])
            ->setTo($mail->mail)
            ->setFrom('anki@gmail.com')
            ->setSubject('Confirmation of registration')
            ->send();

    }

    public function actionSignUp($hash)
    {
        if (empty($hash)) {
            throw new \DomainException('Empty confirm token.');
        }
        $model = new SignUpForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {

            $user = new User();
            $mail = Mail::findOne(['hash' => $hash]);
            if (!$mail) {
                throw new \DomainException('User is not found.');
            }

            $user->username = $model->username;

            $user->password = \Yii::$app->security->generatePasswordHash($model->password);


            $user->mail = $mail->mail;
            if ($user->save()) {
                $mail->delete();
                Yii::$app->session->setFlash('success', 'Registration successful');
                return $this->goHome();
            }

        }

        return $this->render('signUp', ['model' => $model]);
    }

}
