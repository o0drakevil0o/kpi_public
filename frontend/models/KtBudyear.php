<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kt_budyear".
 *
 * @property int $id
 * @property string|null $bud_year
 * @property string|null $duration_start
 * @property string|null $duration_end
 *
 * @property KtResulte[] $ktResultes
 */
class KtBudyear extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kt_budyear';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['duration_start', 'duration_end'], 'safe'],
            [['bud_year'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bud_year' => 'Bud Year',
            'duration_start' => 'Duration Start',
            'duration_end' => 'Duration End',
        ];
    }

    /**
     * Gets query for [[KtResultes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKtResultes()
    {
        return $this->hasMany(KtResulte::class, ['budyear_id' => 'id']);
    }
}
