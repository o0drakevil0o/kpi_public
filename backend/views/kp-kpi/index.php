<?php

use app\models\KpKpi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\KpChild ;

/** @var yii\web\View $this */
/** @var app\models\KpKpiSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'ตัวชี้วัดหลัก';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kp-kpi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel , 'dataBudYear' => $dataBudYear , 'dataKpiLevel' => $dataKpiLevel]); ?>   

    <p>
        <?= Html::a('Create Kp Kpi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'class' => 'table' ,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute'=>'ชื่อตัวชี้วัดหลัก',
                                "format" => "raw",
                                'value' => function($model) { 
                                        return  Html::a($model->name , ['kp-child/index' , 'kpi_id' => $model->kpi_id]) ;
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
                            'attribute'=>'ปีงบประมาณ',
                            "format" => "raw",
                            'value' => function($model) { 
                                    return $model->kpBudyear->BUDYEAR_NAME ;
                            } 
                            ],
                            [
                                'attribute'=>'ระดับตัวชี้วัด',
                                "format" => "raw",
                                'value' => function($model) { 
                                    return $model->kpLevelKpi->typelevel_name ;
                                } 
                            ],
                            [
                                'attribute'=>'แผนยุทธศาสตร์',
                                "format" => "raw",
                                'value' => function($model) { 
                                    return empty($model->kpPlan->plan_name)? ''  : $model->kpPlan->plan_name  ;
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
                                'class' => ActionColumn::className(),
                                'urlCreator' => function ($action, KpKpi $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'kpi_id' => $model->kpi_id]);
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
