<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use kartik\select2\Select2 ;
use yii\helpers\ArrayHelper;  
use app\models\KpHcode;  

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'fname')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'lname')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'repassword')->passwordInput() ?>
                <?= $form->field($model, 'cid')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'hcode')->widget(Select2::classname() ,
                        [
                            'data' => ArrayHelper::map(KpHcode::find()->all() , "id" , "hname"),
                            'options' => ['placeholder' => 'Select a hcode ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]
                ) ?>
                <?= $form->field($model, 'status')->radioList(["10" => 'Use' , "9" => "Unuse"]) ?>
                <?= $form->field($model, 'role')->radioList(["ADMIN" => 'Admin' , "USER" => "User"]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
