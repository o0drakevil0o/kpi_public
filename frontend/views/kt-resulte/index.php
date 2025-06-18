<?php

use app\models\KtResulte;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\KtResulteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kt Resultes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kt-resulte-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Kt Resulte', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<div class="table-responsive">
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
             [
                'attribute'=>'main_id'  ,
                "format" => "raw",
                "value" => function($model){ 
                    return $model->main->name ; 
                }
             ],
             [
                'attribute'=>'submain_id'  ,
                "format" => "raw",
                "value" => function($model){ 
                    return $model->submain->name ; 
                }
             ],
             [
                'attribute'=>'owner',
                "format" => "raw",
                "value" => function($model){ 

                    return $model->user->fname." ".$model->user->lname ; 
                }
             ],
             [
                'attribute'=>'budyear_id',
                "format" => "raw",
                "value" => function($model){ 
                    return $model->budyear->bud_year;
                }
             ],
            [ 
                'attribute' => 'month_id', 
                "format" => "raw",
                "value" => function($model){ 
                    return $model->month->month_name;
                }
            ],
            //'year',
            //'reslute',
            //'target:ntext',
            //'success',
            //'processing',
            //'unprocessing',
            //'bud_traget:ntext',
            //'bud_success',
            //'bud_proceesing',
            //'bud_unprocessing',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, KtResulte $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>
   </div>

</div>
