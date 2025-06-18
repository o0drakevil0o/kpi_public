<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KtSubmain $model */

$this->title = 'Create Kt Submain';
$this->params['breadcrumbs'][] = ['label' => 'Kt Submains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kt-submain-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
