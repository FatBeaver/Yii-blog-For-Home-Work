<?php 

namespace app\models\objects;

use Yii;
use yii\base\Model;

class ImageUpload extends Model {

    public $image;
    
    public function rules() {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg,png', 'checkExtensionByMimeType' => false],
        ];
    }

    public function uploadFile($file, $currentImage) {

        $this->image = $file;

        if ($this->validate()) {
            
            $this->deleteCurrentImage($currentImage);

            $filename = $file->basename . time() . '.' . $file->extension;
            $file->saveAs(Yii::getAlias('@webroot/') . 'uploads/' . $filename);

            return $filename;
        }
    }

    public function deleteCurrentImage($currentImage) {
        if (file_exists(Yii::getAlias('@webroot/') . 'uploads/' . $currentImage)) {
            @unlink(Yii::getAlias('@webroot/') . 'uploads/' . $currentImage);
        }
    }
}