<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KtMain $model */

$this->title = 'Update Kt Main: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kt Mains', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kt-main-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
