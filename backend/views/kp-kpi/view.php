<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\KpKpi $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kp Kpis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kp-kpi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a("Templete" , ['kp-templete/index' , 'kpi_id' => $model->kpi_id] ,['class' => 'btn btn-success']) ?>
        <?= Html::a('Update', ['update', 'kpi_id' => $model->kpi_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'kpi_id' => $model->kpi_id], [
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
                'attribute'=>'ชื่อตัวชี้วัดหลัก',
                "format" => "raw",
                'value' => function($model) { 
                    return  $model->name ;
                } 
            ],
            [
                'attribute'=>'ยุทธศาสตร์',
                "format" => "raw",
                'value' => function($model) { 
                    return empty($model->kpStratetgic->STRAT_NAME)? ''  : $model->kpStratetgic->STRAT_NAME  ;
                } 
            ],
            [
                'attribute'=>'เป้าหมาย',
                "format" => "raw",
                'value' => function($model) { 
                    return empty($model->kpGoal->GOAL_NAME )? '': $model->kpGoal->GOAL_NAME  ;
                    
                } 
            ],
            [
                'attribute'=>'โครงการ',
                "format" => "raw",
                'value' => function($model) { 
                    return empty($model->kpProject )? '': $model->kpProject->P_name  ;
                    
                } 
            ],
            [
                'attribute'=>'ทีมรับผิดชอบหลัก',
                "format" => "raw",
                'value' => function($model) { 
                    return empty($model->hrTeam )? '': $model->hrTeam->HR_TEAM_NAME  ;
                    
                } 
            ],
            [
                'attribute'=>'ผู้รับผิดชอบ',
                "format" => "raw",
                'value' => function($model) { 
                    return empty($model->userManager->id)? ''  : $model->userManager->fname . ' ' . $model->userManager->lname  ;
                } 
            ],
            [
                'attribute'=>'ปีงบประมาณ',
                "format" => "raw",
                'value' => function($model) { 
                        return empty($model->kpBudyear->BUDYEAR_NAME) ? '' : $model->kpBudyear->BUDYEAR_NAME ;
                } 
            ],
            [
                'attribute'=>'ระดับตัวชี้วัด',
                "format" => "raw",
                'value' => function($model) { 
                        return empty($model->kpLevelKpi) ? '' : $model->kpLevelKpi->typelevel_name ;
                } 
            ],
            [
                'attribute'=>'แผนยุทธศาสตร์',
                "format" => "raw",
                'value' => function($model) { 
                        return empty($model->kpPlan) ? '' : $model->kpPlan->plan_name ;
                } 
            ],
        ],
    ]) ?>

</div>
