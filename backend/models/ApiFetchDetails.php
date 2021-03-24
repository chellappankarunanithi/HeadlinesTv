<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "api_fetch_details".
 *
 * @property integer $id
 * @property string $category_id
 * @property string $json_data
 * @property string $created_at
 * @property string $updated_at
 */
class ApiFetchDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api_fetch_details';
    }

    /**
     * @inheritdoc
     */
     public $category_name;
    public function rules()
    {
        return [
        [['category_id'], 'required'],
            [['created_at', 'updated_at','json_data'], 'safe'],
            [['category_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */

     public function afterFind() {
    if(isset($this->lead)){
        $this->category_name = $this->lead->category_name; 
}else{

     $this->category_name="-";
}
        
        parent::afterFind();
    }

    public function getLead()
    {
        //TansiLeadManagement
        return $this->hasOne(CategoryManagement::className(), ['auto_id' =>'category_id']);
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'json_data' => 'Json Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
