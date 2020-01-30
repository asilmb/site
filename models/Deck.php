<?php


namespace app\models;

/**
 * This is the model class for table "deck".
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 */

use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;


class Deck extends ActiveRecord
{

    public function setUserId($id)
    {
        $this->user_id = $id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getId()
    {
        return $this->id;
    }

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

    public static function findModel($id)
    {
        if (($model = Deck::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException();
    }


}