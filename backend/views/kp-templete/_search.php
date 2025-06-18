<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\KpTempleteSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kp-templete-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kpi_id') ?>

    <?= $form->field($model, 'child_id') ?>

    <?= $form->field($model, 'sub_id') ?>

    <?= $form->field($model, 'tem_kpiname') ?>

    <?php // echo $form->field($model, 'tem_dic') ?>

    <?php // echo $form->field($model, 'tem_unit') ?>

    <?php // echo $form->field($model, 'unit_a') ?>

    <?php // echo $form->field($model, 'dic_a') ?>

    <?php // echo $form->field($model, 'unit_b') ?>

    <?php // echo $form->field($model, 'dic_b') ?>

    <?php // echo $form->field($model, 'unit_c') ?>

    <?php // echo $form->field($model, 'dic_c') ?>

    <?php // echo $form->field($model, 'unit_d') ?>

    <?php // echo $form->field($model, 'dic_d') ?>

    <?php // echo $form->field($model, 'cal') ?>

    <?php // echo $form->field($model, 'min_traget') ?>

    <?php // echo $form->field($model, 'people_target') ?>

    <?php // echo $form->field($model, 'process_data') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'support_people') ?>

    <?php // echo $form->field($model, 'condition') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'send_type') ?>

    <?php // echo $form->field($model, 'plan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
