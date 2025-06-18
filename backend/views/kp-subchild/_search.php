<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\KpSubchildSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kp-subchild-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'subchild_id') ?>

    <?= $form->field($model, 'kpi_id') ?>

    <?= $form->field($model, 'child_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'strategic') ?>

    <?php // echo $form->field($model, 'issue') ?>

    <?php // echo $form->field($model, 'goal') ?>

    <?php // echo $form->field($model, 'goal2') ?>

    <?php // echo $form->field($model, 'project') ?>

    <?php // echo $form->field($model, 'team') ?>

    <?php // echo $form->field($model, 'manager') ?>

    <?php // echo $form->field($model, 'type_kpi') ?>

    <?php // echo $form->field($model, 'budyear') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'plan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
