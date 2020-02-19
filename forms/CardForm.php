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


use DateTime;
use yii\base\Model;


class CardForm extends Model
{
    public $id;
    public $deck_id;
    public $front;
    public $back;
    public $study_time;
    public $image;

    public function rules()
    {
        return [
            [['front', 'back', 'deck_id',], 'required', 'message' => 'Fill in the field'],
            [['front', 'back'], 'string', 'max' => 50],
            ['study_time', 'date', 'format' => 'php:Y-m-d'],
            [['deck_id', 'back',], 'safe'],
            [['image'], 'file', 'extensions' => 'jpg,png','maxSize' => 1024*1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            'deck_id' => 'Deck Name',
            'front' => 'Front side of the card',
            'back' => 'Back side of the card',
            'image' => 'Card image'
        ];
    }



}