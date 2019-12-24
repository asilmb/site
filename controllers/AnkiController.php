<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\SignUpForm;
use yii\web\Controller;
use app\models\SignupFormMail;
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
                'only' => ['login', 'logout', 'signUp', 'registration'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signUp', 'registration'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                        'actions' => ['registration'],
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
        $model = new SignUpFormMail();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $mail = new Mail();
            $mail->mail = $model->mail;
            $mail->hash = hash("md5", $model->mail);
            try {
                if ($mail->save()) {
                    $this->sentEmail($mail);
                    Yii::$app->session->setFlash('success', 'Сonfirm your email. Check your email.');
                    return $this->goHome();
                }
            } catch (\Exception $e) {
                throw new HttpException(500, $e->getMessage());
            }
        }
        return $this->render('registration', ['model' => $model]);
    }


    public function sentEmail(Mail $mail)
    {
        $confirmLink = Yii::$app->urlManager->createAbsoluteUrl([YII::$app->params['signUp'], 'hash' => $mail->hash]);
        Yii::$app->mailer->compose(['html' => 'user-signup-comfirm-html'], ['confirmLink' => $confirmLink])
            ->setTo($mail->mail)
            ->setFrom('anki@gmail.com')
            ->setSubject('Confirmation of registration')
            ->send();
        return true;
    }

    public function actionSignUp()
    {
        $model = new SignUpForm();
        $mail = Mail::findOne(['hash' => Yii::$app->request->get('hash')]);
        if (!$mail) {
            throw new HttpException(500, 'Internal Server Error');
        }
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {

            $user = new User();
            $user->username = $model->username;
            $user->password = \Yii::$app->security->generatePasswordHash($model->password);
            $user->mail = $mail->mail;
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
        return $this->render('signUp', ['model' => $model]);
    }


    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
