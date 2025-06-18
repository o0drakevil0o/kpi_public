<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\KtBudyear $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kt-budyear-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'bud_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'duration_start')->textInput() ?>

    <?= $form->field($model, 'duration_end')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
