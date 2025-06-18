<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_child".
 *
 * @property int $child_id ตัวชี้วัดรอง
 * @property int $kpi_id ตัวชี้วัดหลัก
 * @property string $name ชื่อตัวชี้วัด
 * @property int|null $strategic หมวดหมู่ตัวชี้วัด
 * @property int|null $issue ปัญหา
 * @property int|null $goal เป้าประสงค์
 * @property int|null $goal2 เป้าประสงค์
 * @property int|null $project โครงการที่รองรับ
 * @property int|null $team ทีมรับผิดชอบ
 * @property int|null $manager ผู้รับผิดชอบ
 * @property int $budyear ปีงบ
 * @property int|null $weight น้ำหนัก
 * @property int|null $plan แผนยุทธศาสตร์
 */
class KpChild extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_child';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kpi_id', 'name', 'budyear'], 'required'],
            [['kpi_id', 'strategic', 'issue', 'goal', 'goal2', 'project', 'team', 'manager', 'budyear', 'weight', 'plan'], 'integer'],
            [['name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'child_id' => 'Child ID',
            'kpi_id' => 'Kpi ID',
            'name' => 'Name',
            'strategic' => 'Strategic',
            'issue' => 'Issue',
            'goal' => 'Goal',
            'goal2' => 'Goal2',
            'project' => 'Project',
            'team' => 'Team',
            'manager' => 'Manager',
            'budyear' => 'Budyear',
            'weight' => 'Weight',
            'plan' => 'Plan',
        ];
    }
}
