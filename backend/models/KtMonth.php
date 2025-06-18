<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kt_month".
 *
 * @property int $id
 * @property string|null $month_name
 * @property int|null $quater
 *
 * @property KtResulte[] $ktResultes
 */
class KtMonth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kt_month';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'quater'], 'integer'],
            [['month_name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ลำดับ',
            'month_name' => 'เดือน',
            'quater' => 'ไตรมาส',
        ];
    }

    /**
     * Gets query for [[KtResultes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKtResultes()
    {
        return $this->hasMany(KtResulte::class, ['month_id' => 'id']);
    }
}
