<?php


namespace app\controllers;

use app\forms\CardForm;
use app\models\ImageUpload;
use Yii;
use app\models\Card;
use app\models\Deck;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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

    public function actionCreate($deck_id = null)
    {
        $imgModel = new ImageUpload;
        $cardForm = new CardForm();
        if ($cardForm->load(Yii::$app->request->post()) && $cardForm->validate()) {
            $cardModel = new Card(\Yii::$app->request->getBodyParam('CardForm'));
            $cardModel->setStudyTime(new Expression('NOW()'));
            $file = UploadedFile::getInstance($imgModel, 'image');
            $cardModel->saveImage($imgModel->uploadFile($file, $cardModel->image));
            try {
                if ($cardModel->save()) {
                    Yii::$app->session->setFlash('success', 'Card successfully added');
                    return $this->redirect(['create', 'deck_id' => $deck_id]);
                }
            } catch (\Exception $e) {
                throw new HttpException(500, $e->getMessage());
            }
        }
        $deckList = Deck::findAll(['user_id' => Yii::$app->user->id]);
        $cardForm->deck_id = $deck_id;
        return $this->render('create', ['imgModel' => $imgModel, 'model' => $cardForm, 'deckList' => $deckList]);
    }

    public function actionUpdate($id)
    {
        $deckList = Deck::findAll(['user_id' => Yii::$app->user->id]);
        try {
            $cardModel = Card::findModel($id);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException();
        }

        if ($cardModel->load(Yii::$app->request->post()) && $cardModel->save()) {
            return $this->redirect(['deck/view', 'id' => $cardModel->deck_id]);
        }

        return $this->render('update', ['model' => $cardModel, 'deckList' => $deckList]);
    }

    public function actionDelete($id)
    {
        try {
            $cardModel = Card::findModel($id);
            $deckId = $cardModel->deck_id;
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException();
        }
        try {

            if ($cardModel->delete()) {
                Yii::$app->session->setFlash('success', 'Card successfully deleted');
                return $this->redirect(['deck/view', 'id' => $deckId]);
            }
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException('Failed to remove deck.');
        }
    }

}