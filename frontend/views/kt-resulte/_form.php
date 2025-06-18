<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2 ;
use yii\helpers\ArrayHelper;  
use app\models\KtMonth;  
use app\models\KtMain;  
use app\models\KtBudyear;  
use app\models\KtYear;  
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\KtResulte $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kt-resulte-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'owner')->widget(DepDrop::classname(), [
            'options'=>['id'=>'owner' /*, "disabled" => true*/],
            'pluginOptions'=>[
                'depends'=>['main','submain' ],
                'placeholder'=>'Select...',
                'url'=>Url::to(['/kt-resulte/get-owner'])
            ]
        ]); ?>
    <?= $form->field($model, 'main_id')->widget(Select2::classname() ,
        [
            'data' => ArrayHelper::map(KtMain::find()->all() , "id" , "name"),
            'options' => ['placeholder' => 'Select a state ...' , "id" => "main"],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ) ?>
    <?= $form->field($model, 'submain_id')->widget(DepDrop::classname(), [
            'options'=>['id'=>'submain'],
            'pluginOptions'=>[
                'depends'=>['main'],
                'placeholder'=>'Select...',
                'url'=>Url::to(['/kt-resulte/getsubmain'])
            ]
            ]); ?>
    <?= $form->field($model, 'budyear_id')->widget(Select2::classname() ,
        [
            'data' => ArrayHelper::map(KtBudyear::find()->all() , "id" , "bud_year"),
            'options' => ['placeholder' => 'Select a state ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ) ?>
    <?= $form->field($model, 'month_id')->widget(Select2::classname() ,
        [
            'data' => ArrayHelper::map(KtMonth::find()->all() , "id" , "month_name"),
            'options' => ['placeholder' => 'Select a state ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ) ?>
       <?= $form->field($model, 'year')->widget(Select2::classname() ,
        [
            'data' => ArrayHelper::map(KtYear::find()->all() , "id" , "year"),
            'options' => ['placeholder' => 'Select a state ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ) ?>
    <?= $form->field($model, 'target')->textInput() ?>
    <?= $form->field($model, 'success')->textInput() ?>
    <?= $form->field($model, 'processing')->textInput() ?>
    <?= $form->field($model, 'unprocessing')->textInput() ?>
    <?= $form->field($model, 'bud_traget')->textInput() ?>
    <?= $form->field($model, 'bud_success')->textInput() ?>
    <?= $form->field($model, 'bud_proceesing')->textInput() ?>
    <?= $form->field($model, 'bud_unprocessing')->textInput() ?>
    <div class="form-group my-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>


