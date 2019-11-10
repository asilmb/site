<?php


namespace app\controllers;

use yii\web\Controller;

class AppController extends Controller
{
    public function printArray($arr){
        echo '<pre>' . print_r($arr,true) . '</pre>';
    }
}
function printArray($arr){
    echo '<pre>' . print_r($arr,true) . '</pre>';
}