<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_budyear".
 *
 * @property int $BUDYEAR_ID
 * @property string|null $BUDYEAR_NAME
 * @property string|null $BUDYEAR_DATE_START
 * @property string|null $BUDYEAR_DATE_END
 */
class KpBudyear extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_budyear';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BUDYEAR_ID'], 'required'],
            [['BUDYEAR_ID'], 'integer'],
            [['BUDYEAR_DATE_START', 'BUDYEAR_DATE_END'], 'safe'],
            [['BUDYEAR_NAME'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'BUDYEAR_ID' => 'Budyear ID',
            'BUDYEAR_NAME' => 'Budyear Name',
            'BUDYEAR_DATE_START' => 'Budyear Date Start',
            'BUDYEAR_DATE_END' => 'Budyear Date End',
        ];
    }
}
