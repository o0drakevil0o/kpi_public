<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KtResulte $model */

$this->title = 'Create Kt Resulte';
$this->params['breadcrumbs'][] = ['label' => 'Kt Resultes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kt-resulte-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
