<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\KtResulteSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kt-resulte-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'owner') ?>

    <?= $form->field($model, 'main_id') ?>

    <?= $form->field($model, 'submain_id') ?>

    <?= $form->field($model, 'budyear_id') ?>

    <?php // echo $form->field($model, 'month_id') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'reslute') ?>

    <?php // echo $form->field($model, 'target') ?>

    <?php // echo $form->field($model, 'success') ?>

    <?php // echo $form->field($model, 'processing') ?>

    <?php // echo $form->field($model, 'unprocessing') ?>

    <?php // echo $form->field($model, 'bud_traget') ?>

    <?php // echo $form->field($model, 'bud_success') ?>

    <?php // echo $form->field($model, 'bud_proceesing') ?>

    <?php // echo $form->field($model, 'bud_unprocessing') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
