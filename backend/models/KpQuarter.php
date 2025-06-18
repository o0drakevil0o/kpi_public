<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_quarter".
 *
 * @property int $QUARTER_ID
 * @property string|null $QUARTER_NAME
 */
class KpQuarter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_quarter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['QUARTER_ID'], 'required'],
            [['QUARTER_ID'], 'integer'],
            [['QUARTER_NAME'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'QUARTER_ID' => 'Quarter ID',
            'QUARTER_NAME' => 'Quarter Name',
        ];
    }
}
