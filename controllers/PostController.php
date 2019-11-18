<?php


namespace app\controllers;


class PostController extends AppController
{
//    public $layout = "basic";
    public function actionTest(){
        $names = ["Ivanov",'Petrov','Sidorov','Kuklov','Dronov'];
        if (\Yii::$app->request->isAjax){
            var_dump($_GET);
            return 'test';
        }
//        print_r($names);
//        var_dump($names);
//        $this->printArray($names);
        return  $this->render('test',compact("names"));
    }
    public function actionShow()
    {
        $this->layout = 'basic';
        return $this->render('show');
    }
}