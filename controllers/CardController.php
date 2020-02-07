<?php


namespace app\controllers;

use Yii;
use app\models\Card;
use app\models\Deck;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class CardController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionCreate()
    {

        $deckList = Deck::findAll(['user_id' => Yii::$app->user->id]);
        $model = new Card();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->setStudyTime(new Expression('NOW()'));
            try {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Card successfully added');
                    return $this->redirect(['create']);
                }
            } catch (\Exception $e) {
                throw new HttpException(500, $e->getMessage());
            }
        }
        return $this->render('create', ['model' => $model, 'deckList' => $deckList]);
    }

    public function actionUpdate($id)
    {
        $deckList = Deck::findAll(['user_id' => Yii::$app->user->id]);
        try {
            $model = Card::findModel($id);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['deck/view', 'id' => $model->deck_id]);
        }

        return $this->render('update', ['model' => $model, 'deckList' => $deckList]);
    }

    public function actionDelete($id)
    {
        try {
            $model = Card::findModel($id);
            $deckId = $model->deck_id;
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException();
        }
        try {

            if ($model->delete()) {
                Yii::$app->session->setFlash('success', 'Card successfully deleted');
                return $this->redirect(['deck/view', 'id' => $deckId]);
            }
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException('Failed to remove deck.');
        }
    }

}