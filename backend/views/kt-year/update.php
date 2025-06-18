<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KtYear $model */

$this->title = 'Update Kt Year: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kt Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kt-year-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
