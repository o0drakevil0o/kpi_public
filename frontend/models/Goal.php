<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goal".
 *
 * @property int $GOAL_ID
 * @property string|null $GOAL_NAME
 */
class Goal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['GOAL_NAME'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'GOAL_ID' => 'Goal ID',
            'GOAL_NAME' => 'Goal Name',
        ];
    }
}
