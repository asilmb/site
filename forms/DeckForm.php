<?php


namespace app\forms;

/**
 * Class DeckForm
 *
 * This is the form class "deck".
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 */

use app\models\Deck;
use yii\base\Model;

class DeckForm extends Model
{
    public $id;
    public $name;
    public $user_id;


    public function rules()
    {
        return [
            ['name', 'unique', 'targetClass' => Deck::className(), 'message' => 'This name is already in use.'],
            [['name',], 'required', 'message' => 'Fill in the field'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Deck name',
        ];
    }

}