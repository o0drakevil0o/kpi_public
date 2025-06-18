<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KtMonth $model */

$this->title = 'Create Kt Month';
$this->params['breadcrumbs'][] = ['label' => 'Kt Months', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kt-month-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
