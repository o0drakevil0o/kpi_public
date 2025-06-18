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

    public function getKpKpi(){ 
        return $this->hasOne(KpKpi::class , ['kpi_id' => 'kpi_id']);
    }
    public function getKpBudyear() {
        return $this->hasOne(KpBudyear::class, ['BUDYEAR_ID' => 'budyear']);
    }
    public function getKpLevelKpi(){ 
        return $this->hasOne(KpLevelKpi::class , ['typelevel_id'=>'type_kpi']);
    }
    public function getKpPlan(){ 
        return $this->hasOne(KpPlanDuration::class , ['id' => 'plan']) ; 
    }
    public function getKpGoal(){ 
        return $this->hasOne(KpGoal::class , ['GOAL_ID' => 'goal'])   ; 
    }
    public function getKpGoal2(){ 
        return $this->hasOne(KpGoal::class , ['GOAL_ID' => 'goal2'])   ; 
    }
    public function getKpStratetgic(){ 
        return $this->hasOne(KpStratetgicOriginal::class , ['STRAT_ID' => 'strategic']);
    }
    public function getUserManager(){ 
        return $this->hasOne(User::class , ['id' => 'manager']);
    }
    public function getKpProject(){ 
        return $this->hasOne(KpProject::class , ['P_id' => 'project']) ;
    }
    public function getHrTeam(){ 
        return $this->hasOne(HrTeam::class , ['HR_TEAM_ID' => 'team']);
    }
}
