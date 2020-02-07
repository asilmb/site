<?php


namespace app\forms;

/**
 * Class CardForm
 *
 * This is the form class "deck".
 *
 * @property int $id
 * @property int $deck_id
 * @property string $front
 * @property string $back
 * @property dateTime $study_time
 */

use DateInterval;
use DateTime;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

class CardForm extends Model
{
    public $id;
    public $deck_id;
    public $front;
    public $back;
    public $study_time;

    public function rules()
    {
        return [
            [['front', 'back', 'deck_id',], 'required', 'message' => 'Fill in the field'],
            [['front', 'back'], 'string', 'max' => 50],
            [['deck_id', 'back'], 'safe'],
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



}