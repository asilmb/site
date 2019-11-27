<?php

namespace app\controllers;

use app\models\SignUpForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\controllers\AnkiController;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionHello(){
       return $this->render('hello');
       //return 'Hello, world!';
    }
    public function actionSignUp($hash){
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (empty($hash)) {
            throw new \DomainException('Empty confirm token.');
        }
        $model = new SignUpForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){

            $user = new User();
            $mail = Mail::findOne(['hash' => $hash]);
            if (!$mail) {
                throw new \DomainException('User is not found.');
            }

            $user->username = $model->username;
            if ($model->password === $model->passwordConfirmation){
                $user->password = \Yii::$app->security->generatePasswordHash($model->password);
            }
//            $checkMail = User::findOne(['mail'=>$mail->mail]);
//            if (!$checkMail){
//                throw new \DomainException('User already registered');
//            }
            $user->mail = $mail->mail;
            if($user->save()){
                $mail->delete();
                return $this->goHome();
            }

        }

        return $this->render('signUp', compact('model'));
    }


}
