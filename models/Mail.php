<?php


namespace app\models;


use yii\db\ActiveRecord;


class Mail extends ActiveRecord
{
    public static function primaryKey()
    {
        return ['mail'];
    }

}