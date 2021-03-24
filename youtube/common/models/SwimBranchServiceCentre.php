<?php

namespace common\models;

use Yii;
use yii\base\Model;
use  yii\web\Session;

/**
 * This is the model class for table "swim_branch_service_centre".
 *
 * @property string $scb_id
 * @property string $service_center_id
 * @property string $branch_id
 * @property string $timestamp
 */
class SwimBranchServiceCentre extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'swim_branch_service_centre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_center_id', 'branch_id'], 'required'],
            [['timestamp'], 'safe'],
            [['service_center_id', 'branch_id'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'scb_id' => 'Scb ID',
            'service_center_id' => 'Service Center ID',
            'branch_id' => 'Branch ID',
            'timestamp' => 'Timestamp',
        ];
    }
}
