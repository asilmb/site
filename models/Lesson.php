<?php


namespace app\models;


use app\exceptions\LastCardException;
use yii\base\Model;

class Lesson
{
    public function transformDecK($cardList)
    {
        $newCardList = [];
        foreach ($cardList as $value) {
            $cardId = $value['id'];
            $newCardList[$cardId] = $value;
        }
        return $newCardList;
    }

    public function createLesson($cardList)
    {
        \Yii::$app->session->set('lesson', $this->transformDecK($cardList));
    }

    public static function beginLesson()
    {
        $cardList = \Yii::$app->session->get('lesson');
        return $cardList;
    }

    public static function getRandomCard($cardId, $cardList)
    {
        return self::getCard($cardList, $cardId);
    }

    public static function getCard($cardList, $cardId)
    {
        if ($cardList == null) {
            unset($_SESSION['lesson']);
            throw new LastCardException();
        }
        $card = $cardList[array_rand($cardList)];
        if (count($cardList) < 2) {

            return $card;
        }
        if ($card['id'] == $cardId) {
            return self::getCard($cardList, $cardId);
        }
        return $card;
    }

    public static function unsetCard($cardId)
    {
        unset($_SESSION['lesson'][$cardId]);
    }
}