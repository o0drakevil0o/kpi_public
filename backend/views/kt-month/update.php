<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KtMonth $model */

$this->title = 'Update Kt Month: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kt Months', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kt-month-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
