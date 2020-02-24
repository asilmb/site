<?php


namespace app\controllers;


use app\forms\DeckForm;
use app\models\Card;
use Yii;
use app\models\Deck;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DeckController extends Controller
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

    public function actionIndex()
    {

        $deckModel = Deck::findAll(['user_id' => Yii::$app->user->id]);
        $decksNumber = count($deckModel);
        return $this->render('index', ['model' => $deckModel, 'decksNumber' => $decksNumber]);
    }

    public function actionCreate()
    {
        $deckForm = new DeckForm();
        if ($deckForm->load(\Yii::$app->request->post()) && $deckForm->validate()) {
            $deckModel = new Deck(\Yii::$app->request->getBodyParam('DeckForm'));
            $deckModel->setUserId(Yii::$app->user->id);
            try {
                if ($deckModel->save()) {
                    Yii::$app->session->setFlash('success', 'Deck successfully added');
                    return $this->redirect('index');
                }
            } catch (\Exception $e) {
                throw new HttpException(500, $e->getMessage());
            }
        }
        return $this->render('create', ['model' => $deckForm]);
    }

    public function actionView($deckId)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Card::find()->where(['deck_id' => $deckId]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        try {
            return $this->render('view', [
                'model' => Deck::findModel($deckId),
                'dataProvider' => $dataProvider,
                'isEmpty' => $dataProvider->getCount() > 0 ? false : true,
            ]);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException('Deck not found');
        }
    }

    public function actionUpdate($deckId)
    {
        try {
            $deckModel = Deck::findModel($deckId);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException('Deck not found');
        }

        if ($deckModel->load(Yii::$app->request->post()) && $deckModel->save()) {
            return $this->redirect(['view', 'deckId' => $deckModel->getId()]);
        }

        return $this->render('update', ['model' => $deckModel,]);
    }

    public function actionDelete($deckId)
    {
        try {
            if (Deck::findModel($deckId)->delete()) {
                return $this->redirect(['index']);
            }
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException('Failed to remove deck.');
        }
    }

    public function actionStudy($deckId, $card_id = null, $success = null)
    {
        if (\Yii::$app->request->isAjax) {
            if ($success) {
                $cardModel = Card::findModel($card_id);
                $cardModel->setStudyTime(Card::nextDay());
                try {
                    $cardModel->update();
                } catch (\Exception $e) {
                    throw new HttpException(500, $e->getMessage());
                }
            }
            return $this->renderPartial('study', ['model' => $this->getNewCard($deckId,$card_id)]);
        }

        return $this->render('study', ['model' => $this->getNewCard($deckId,$card_id)]);
    }

    private function getNewCard($deckId,$card_id): Card
    {
        try {
            return Card::findCard($deckId,$card_id);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException('There are no cards in the deck.');
        }
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}