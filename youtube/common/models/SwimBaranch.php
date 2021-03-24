<?php

namespace common\models;

use Yii;
use yii\base\Model;
use  yii\web\Session;

/**
 * This is the model class for table "swim_baranch".
 *
 * @property string $branch_autoid
 * @property string $branch_name
 * @property string $branch_code
 * @property string $branch_status
 * @property string $branch_timestamp
 * @property string $branch_createdat
 */
class SwimBaranch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $service_center_name;
    public static function tableName()
    {
        return 'swim_baranch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['branch_name', 'branch_code'], 'required'],
            [['branch_status'], 'string'],
            [['branch_timestamp', 'branch_createdat'], 'safe'],
            [['branch_name', 'branch_code'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'branch_autoid' => 'Branch Autoid',
            'service_center_name' => 'Service Centre',
            'branch_name' => 'Branch Name',
             
            'branch_code' => 'Branch Code',
            'branch_status' => 'Branch Status',
            'branch_timestamp' => 'Branch Timestamp',
            'branch_createdat' => 'Branch Createdat',
        ];
    }
}
