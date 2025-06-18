<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\KpTemplete $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kp Templetes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kp-templete-view">

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
            'kpi_id',
            'child_id',
            'sub_id',
            'tem_kpiname:ntext',
            'tem_dic:ntext',
            'tem_unit:ntext',
            'unit_a:ntext',
            'dic_a:ntext',
            'unit_b:ntext',
            'dic_b:ntext',
            'unit_c:ntext',
            'dic_c:ntext',
            'unit_d:ntext',
            'dic_d:ntext',
            'cal:ntext',
            'min_traget:ntext',
            'people_target:ntext',
            'process_data:ntext',
            'description:ntext',
            'created_at',
            'updated_at',
            'support_people',
            'condition',
            'weight',
            [
                'attribute'=>'ประเภทการส่ง',
                "format" => "raw",
                'value' => function($model) { 
                        return  empty($model->sendType) ? '' : $model->sendType->name ;
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
