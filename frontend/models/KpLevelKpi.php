<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_level_kpi".
 *
 * @property int $typelevel_id
 * @property string $typelevel_name
 */
class KpLevelKpi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_level_kpi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['typelevel_id', 'typelevel_name'], 'required'],
            [['typelevel_id'], 'integer'],
            [['typelevel_name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'typelevel_id' => 'Typelevel ID',
            'typelevel_name' => 'Typelevel Name',
        ];
    }
}
