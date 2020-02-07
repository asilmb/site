<?php


namespace app\models;

/**
 * This is the model class for table "deck".
 *
 * @property int $id
 * @property int $deck_id
 * @property string $front
 * @property string $back
 * @property dateTime $study_time
 */

use DateInterval;
use DateTime;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

class Card extends ActiveRecord
{
    private $id;
    private $deck_id;
    private $front;
    private $back;
    public $study_time;


    public function setStudyTime($studyTime)
    {
        $this->study_time = $studyTime;
    }
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['front', 'back', 'deck_id', 'study_time'], 'safe'],
        ];
    }

    public static function findListCard($deck_id)
    {
        if (($model = Card::findAll(['deck_id' => $deck_id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException();
    }

    public static function findModel($id)
    {
        if (($model = Card::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException();
    }

    public static function findCard($deck_id)
    {
        $date = new DateTime();
        $date = $date->format('Y-m-d');
        $card = Card::find()
            ->where(['deck_id' => $deck_id])
            ->orWhere(['<=', 'study_time', $date])
            ->orWhere(['=', 'study_time', null])
            ->orderBy(new Expression('random()'))
            ->one();
        if (!$card) {
            throw new NotFoundHttpException('There are no cards in the deck or for today all words are learned.');
        }
        return $card;
    }

    public static function nextDay()
    {
        $date = new DateTime();
        $date->add(new DateInterval('P1D'));
        $date = $date->format('Y-m-d');
        return $date;
    }

    public function setDeckId($deck_id)
    {
        $this->deck_id = $deck_id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFront()
    {
        return $this->front;
    }

    /**
     * @param mixed $front
     */
    public function setFront($front)
    {
        $this->front = $front;
    }

    /**
     * @return mixed
     */
    public function getBack()
    {
        return $this->back;
    }

    /**
     * @param mixed $back
     */
    public function setBack($back)
    {
        $this->back = $back;
    }

    /**
     * @return mixed
     */
    public function getDeckId()
    {
        return $this->deck_id;
    }

    /**
     * @return mixed
     */
    public function getStudyTime()
    {
        return $this->study_time;
    }


}