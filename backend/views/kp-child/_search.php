<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\KpChildSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kp-child-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?php // $form->field($model, 'name') ?>

    <?php // $form->field($model, 'strategic') ?>

    <?php // $form->field($model, 'issue') ?>

    <?php // echo $form->field($model, 'goal') ?>

    <?php // echo $form->field($model, 'goal2') ?>

    <?php // echo $form->field($model, 'project') ?>

    <?php // echo $form->field($model, 'team') ?>

    <?php // echo $form->field($model, 'manager') ?>

    <?php // echo $form->field($model, 'budyear') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'plan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
