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
            'name' => 'ชื่อตัวชี้วัด',
            'stratetgic' => 'ยุทธศาสตร์',
            'issues' => 'ปัญหา',
            'goal' => 'เป้าหมาย',
            'goal2' => 'เป้าหมายที่สอง',
            'project' => 'โครงการ',
            'team' => 'ทีมรับผิดชอบ',
            'manager' => 'ผู้รับผิดชอบ',
            'budyear' => 'ปีงบประมาณ',
            'type_kpi' => 'ระดับตัวชี้วัด',
            'level_kpi' => 'ระดับตัวชี้วัด',
            'weight' => 'น้ำหนักตัวชี้วัด',
            'plan' => 'แผนยุทธศาสตร์',
        ];
    }

    public function getKpBudyear() {
        return $this->hasOne(KpBudYear::class, ['BUDYEAR_ID' => 'budyear']);
    }
    public function getKpLevelKpi(){ 
        return $this->hasOne(KpLevelKpi::class , ['typelevel_id'=>'level_kpi']);
    }
    public function getKpPlan(){ 
        return $this->hasOne(KpPlanDuration::class , ['id' => 'plan']) ; 
    }
    public function getKpGoal(){ 
        return $this->hasOne(KpGoal::class , ['GOAL_ID' => 'goal'])   ; 
    }
    public function getKpStratetgic(){ 
        return $this->hasOne(KpStratetgicOriginal::class , ['STRAT_ID' => 'stratetgic']);
    }
    public function getKpProject(){ 
        return $this->hasOne(KpProject::class , ['P_id' => 'project']);
    }
    public function getUserManager(){ 
        return $this->hasOne(User::class , ['id' => 'manager']);
    }
    public function getHrTeam(){
        return $this->hasOne(HrTeam::class ,['HR_TEAM_ID' => 'team']);
    }

}
