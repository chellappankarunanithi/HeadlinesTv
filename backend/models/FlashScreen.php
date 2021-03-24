<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "flash_screen".
 *
 * @property integer $flash_id
 * @property string $flash_name
 * @property string $bg_screen
 * @property string $title_screen
 * @property string $created_at
 * @property string $updated_at
 */
class FlashScreen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flash_screen';
    }

    /**
     * @inheritdoc
     */
     public $file;
    public function rules()
    {
        return [
            
            [['created_at', 'updated_at','bg_screen','title_screen'], 'safe'],
            [['flash_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'flash_id' => 'Splash ID',
            'flash_name' => 'Splash Name',
            'bg_screen' => 'Background Screen',
            'title_screen' => 'Title Screen',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
