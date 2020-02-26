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

    public static function tableName()
    {
        return '{{deck}}';
    }

    public function rules()
    {
        return [
            [['id', 'name', 'user_id'], 'safe'],
        ];
    }

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

    public function setDeckName($deckName){
        $this->name = $deckName;
    }

    public function getDeckName(){
        return $this->name;
    }


    public static function findModel($id)
    {
        if (($model = Deck::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException();
    }
}