<?php

use yii\helpers\Html;

$this->title = 'Update user: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'user-manage', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kt-year-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelF' => $modelF 
    ]) ?>

</div>
