<?php


namespace app\controllers;


use Yii;
use app\models\Deck;
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

        $model = Deck::findAll(['id_user' => Yii::$app->user->id]);
        $decksNumber = Deck::find()->asArray()->where(['id_user' => Yii::$app->user->id])->count();
        return $this->render('index', ['model' => $model, 'decksNumber' => $decksNumber]);
    }

    public function actionCreate()
    {
        $model = new Deck();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->id_user = Yii::$app->user->id;
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionRename($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('rename', ['model' => $model,]);
    }

    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            return $this->redirect(['index']);
        }

        throw new NotFoundHttpException('Failed to remove deck.');
    }

    protected function findModel($id)
    {
        if (($model = Deck::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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