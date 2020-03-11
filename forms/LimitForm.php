<?php


namespace app\forms;


use yii\base\Model;

class limitForm extends Model
{
    public $limit;

    public function rules()
    {
        return [
            [['limit'], 'required',],
            [['limit'], 'integer',]
        ];
    }


}