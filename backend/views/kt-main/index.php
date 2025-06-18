<?php

use app\models\KtMain;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper; 
use app\models\User ; 

/** @var yii\web\View $this */
/** @var app\models\KtMainSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kt Mains';
$this->params['breadcrumbs'][] = $this->title;
$filterName = [] ; 
foreach(User::find()->all() as $key => $value ){
    $filterName[$value['id']] =  $value["fname"].' '.$value["lname"] ;
}
?>
<div class="kt-main-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Kt Main', ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute'=>'name'  ,
                "format" => "raw",
                "value" => function($model){ 
                    $data = $model->name ; 
                    return Html::a($model->name , ['./kt-submain/index' , "id" => $model->id]);
                }
            ],
            [
                'attribute'=>'owner',
                'filter' => $filterName ,
                'value' => function($model){
                    return $model->user->fname.' '.$model->user->lname; 
                }
            ],
            'year',
            'traget',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, KtMain $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>
    </div>

</div>
