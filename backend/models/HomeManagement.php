<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "home_management".
 *
 * @property integer $home_id
 * @property string $youtubelink
 * @property string $youtube_id
 */
class HomeManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'home_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['youtubelink', 'youtube_id'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'home_id' => 'Home ID',
            'youtubelink' => 'Youtubelink',
            'youtube_id' => 'Youtube ID',
        ];
    }
}
