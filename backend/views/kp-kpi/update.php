<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KpKpi $model */

$this->title = 'Update Kp Kpi: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kp Kpis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'kpi_id' => $model->kpi_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kp-kpi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
