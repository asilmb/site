<?php


namespace app\models;

/**
 * This is the model class for table "deck".
 *
 * @property int $id
 * @property int $deck_id
 * @property string $front
 * @property string $back
 */

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

class Card extends ActiveRecord
{


    public function rules()
    {
        return [
            [['front', 'back', 'deck_id'], 'required', 'message' => 'Fill in the field'],
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

    public function showAnswer($id)
    {
        $model = Card::findModel($id);
        return $model->back;
    }

    public static function nextLearn($deck_id, $previous_id = null)
    {
        return Card::find()
            ->where(['deck_id' => $deck_id])
            ->orderBy(new Expression('random()'))
            ->one();
//            ->where(['<=',['learn_date', $date])

    }
}