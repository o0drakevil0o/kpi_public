<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_team".
 *
 * @property int $T_id
 * @property string $T_name
 */
class KpTeam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['T_id', 'T_name'], 'required'],
            [['T_id'], 'integer'],
            [['T_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'T_id' => 'T ID',
            'T_name' => 'T Name',
        ];
    }
}
