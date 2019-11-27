<?php


namespace app\controllers;


use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Mail extends ActiveRecord
{
    public static function findIdentityByAccessToken($token)
    {
        return static::findOne(['hash' => $token]);
    }
    public static function primaryKey()
    {
        return ['mail'];
    }
}