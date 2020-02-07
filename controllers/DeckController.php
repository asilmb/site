<?php


namespace app\controllers;


use app\models\Card;
use Yii;
use app\models\Deck;
use yii\data\ActiveDataProvider;
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

        $model = Deck::findAll(['user_id' => Yii::$app->user->id]);
        $decksNumber = count($model);
        return $this->render('index', ['model' => $model, 'decksNumber' => $decksNumber]);
    }

    public function actionCreate()
    {
        $model = new Deck();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->setUserId(Yii::$app->user->id);
            try {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Deck successfully added');
                    return $this->redirect('index');
                }
            } catch (\Exception $e) {
                throw new HttpException(500, $e->getMessage());
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Card::find()->where(['deck_id' => $id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        try {
            return $this->render('view', [
                'model' => Deck::findModel($id),
                'dataProvider' => $dataProvider,
                'isEmpty' => $dataProvider->getCount() > 0 ?  false : true,
            ]);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException();
        }
    }

    public function actionUpdate($id)
    {
        try {
            $model = Deck::findModel($id);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model,]);
    }

    public function actionDelete($id)
    {
        try {
            if (Deck::findModel($id)->delete()) {
                return $this->redirect(['index']);
            }
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException('Failed to remove deck.');
        }
    }

    public function actionStudy($id)
    {
        try {
            $model = Card::findCard($id);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException('There are no cards in the deck or for today all words are learned.');
        }
        if (\Yii::$app->request->isAjax) {
            $model->setStudyTime(Card::nextDay());
            try {
                $model->save();
            } catch (\Exception $e) {
                throw new HttpException(500, $e->getMessage());
            }

            return $this->refresh();
        }

        return $this->render('study', ['model' => $model]);
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