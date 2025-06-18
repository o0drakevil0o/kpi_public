<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\KtResulte $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kt Resultes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kt-resulte-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            [
                'attribute'=>'owner',
                "format" => "raw",
                "value" => function($model){ 
                    return $model->user->fname." ".$model->user->lname ; 
                }
             ],
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
                'attribute'=>'budyear_id',
                "format" => "raw",
                "value" => function($model){ 
                    return $model->budyear->bud_year;
                }
             ],
             [
                'attribute'=>'month_id',
                "format" => "raw",
                "value" => function($model){ 
                    return $model->month->month_name;
                }
             ],
             [
                'attribute'=>'year',
                "format" => "raw",
                "value" => function($model){ 
                    return $model->detailYear->year;
                }
             ], 
            'target:ntext',
            'success',
            'processing',
            'unprocessing',
            'bud_traget:ntext',
            'bud_success',
            'bud_proceesing',
            'bud_unprocessing',
        ],
    ]) ?>

</div>
