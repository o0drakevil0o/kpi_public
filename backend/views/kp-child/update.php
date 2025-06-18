<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KpChild $model */

$this->title = 'Update Kp Child: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kp Children', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'child_id' => $model->child_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kp-child-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
