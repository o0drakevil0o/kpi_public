<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KtMain $model */

$this->title = 'Create Kt Main';
$this->params['breadcrumbs'][] = ['label' => 'Kt Mains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kt-main-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
