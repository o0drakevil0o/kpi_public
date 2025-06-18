<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kt_submain".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $owner
 * @property int $kt_mian_id
 * @property int|null $year
 * @property int|null $traget
 *
 * @property KtMain $ktMian
 * @property KtResulte[] $ktResultes
 */
class KtSubmain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kt_submain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['owner', 'kt_mian_id', 'year', 'traget'], 'integer'],
            [['kt_mian_id'], 'required'],
            [['kt_mian_id'], 'exist', 'skipOnError' => true, 'targetClass' => KtMain::class, 'targetAttribute' => ['kt_mian_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'owner' => 'Owner',
            'kt_mian_id' => 'Kt Mian ID',
            'year' => 'Year',
            'traget' => 'Traget',
        ];
    }

    /**
     * Gets query for [[KtMian]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKtMian()
    {
        return $this->hasOne(KtMain::class, ['id' => 'kt_mian_id']);
    }

    /**
     * Gets query for [[KtResultes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKtResultes()
    {
        return $this->hasMany(KtResulte::class, ['submain_id' => 'id']);
    }
}
