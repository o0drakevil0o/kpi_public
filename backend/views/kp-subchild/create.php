<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KpSubchild $model */

$this->title = 'Create Kp Subchild';
$this->params['breadcrumbs'][] = ['label' => 'Kp Subchildren', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kp-subchild-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
