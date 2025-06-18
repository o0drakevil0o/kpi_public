<?php
use app\models\KpChild;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\KpSubchild ;

/** @var yii\web\View $this */
/** @var app\models\KpChildSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'ตัวชี้วัดรอง';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kp-child-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Kp Child', ['create' , 'kpi_id' => empty(Yii::$app->request->get())? 0 : Yii::$app->request->get('kpi_id') ], ['class' => 'btn btn-success']) ?>
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
                                    return  $model->kpKpi->name ;
                                } 
                            ],
                            [
                                'attribute'=>'ชื่อตัวชี้วัดรอง',
                                "format" => "raw",
                                'value' => function($model) { 
                                        return  Html::a($model->name , ['kp-subchild/index' , 'kpi_id' => $model->kpi_id , 'child_id' => $model->child_id]) ;
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
                                    return empty($model->kpBudyear->BUDYEAR_NAME) ? '' : $model->kpBudyear->BUDYEAR_NAME ;
                            } 
                            ],
                            [
                                'attribute'=>'ระดับตัวชี้วัด',
                                "format" => "raw",
                                'value' => function($model) { 
                                    return empty($model->kpLevelKpi->typelevel_name) ? '' : $model->kpLevelKpi->typelevel_name ;
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
                                'urlCreator' => function ($action, KpChild $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'child_id' => $model->child_id]);
                                 }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>





</div>
