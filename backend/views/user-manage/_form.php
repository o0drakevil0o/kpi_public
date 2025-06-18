<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2 ;
use yii\helpers\ArrayHelper;  
use app\models\KpHcode;  
?>

<div class="kt-year-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelF, 'fname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelF, 'lname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelF, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelF, 'password')->passwordInput() ?>
    <?= $form->field($modelF, 'repassword')->passwordInput() ?>
    <?= $form->field($model, 'password_hash')->passwordInput() ?>
    <?= $form->field($modelF, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelF, 'cid')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelF, 'hcode')->widget(Select2::classname() ,
        [
            'data' => ArrayHelper::map(KpHcode::find()->all() , "id" , "hname"),
            'options' => ['placeholder' => 'Select a hcode ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ) ?>
    <?= $form->field($modelF, 'status')->radioList(["10" => 'Use' , "9" => "Unuse"]) ?>
    <?= $form->field($modelF, 'role')->radioList(["ADMIN" => 'Admin' , "USER" => "User"]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
