<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kt_year".
 *
 * @property int $id
 * @property string|null $year
 * @property string|null $duration_start
 * @property string|null $duration_end
 */
class KtYear extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kt_year';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year'], 'string', 'max' => 255],
            [['duration_start', 'duration_end'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => 'Year',
            'duration_start' => 'ระยะเวลาเริ่มต้น' , 
            'duration_end' => 'ระยะเวลาสิ้นสุด' , 
        ];
    }
}
