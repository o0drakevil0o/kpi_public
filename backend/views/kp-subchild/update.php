<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KpSubchild $model */

$this->title = 'Update Kp Subchild: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kp Subchildren', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'subchild_id' => $model->subchild_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kp-subchild-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
