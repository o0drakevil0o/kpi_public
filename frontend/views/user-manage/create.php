<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KtYear $model */

$this->title = 'Create Kt Year';
$this->params['breadcrumbs'][] = ['label' => 'Kt Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kt-year-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
