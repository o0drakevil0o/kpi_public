<?php

use app\models\KtSubmain;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper ; 
use app\models\KtMain;

/** @var yii\web\View $this */
/** @var app\models\KtSubmainSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kt Submains';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kt-submain-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Kt Submain', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name:ntext',
            'owner',
            [
                'attribute'=>'kt_mian_id',
                'filter' => ArrayHelper::map(KtMain::find()->all(),'id','name'),
                'value' => function($model){
                    return $model->ktMian->name; 
                }
            ],
            'year',
            'traget',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, KtSubmain $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>
    </div>

</div>
