<?php


namespace app\controllers;

use app\forms\CardForm;
use app\forms\UploadForm;
use app\models\Upload;
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

    public function actionCreate($deckId = null)
    {
        $uploadForm = new UploadForm();
        $cardForm = new CardForm();
        if(!Deck::findAll($deckId)){
            throw new NotFoundHttpException('Deck not found');
        }
        $cardForm->deck_id = $deckId;
        if ($cardForm->load(Yii::$app->request->post()) && $cardForm->validate() && $uploadForm->validate()) {
            $cardModel = new Card(\Yii::$app->request->getBodyParam('CardForm'));
            if(!Deck::findAll($cardModel->getDeckId()) ){
                throw new NotFoundHttpException('Deck not found');
            }
            $file = UploadedFile::getInstance($uploadForm, 'image');
            $uploadModel = new Upload(\Yii::$app->request->getBodyParam('uploadForm'));
            $cardModel->saveImage($uploadModel->uploadFile($file, $cardModel->image));
            try {
                if ($cardModel->save()) {
                    Yii::$app->session->setFlash('success', 'Card successfully added');
                    $deckId = $cardModel->getDeckId();
                    return $this->redirect(['create', 'deckId' => $deckId]);
                }
            } catch (\Exception $e) {
                throw new HttpException(500, $e->getMessage());
            }
        }

        $deckList = Deck::findAll(['user_id' => Yii::$app->user->id]);
        return $this->render('create',['deckId' => $deckId, 'uploadModel' => $uploadForm, 'model' => $cardForm, 'deckList' => $deckList]);
    }

    public function actionUpdate($id)
    {
        $deckList = Deck::findAll(['user_id' => Yii::$app->user->id]);
        try {
            $cardModel = Card::findModel($id);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException();
        }
        $uploadForm = new UploadForm();
        if ($cardModel->load(Yii::$app->request->post()) && $uploadForm->validate()) {
            $file = UploadedFile::getInstance($uploadForm, 'image');
            $uploadModel = new Upload(\Yii::$app->request->getBodyParam('uploadForm'));
            $cardModel->saveImage($uploadModel->uploadFile($file, $cardModel->image));
            $cardModel->save();
            return $this->redirect(['deck/view', 'deckId' => $cardModel->getDeckId()]);
        }

        return $this->render('update', ['model' => $cardModel, 'deckList' => $deckList,'uploadModel' => $uploadForm]);
    }

    public function actionDelete($id)
    {
        try {
            $cardModel = Card::findModel($id);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException();
        }
        try {

            if ($cardModel->delete()) {
                Yii::$app->session->setFlash('success', 'Card successfully deleted');
                return $this->redirect(['deck/view', 'deckId' => $cardModel->getDeckId()]);
            }
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException('Failed to remove deck.');
        }
    }

}