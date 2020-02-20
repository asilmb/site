<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ImageUpload extends Model
{

    public $image;

    public function rules()
    {
        return [
            [['image'], 'file', 'extensions' => 'jpg,png,gif', 'maxSize' => 1024 * 1024],
        ];
    }

    public function uploadFile($file, $currentImage)
    {
        $this->image = $file;
        if ($this->validate()) {
            $this->deleteCurrentImage($currentImage);
            return $this->saveImage();
        }
    }

    private function getFolder()
    {
        return Yii::getAlias('@web') . 'uploads/';
    }

    private function generateFileName()
    {
        if (!empty($this->image)) {
            return strtolower(md5(uniqid($this->image->basename)) . '.' . $this->image->extension);
        }
    }

    public function deleteCurrentImage($currentImage)
    {
        if ($this->fileExist($currentImage)) {
            unlink($this->getFolder() . $currentImage);
        }
    }

    public function fileExist($currentImage)
    {
        if (!empty($currentImage)) {
            return file_exists($this->getFolder() . $currentImage);
        }
    }

    public function saveImage()
    {
        $filename = $this->generateFileName();
        if (!empty($this->image)) {
            $this->image->saveAs($this->getFolder() . $filename);
        }

        return $filename;
    }
}
