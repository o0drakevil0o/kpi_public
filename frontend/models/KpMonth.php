<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_month".
 *
 * @property int $id
 * @property string $month_id
 * @property string $month_name
 */
class KpMonth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_month';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'month_id', 'month_name'], 'required'],
            [['id'], 'integer'],
            [['month_id'], 'string', 'max' => 2],
            [['month_name'], 'string', 'max' => 254],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month_id' => 'Month ID',
            'month_name' => 'Month Name',
        ];
    }
}
