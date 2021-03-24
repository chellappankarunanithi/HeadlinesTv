<?php

namespace common\models;

use Yii;
use yii\base\Model;
use  yii\web\Session;
/**
 * This is the model class for table "swim_service_centre".
 *
 * @property string $center_autoid
 * @property string $service_center_name
 * @property string $service_center_code
 * @property string $service_center_status
 * @property string $service_center_timestamp
 * @property string $service_center_createdat
 */
class SwimServiceCentre extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'swim_service_centre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_center_name', 'service_center_code'], 'required'],
            [['service_center_status'], 'string'],
            [['service_center_timestamp', 'service_center_createdat'], 'safe'],
            [['service_center_name', 'service_center_code'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'center_autoid' => 'Center Autoid',
            'service_center_name' => 'Name',
            'service_center_code' => 'Code',
            'service_center_status' => 'Status',
            'service_center_timestamp' => 'Service Center Timestamp',
            'service_center_createdat' => 'Service Center Createdat',
        ];
    }
}
