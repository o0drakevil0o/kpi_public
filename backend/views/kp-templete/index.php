<?php

use app\models\KpTemplete;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\KpTempleteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kp Templetes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kp-templete-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if(empty($dataProvider->getModels())){ 
            $kpi_id = empty(Yii::$app->request->get('kpi_id')) ? 0 : Yii::$app->request->get('kpi_id') ;
            $child_id = empty(Yii::$app->request->get('child_id')) ? 0 : Yii::$app->request->get('child_id') ;
            $sub_id = empty(Yii::$app->request->get('sub_id')) ? 0 : Yii::$app->request->get('sub_id') ;
            echo Html::a('Create Kp Templete', ['create' ,
                'kpi_id' => $kpi_id , 
                'child_id' => $child_id,
                'sub_id' => $sub_id
            ], ['class' => 'btn btn-success']) ;
        }
        ?> 
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'ชื่อตัวชี้วัดหลัก',
                "format" => "raw",
                'value' => function($model) { 
                        return  empty($model->kpKpi) ? '' : $model->kpKpi->name ;
                } 
            ],
            [
                'attribute'=>'ชื่อตัวชี้วัดรอง',
                "format" => "raw",
                'value' => function($model) { 
                        return  empty($model->kpChild) ? '' : $model->kpChild->name ;
                } 
            ],
            [
                'attribute'=>'ชื่อตัวชี้วัดย่อย',
                "format" => "raw",
                'value' => function($model) { 
                        return  empty($model->kpSub) ? '' : $model->kpSub->name ;
                } 
            ],
            [
                'attribute'=>'ตัวชีัวัด',
                "format" => "raw",
                'value' => function($model) { 
                        return  $model->tem_kpiname ;
                } 
            ],
            [
                'attribute'=>'ประเภทการส่ง',
                "format" => "raw",
                'value' => function($model) { 
                        return  empty($model->sendType) ? '' : $model->sendType->name ;
                } 
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, KpTemplete $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
