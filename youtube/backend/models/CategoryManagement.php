<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "category_management".
 *
 * @property integer $auto_id
 * @property string $category_name
 * @property string $category_desc
 * @property integer $category_image
 */
class CategoryManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $file;
    public static function tableName()
    {
        return 'category_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'category_desc','active_status','home_status'], 'required'],
            [['category_desc','slug'], 'string'],
            [['category_image'], 'string', 'max' => 255],
            
            [['category_image'], 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'category_name' => 'Category Name',
            'slug' => 'slug',
            'category_desc' => 'Category Desc',
            'category_image' => 'Category Image',
        ];
    }
}
