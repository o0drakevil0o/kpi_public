<?php

namespace app\models;

use Yii;
/**
 * This is the model class for table "kt_main".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $owner
 * @property int|null $year
 * @property int|null $traget
 *
 * @property KtResulte[] $ktResultes
 * @property KtSubmain[] $ktSubmains
 */
class KtMain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file  ; 

    public static function tableName()
    {
        return 'kt_main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['owner', 'year', 'traget'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ลำดับ',
            'name' => 'ชื่อกองทุน',
            'owner' => 'ผู้รับผิดชอบ',
            'year' => 'ปีงบประมาณ',
            'traget' => 'ผู้รับผิดชอบ',
        ];
    }

    /**
     * Gets query for [[KtResultes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKtResultes()
    {
        return $this->hasMany(KtResulte::class, ['main_id' => 'id']);
    }

    /**
     * Gets query for [[KtSubmains]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKtSubmains()
    {
        return $this->hasMany(KtSubmain::class, ['kt_mian_id' => 'id']);
    }

   
}
