<?php

use app\models\KpSubchild;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\KpSubchildSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kp Subchildren';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kp-subchild-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Kp Subchild', ['create' 
        , 'kpi_id' => empty(Yii::$app->request->get('kpi_id')) ? 0 : Yii::$app->request->get('kpi_id') 
        , 'child_id' => empty(Yii::$app->request->get('child_id')) ? 0 :Yii::$app->request->get('child_id')]
        , ['class' => 'btn btn-success']) ?>
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
                        return  $model->kpKpi->name ;
                } 
            ],
            [
                'attribute'=>'ชื่อตัวชี้วัดรอง',
                "format" => "raw",
                'value' => function($model) { 
                        return  $model->kpChild->name ;
                } 
            ],
            [
                'attribute'=>'ชื่อตัวชี้วัดย่อย',
                "format" => "raw",
                'value' => function($model) { 
                        return  $model->name ;
                } 
            ],
            'strategic',
            [
                'attribute'=>'ผู้รับผิดชอบ',
                "format" => "raw",
                'value' => function($model) { 
                    return empty($model->userManager->id)? ''  : $model->userManager->fname . ' ' . $model->userManager->lname  ;
                } 
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, KpSubchild $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'subchild_id' => $model->subchild_id]);
                 }
            ],
        ],
    ]); ?>


</div>
