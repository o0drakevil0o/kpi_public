<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_plan_duration".
 *
 * @property int $id
 * @property string|null $plan_name ชื่อแผนยุทธศาสตร์ ระหว่างปี-ปี
 */
class KpPlanDuration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_plan_duration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['plan_name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plan_name' => 'Plan Name',
        ];
    }
}
