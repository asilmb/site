<?php


namespace app\controllers;

//namespace moonland\PHPExcel;
use app\exceptions\LastCardException;
use app\forms\CardForm;
use app\forms\DeckForm;
use app\forms\ImportForm;
use app\forms\limitForm;
use app\models\Card;
use app\models\Import;
use app\models\Lesson;
use app\models\Upload;
use app\widgets\Alert;
use Yii;
use app\models\Deck;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Expression;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use PHPExcel;
use PHPExcel\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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
        $limitForm = new LimitForm();
        $cardList = Card::findCard($deckId, $limitForm->limit = 20);
        if(count($cardList)==0){
           Card::updateAll(['hidden' => false],['=', 'deck_id', $deckId]);
        }
        (new \app\models\Lesson)->createLesson($cardList);
        if (Yii::$app->request->isAjax) {
            $limitForm->load(Yii::$app->request->post(), '');

            if ($limitForm->validate()) {

                $cardList = Card::findCard($deckId, $limitForm->limit);
                (new \app\models\Lesson)->createLesson($cardList);
                $dataProvider = new ArrayDataProvider(['allModels' => $cardList, 'pagination' => false]);
                return $this->renderPartial('/card/_cardList', [
                    'model' => Deck::findModel($deckId),
                    'dataProvider' => $dataProvider,
                    'isEmpty' => $dataProvider->getCount() > 0 ? false : true,

                ]);
            }


        }
        $dataProvider = new ActiveDataProvider([
            'query' => Card::find()->where(['deck_id' => $deckId]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        if ($limitForm->hasErrors()) {
            Yii::$app->session->setFlash('error', 'Limit null');
            return $this->redirect(['view', 'deckId' => $deckId]);
        }

        return $this->render('view', [
            'model' => Deck::findModel($deckId),
            'dataProvider' => $dataProvider,
            'isEmpty' => $dataProvider->getCount() > 0 ? false : true,

        ]);

    }

    public function newDataProvider($deckId, $limit)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Card::find()
                ->where(['deck_id' => $deckId])
                ->limit($limit),
        ]);
        return $dataProvider;
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
        $cardList = Lesson::beginLesson();
        if (\Yii::$app->request->isAjax) {
            $cardModel = Card::findModel($card_id);
            $cardModel->updateCounters(['view_count' => 1]);
            if ($success) {
                $cardModel->setHiddenTrue();
                $cardModel->updateCounters(['success_count' => 1]);
                unset($cardList[$card_id]);
                Lesson::unsetCard($card_id);
            }
            try {
                $cardModel->update();
            } catch (\Exception $e) {
                throw new HttpException(500, $e->getMessage());
            }

            try {
                return $this->renderPartial('study', ['model' => Lesson::getRandomCard($card_id, $cardList)]);
            } catch (NotFoundHttpException $e) {
                Yii::$app->session->setFlash('success', 'Today all the words are learned.');
                throw new NotFoundHttpException('There are no cards in the deck.');
            }
        }

        try {
            return $this->render('study', ['model' => Lesson::getRandomCard($card_id, $cardList)]);
        } catch (LastCardException $e) {
            Yii::$app->session->setFlash('success', 'Today all the words are learned.');
            return $this->redirect('/deck');
        } catch (NotFoundHttpException $e) {
            Yii::$app->session->setFlash('Error', 'No cards into deck');
            return $this->redirect('/deck');
        }
    }

    public function actionImport($deckId)
    {

        $importForm = new ImportForm();
        if ($importForm->load(Yii::$app->request->post()) && $importForm->validate()) {
            $file = UploadedFile::getInstance($importForm, 'file');
            $importModel = new Import(\Yii::$app->request->getBodyParam('importForm'));
            $fileName = $importModel->getFolder() . $importModel->save($file);
            $data = \moonland\phpexcel\Excel::import($fileName);
            foreach ($data as $value) {
                $cardForm = new CardForm();
                $cardForm->deck_id = $deckId;
                if (!array_key_exists('front', $value) || !array_key_exists('back', $value)) {
                    $importModel->deleteFile($fileName);
                    Yii::$app->session->setFlash('error', 'Data is not correct');
                    return $this->redirect(['deck/import', 'deckId' => $deckId]);
                }
                $cardForm->front = $value['front'];
                $cardForm->back = $value['back'];

                if ($cardForm->validate()) {
                    $cardModel = new Card($cardForm->getAttributes(['deck_id', 'front', 'back']));
                    $cardModel->save();
                }
            }
            Yii::$app->session->setFlash('success', 'File successfully import');
            $importModel->deleteFile($fileName);
            return $this->redirect(['view', 'deckId' => $deckId]);

        }
        return $this->render('import', ['model' => $importForm]);
    }
}