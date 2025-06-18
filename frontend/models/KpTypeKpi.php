<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_type_kpi".
 *
 * @property int $type_id
 * @property string $type_name
 */
class KpTypeKpi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_type_kpi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'type_name'], 'required'],
            [['type_id'], 'integer'],
            [['type_name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'type_id' => 'Type ID',
            'type_name' => 'Type Name',
        ];
    }
}
