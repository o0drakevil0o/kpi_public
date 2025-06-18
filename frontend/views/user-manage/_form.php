<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2 ;
use yii\helpers\ArrayHelper;  
use app\models\KpHcode;  

?>
    <div class="container">
    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6"><?= $form->field($modelF, 'fname')->textInput(['maxlength' => true]) ?></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6"><?= $form->field($modelF, 'lname')->textInput(['maxlength' => true]) ?></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-12"><?= $form->field($modelF, 'username')->textInput(['maxlength' => true])->label("แก้ไข้ชื่อผู้ใช้งาน") ?></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6"><?= $form->field($modelF, 'password')->passwordInput()->label("แก้ไข้รหัสผ่าน") ?></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6"><?= $form->field($modelF, 'repassword')->passwordInput()->label("แก้ไข้รหัสผ่าน") ?></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-12"><?= $form->field($modelF, 'email')->textInput(['maxlength' => true])->label("แก้ไข้ชื่อผู้ใช้งาน") ?></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-12"><?= $form->field($modelF, 'cid')->textInput(['maxlength' => true]) ?></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-12"><?= $form->field($modelF, 'hcode')->widget(Select2::classname() ,
                    [
                        'data' => ArrayHelper::map(KpHcode::find()->all() , "id" , "hname"),
                        'options' => ['placeholder' => 'Select a hcode ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]
                ) ?>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-12 my-5"><?= Html::submitButton('Save', ['class' => 'btn btn-success w-100']) ?></div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
 


