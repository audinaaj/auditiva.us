<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class DataUploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $dataFile;
    //public $customer_id;

    public function rules()
    {
        return [
            //[['customer_id'], 'integer'],
            //[['customer_id'], 'safe'],
            [['dataFile'], 'file', 
                'skipOnEmpty' => false, 
                'extensions' => 'txt', 
                'wrongExtension' => '{attribute} = [{file}].  Only files with these extensions are allowed: {extensions}.'
            ],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->dataFile->saveAs('uploads/' . strtolower($this->dataFile->baseName) . '.' . strtolower ($this->dataFile->extension) );  // save to [app]/web/uploads
            return true;
        } else {
            return false;
        }
    }
}
?>