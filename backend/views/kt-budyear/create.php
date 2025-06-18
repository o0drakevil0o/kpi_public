<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KtBudyear $model */

$this->title = 'Create Kt Budyear';
$this->params['breadcrumbs'][] = ['label' => 'Kt Budyears', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kt-budyear-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
