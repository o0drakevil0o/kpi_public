<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\KpSubchild $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kp Subchildren', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kp-subchild-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
       <?= Html::a('Templete', ['kp-templete/index', 'kpi_id' => $model->kpi_id , 'child_id' => $model->child_id , 'sub_id' => $model->subchild_id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update', ['update', 'subchild_id' => $model->subchild_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'subchild_id' => $model->subchild_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'ตัวชี้วัดหลัก',
                "format" => "raw",
                'value' => function($model) { 
                    return  $model->kpKpi->name ;
                } 
            ],
            [
                'attribute'=>'ตัวชี้วัดรอง',
                "format" => "raw",
                'value' => function($model) { 
                    return  $model->kpChild->name ;
                } 
            ],
            [
                'attribute'=>'ตัวชี้วัดย่อย',
                "format" => "raw",
                'value' => function($model) { 
                    return  $model->name ;
                } 
            ],
            [
                'attribute'=>'ยุทธศาสตร์',
                "format" => "raw",
                'value' => function($model) { 
                    return  empty($model->kpStratetgic) ? '' : $model->kpStratetgic->STRAT_NAME ;
                } 
            ],
            [
                'attribute'=>'ปัญหา',
                "format" => "raw",
                'value' => function($model) { 
                    return  empty($model->issue)?'':$model->issue ;
                } 
            ],
            [
                'attribute'=>'เป้าหมาย',
                "format" => "raw",
                'value' => function($model) { 
                    return  empty($model->kpGoal) ? '' :$model->kpGoal->GOAL_NAME ;
                } 
            ],
            [
                'attribute'=>'เป้าหมายสอง',
                "format" => "raw",
                'value' => function($model) { 
                    return  empty($model->kpGoal2) ? '' :$model->kpGoal2->GOAL_NAME ;
                } 
            ],
            [
                'attribute'=>'โครงการ',
                "format" => "raw",
                'value' => function($model) { 
                    return  empty($model->kpProject) ? '' : $model->kpProject->P_name ;
                } 
            ],
            [
                'attribute'=>'ทีมรับผิดชอบ',
                "format" => "raw",
                'value' => function($model) { 
                    return  empty($model->hrTeam) ? '' : $model->hrTeam->HR_TEAM_NAME ;
                } 
            ],
            [
                'attribute'=>'ผู้รับผิดชอบ',
                "format" => "raw",
                'value' => function($model) { 
                    return  empty($model->userManager) ? '' : $model->userManager->fname .' '.$model->userManager->lname ;
                } 
            ],
            [
                'attribute'=>'ระดับตัวชี้วัด',
                "format" => "raw",
                'value' => function($model) { 
                    return  empty($model->kpLevelKpi) ? '' : $model->kpLevelKpi->typelevel_name ;
                } 
            ],
            [
                'attribute'=>'ปีงบประมาณ',
                "format" => "raw",
                'value' => function($model) { 
                    return  $model->kpBudyear->BUDYEAR_NAME ;
                } 
            ],
            [
                'attribute'=>'ค่าน้ำหนักตัวชี้วัด',
                "format" => "raw",
                'value' => function($model) { 
                    return  empty($model->weight)?'':$model->weight ;
                } 
            ],
            [
                'attribute'=>'แผนยุทธศาสตร์',
                "format" => "raw",
                'value' => function($model) { 
                    return  empty($model->kpPlan) ? '' : $model->kpPlan->plan_name ;
                } 
            ],
        ],
    ]) ?>

</div>
