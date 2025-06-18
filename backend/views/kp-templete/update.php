<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KpTemplete $model */

$this->title = 'Update Kp Templete: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kp Templetes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kp-templete-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
