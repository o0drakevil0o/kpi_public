<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_team_register".
 *
 * @property int $id
 * @property int|null $kpi_id ตัวชี้วัดหลัก
 * @property int|null $child_id ตัวชี้วัดรอง
 * @property int|null $subchild_id ตัวชี้วัดย่อย
 * @property int|null $team ประเภทการส่ง
 */
class KpTeamRegister extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_team_register';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kpi_id', 'child_id', 'subchild_id', 'team'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kpi_id' => 'Kpi ID',
            'child_id' => 'Child ID',
            'subchild_id' => 'Subchild ID',
            'team' => 'Team',
        ];
    }
}
