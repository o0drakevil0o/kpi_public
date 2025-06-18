<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_stratetgic_original".
 *
 * @property int $STRAT_ID
 * @property string|null $STRAT_NAME
 */
class KpStratetgicOriginal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_stratetgic_original';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
        ];
    }
}
