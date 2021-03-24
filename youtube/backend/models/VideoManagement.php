<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "video_management".
 *
 * @property integer $video_id
 * @property string $youtube_url
 * @property string $you_desc
 * @property integer $auto_id
 * @property integer $active_status
 */
class VideoManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $file;
    public $category_name;
    public static function tableName()
    {
        return 'video_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['youtube_url', 'auto_id','youtube_id','active_status','video_name'], 'required'],
            [['auto_id', 'active_status'], 'integer'],
            [[ 'video_name','video_type'], 'safe'],
             [['video_image'], 'string', 'max' => 255],
            [['youtube_url', 'you_desc'], 'string', 'max' => 255],
             [['video_image'], 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'video_name'=>'Video Name',
            'video_id' =>'Video ID',
            'youtube_url'=>'Youtube Link',
            'you_desc' =>'Description',
            'auto_id' => 'Category',
            'video_type'=>'Favourite',


           // 'active_status' => 'Active Status',
        ];
    }

 public function afterFind() {
    if(isset($this->lead)){
        $this->category_name = $this->lead->category_name; 
}else{

     $this->category_name="-";
}
        $this->video_name =stripslashes($this->video_name); 
        parent::afterFind();
    }

    public function getLead()
    {
        //TansiLeadManagement
        return $this->hasOne(CategoryManagement::className(), ['auto_id' =>'auto_id']);
    }
    
}
