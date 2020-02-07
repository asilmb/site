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
    public function setStudyTime($studyTime)
    {
        $this->study_time = $studyTime;
    }

    public function rules()
    {
        return [
            [['front', 'back', 'deck_id',], 'required', 'message' => 'Fill in the field'],
            [['front', 'back'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'deck_id' => 'Deck Name',
            'front' => 'Front side of the card',
            'back' => 'Back side of the card',

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
            ->andWhere(['<=', 'study_time', $date])
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


}