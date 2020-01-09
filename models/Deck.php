<?php


namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;

class Deck extends ActiveRecord
{

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
            'name' => 'Name',
        ];
    }
}