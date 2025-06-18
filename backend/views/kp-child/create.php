<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KpChild $model */

$this->title = 'Create Kp Child';
$this->params['breadcrumbs'][] = ['label' => 'Kp Children', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kp-child-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
