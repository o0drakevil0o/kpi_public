<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KtBudyear $model */

$this->title = 'Update Kt Budyear: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kt Budyears', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kt-budyear-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
