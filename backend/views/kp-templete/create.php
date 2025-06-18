<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KpTemplete $model */

$this->title = 'Create Kp Templete';
$this->params['breadcrumbs'][] = ['label' => 'Kp Templetes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kp-templete-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
