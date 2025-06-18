<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_kpi".
 *
 * @property int $kpi_id
 * @property string $name
 * @property int|null $stratetgic หมวดหมู่
 * @property int|null $issues ปํญหา
 * @property int|null $goal เป้าหมาย 
 * @property int|null $goal2 เป้าหมาย
 * @property int|null $project โครงการ
 * @property int|null $team ทีมรับผิดชอบ
 * @property int|null $manager ผู้รับผิดชอบ
 * @property int $budyear ปีงบ
 * @property int|null $type_kpi ประเภทตัวชี้วัด
 * @property int|null $level_kpi ระดับตัวชี้ด
 * @property int|null $weight น้ำหนัก
 * @property int|null $plan แผนยุทธศาสตร์
 */
class KpKpi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_kpi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'budyear'], 'required'],
            [['stratetgic', 'issues', 'goal', 'goal2', 'project', 'team', 'manager', 'budyear', 'type_kpi', 'level_kpi', 'weight', 'plan'], 'integer'],
            [['name'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kpi_id' => 'Kpi ID',
            'name' => 'Name',
            'stratetgic' => 'Stratetgic',
            'issues' => 'Issues',
            'goal' => 'Goal',
            'goal2' => 'Goal2',
            'project' => 'Project',
            'team' => 'Team',
            'manager' => 'Manager',
            'budyear' => 'Budyear',
            'type_kpi' => 'Type Kpi',
            'level_kpi' => 'Level Kpi',
            'weight' => 'Weight',
            'plan' => 'Plan',
        ];
    }
}
