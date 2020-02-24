<?php

namespace app\controllers;

use app\forms\MailRequestPasswordResetForm;
use app\forms\NewPasswordForm;
use app\models\LoginForm;
use app\forms\SignUpForm;
use yii\web\Controller;
use app\forms\MailForm;
use Yii;
use app\models\User;
use app\models\Mail;
use \yii\web\HttpException;
use yii\web\Response;
use yii\filters\AccessControl;


class AnkiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signUp', 'registration', 'reset-password', 'request-password-reset'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signUp', 'registration', 'reset-password', 'request-password-reset'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                        'actions' => ['registration', 'reset-password', 'request-password-reset'],
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

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
        $mailForm = new MailForm();

        if ($mailForm->load(\Yii::$app->request->post()) && $mailForm->validate()) {
            $mail = new Mail();
            $mail->setMail($mailForm->mail);
            $mail->setHash($mailForm->mail);
            try {
                if ($mail->save()) {
                    $mail->sendEmailForRegistration();
                    Yii::$app->session->setFlash('success', 'Сonfirm your email. Check your email.');
                    return $this->goHome();
                }
            } catch (\Exception $e) {
                throw new HttpException(500, $e->getMessage());
            }
        }
        return $this->render('registration', ['model' => $mailForm]);
    }

    public function actionSignUp()
    {
        $registrationForm = new SignUpForm();
        $mail = Mail::findOne(['hash' => Yii::$app->request->get('hash')]);
        if (!$mail) {
            throw new HttpException(422, 'Mail didn\'t send');
        }
        if ($registrationForm->load(\Yii::$app->request->post()) && $registrationForm->validate()) {
            $user = new User();
            $user->setUsername($registrationForm->username);
            $user->setPassword(\Yii::$app->security->generatePasswordHash($registrationForm->password));
            $user->setMail($mail->getMail());
            try {
                if ($user->save()) {
                    $mail->delete();
                    Yii::$app->session->setFlash('success', 'Registration successful');
                    Yii::$app->user->switchIdentity($user);
                    return $this->goHome();
                }
            } catch (\Exception $e) {
                throw new HttpException(500, $e->getMessage());
            }
        }
        return $this->render('signUp', ['model' => $registrationForm]);
    }


    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goHome();
        }
        return $this->render('login', ['model' => $model,]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRequestPasswordReset()
    {
        $mailForm = new MailRequestPasswordResetForm();
        if ($mailForm->load(Yii::$app->request->post()) && $mailForm->validate()) {
            $mail = new Mail();
            $mail->setMail($mailForm->mail);
            $mail->setHash($mailForm->mail);
            if (Mail::findOne($mailForm->mail)) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
            } else {
                try {
                    if ($mail->save()) {
                        $mail->sendPasswordRecoveryEmail();
                        Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                        return $this->goHome();
                    }
                } catch (\Exception $e) {
                    throw new HttpException(500, $e->getMessage());
                }
            }
        }
        return $this->render('requestPasswordReset', ['model' => $mailForm]);
    }

    public function actionResetPassword()
    {
        $newPasswordForm = new NewPasswordForm();
        $mail = Mail::findOne(['hash' => Yii::$app->request->get('hash')]);
        if (!$mail) {
            throw new HttpException(422, 'Email address not found');
        }
        if ($newPasswordForm->load(Yii::$app->request->post()) && $newPasswordForm->validate()) {
            $user = User::findOne(['mail' => $mail->getMail()]);
            $user->setPassword(\Yii::$app->security->generatePasswordHash($newPasswordForm->password));
            try {
                if ($user->save()) {
                    $mail->delete();
                    Yii::$app->session->setFlash('success', 'New password save');
                    return $this->redirect('login');
                }
            } catch (\Exception $e) {
                throw new HttpException(500, $e->getMessage());
            }
        }
        return $this->render('resetPassword', ['model' => $newPasswordForm]);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

}
