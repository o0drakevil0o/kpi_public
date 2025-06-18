<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KpKpi $model */

$this->title = 'Create Kp Kpi';
$this->params['breadcrumbs'][] = ['label' => 'Kp Kpis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kp-kpi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
