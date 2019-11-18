<?php


namespace app\controllers;


use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Mail extends ActiveRecord
{
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['hash' => $token]);
    }
}