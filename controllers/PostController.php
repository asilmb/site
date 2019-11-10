<?php


namespace app\controllers;


class PostController extends AppController
{
    public function actionTest(){
        $names = ["Ivanov",'Petrov','Sidorov','Kuklov','Dronov'];
//        print_r($names);
//        var_dump($names);
//        $this->printArray($names);
        return  $this->render('test',compact("names"));
    }
}