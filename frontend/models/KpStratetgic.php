<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_stratetgic".
 *
 * @property int $STRAT_ID
 * @property string|null $STRAT_NAME
 * @property int $type_kpi
 */
class KpStratetgic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_stratetgic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['STRAT_ID', 'type_kpi'], 'required'],
            [['STRAT_ID', 'type_kpi'], 'integer'],
            [['STRAT_NAME'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'STRAT_ID' => 'Strat ID',
            'STRAT_NAME' => 'Strat Name',
            'type_kpi' => 'Type Kpi',
        ];
    }
}
