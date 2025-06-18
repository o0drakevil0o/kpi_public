<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_project".
 *
 * @property int $P_id
 * @property string $P_name
 */
class KpProject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['P_name'], 'required'],
            [['P_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'P_id' => 'P ID',
            'P_name' => 'P Name',
        ];
    }
}
