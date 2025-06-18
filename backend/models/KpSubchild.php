<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_subchild".
 *
 * @property int $subchild_id ตัวชี้วัดย่อย
 * @property int $kpi_id ตัวชี้วัดหลัก
 * @property int $child_id ตักวชี้วัดรอง
 * @property string $name ชื่อตัวชี้วัด
 * @property int|null $strategic หมวดหมู่หลัก
 * @property int|null $issue ปัญหา
 * @property int|null $goal เป้าประสงค์
 * @property int|null $goal2 เป้าประสงค์ที่สอง
 * @property int|null $project โครงการที่แก้ไข้
 * @property int|null $team ทีมรับผิดชอบ
 * @property int|null $manager ผู้รับผิดชอบ
 * @property int|null $type_kpi ประเภทตัวชี้วัด
 * @property int $budyear ปีงบ
 * @property int|null $weight น้ำหนัก
 * @property int|null $plan แผนยุทธศาสตร์
 */
class KpSubchild extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_subchild';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kpi_id', 'child_id', 'name', 'budyear'], 'required'],
            [['kpi_id', 'child_id', 'strategic', 'issue', 'goal', 'goal2', 'project', 'team', 'manager', 'type_kpi', 'budyear', 'weight', 'plan'], 'integer'],
            [['name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'subchild_id' => 'Subchild ID',
            'kpi_id' => 'Kpi ID',
            'child_id' => 'Child ID',
            'name' => 'Name',
            'strategic' => 'Strategic',
            'issue' => 'Issue',
            'goal' => 'Goal',
            'goal2' => 'Goal2',
            'project' => 'Project',
            'team' => 'Team',
            'manager' => 'Manager',
            'type_kpi' => 'Type Kpi',
            'budyear' => 'Budyear',
            'weight' => 'Weight',
            'plan' => 'Plan',
        ];
    }

    public function getKpKpi(){ 
        return $this->hasOne(KpKpi::class , ['kpi_id' => 'kpi_id']); 
    }
    public function getKpChild(){ 
        return $this->hasOne(KpChild::class , ['child_id' => 'child_id']); 
    }
    public function getKpStrategic(){ 
        return $this->hasOne(KpStratetgicOriginal::class , ['STRAT_ID' => 'strategic']);
    }
    public function getKpGoal(){ 
        return $this->hasOne(KpGoal::class , ['GOAL_ID' => 'goal']);
    }
    public function getKpGoal2(){ 
        return $this->hasOne(KpGoal::class , ['GOAL_ID' => 'goal2']);
    }
    public function getKpProject(){ 
        return $this->hasOne(KpProject::class , ['P_id' => 'project']); 
    }
    public function getKpLevelKpi(){ 
        return $this->hasOne(KpLevelKpi::class ,['typelevel_id' => 'type_kpi']); 
    }
    public function getKpBudyear(){ 
        return $this->hasOne(KpBudyear::class , ['BUDYEAR_ID' => 'budyear']);
    }
    public function getKpPlan(){ 
        return $this->hasOne(KpPlanDuration::class , ['id' => 'plan']);
    }
    public function getUserManager(){ 
        return $this->hasOne(User::class , ['id' => 'manager']);
    }
    public function getHrTeam(){
        return $this->hasOne(HrTeam::class , ['HR_TEAM_ID' => 'team']);
    }
}
