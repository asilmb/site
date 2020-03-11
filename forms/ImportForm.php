<?php


namespace app\forms;


use yii\base\Model;

class ImportForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'xls, xlsx'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Your file'
        ];
    }
}