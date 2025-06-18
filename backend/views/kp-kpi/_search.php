<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2 ;
use yii\helpers\ArrayHelper; 

?>

<div class="kp-kpi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

     <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card p-5">
                    <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <?php  echo $form->field($model, 'budyear')->widget(Select2::classname() ,
                                    [
                                        'data' => ArrayHelper::map($dataBudYear , "BUDYEAR_ID" , "BUDYEAR_NAME"),
                                        'options' => ['placeholder' => 'Select a year ...' , "id" => "budyear"],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]
                               ) ;
                               ?>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <?php  
                                echo $form->field($model, 'level_kpi')->widget(Select2::classname() ,
                                    [
                                        'data' => ArrayHelper::map($dataKpiLevel , "typelevel_id" , "typelevel_name"),
                                        'options' => ['placeholder' => 'Select a level ...' , "id" => "level"],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]
                               ) ;
                            ?></div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"><?= Html::submitButton('Search', ['class' => 'btn btn-primary w-100']) ?></div>
                </div>
                 
            </div>
        </div>
     </div>
    <?php ActiveForm::end(); ?>
</div>
