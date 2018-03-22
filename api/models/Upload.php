<?php

namespace api\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class Upload extends Model
{

    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
        ];
    }
}
