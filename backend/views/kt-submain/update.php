<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KtSubmain $model */

$this->title = 'Update Kt Submain: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kt Submains', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kt-submain-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
