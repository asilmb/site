<?php


namespace app\forms;

/**
 * Class UploadForm
 *
 * This is the form class "card".
 *
 * @property string $image
 */

use yii\base\Model;

class UploadForm extends Model
{

    public $image;

    public function rules()
    {
        return [
            [['image'], 'file', 'extensions' => 'jpg,png','maxSize' => 1024*1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            'image' => 'Card image'
        ];
    }


}