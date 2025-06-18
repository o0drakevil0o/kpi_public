<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_success".
 *
 * @property int $s_id
 * @property string|null $s_name
 */
class KpSuccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_success';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['s_id'], 'required'],
            [['s_id'], 'integer'],
            [['s_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            's_id' => 'S ID',
            's_name' => 'S Name',
        ];
    }
}
