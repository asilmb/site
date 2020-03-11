<?php


namespace app\models;
use Yii;

use yii\base\Model;

class Import extends Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'], 'safe'],
        ];
    }

    private function generateFileName()
    {
        if (!empty($this->file)) {
            return strtolower(md5(uniqid($this->file->basename)) . '.' . $this->file->extension);
        }
    }
    public function getFolder()
    {
        return Yii::getAlias('@web') . 'uploads/decks/';
    }

    public function save($file)
    {
        $this->file = $file;
        $filename = $this->generateFileName();
        if (!empty($this->file)) {
            $this->file->saveAs($this->getFolder() . $filename);
        }

        return $filename;
    }
    public function deleteFile($filename)
    {
        if ($this->fileExist($filename)) {
            unlink($filename);
        }
    }

    public function fileExist($filename)
    {
        if (!empty($filename)) {
            return file_exists($filename);
        }
    }

}