<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KtResulte $model */

$this->title = 'Update Kt Resulte: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kt Resultes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kt-resulte-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
