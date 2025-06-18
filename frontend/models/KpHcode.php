<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_hcode".
 *
 * @property int $id
 * @property string|null $hcode
 * @property string|null $hname
 */
class KpHcode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_hcode';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['hcode', 'hname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hcode' => 'Hcode',
            'hname' => 'Hname',
        ];
    }
}
