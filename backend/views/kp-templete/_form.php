<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2 ;
use app\models\KpSendType ; 
use app\models\KpPlanDuration ; 

/** @var yii\web\View $this */
/** @var app\models\KpTemplete $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kp-templete-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php 
        $sql = "
            SELECT 
            IF(ks.`name` IS NULL, IF(kc.`name` IS NULL, kp.`name` , kc.`name`) , ks.`name`) as `name`
            FROM
            kp_kpi kp 
            LEFT JOIN  kp_child kc ON kc.kpi_id = kp.kpi_id 
            LEFT JOIN  kp_subchild ks ON ks.kpi_id = kp.kpi_id AND ks.child_id = kc.child_id
            WHERE kp.kpi_id = '".Yii::$app->request->get('kpi_id')."'
        " ;
        if(intval(Yii::$app->request->get('child_id')) != 0) $sql .= 'AND kc.child_id = '. Yii::$app->request->get('child_id') ; 
        if(intval(Yii::$app->request->get('sub_id')  != 0)) $sql .= 'AND ks.subchild_id = '. Yii::$app->request->get('sub_id') ;
        $data = \Yii::$app->db->createCommand($sql)->queryAll() ; 
        if(!empty($data)){
            echo  $form->field($model, 'tem_kpiname')->textarea(['rows' => 1 ,'value' => empty($data)?'':$data[0]['name']]); 
        }
        else { 
            echo  $form->field($model, 'tem_kpiname')->textarea(['rows' => 1]); 
        }
    ?>

    <?= $form->field($model, 'tem_dic')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'tem_unit')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'unit_a')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'dic_a')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'unit_b')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'dic_b')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'unit_c')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'dic_c')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'unit_d')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'dic_d')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'cal')->textInput() ?>

    <?= $form->field($model, 'min_traget')->textInput() ?>

    <?= $form->field($model, 'people_target')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'process_data')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'support_people')->textInput() ?>

    <?= $form->field($model, 'condition')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?=  $form->field($model, 'send_type')->widget(Select2::classname() ,
    [
        'data' => ArrayHelper::map(KpSendType::find()->all()  , "id" , "name"),
        'options' => ['placeholder' => 'เลือกประเภทการส่ง ...' , "id" => "send_type"],
        'pluginOptions' => [
              'allowClear' => true
       ],
     ]) ;?>

     <?= 
        $form->field($model, 'plan')->widget(Select2::classname() ,
        [
            'data' => ArrayHelper::map(KpPlanDuration::find()->all()  , "id" , "plan_name"),
            'options' => ['placeholder' => 'เลือกแผนยุทธศาสตร์ ...' , "id" => "plan"],
            'pluginOptions' => [
                  'allowClear' => true
           ],
         ]) ;
     
     ?>
     <?php   echo $form->field($model , 'kpi_id')->hiddenInput(['value' => Yii::$app->request->get('kpi_id')])->label(false) ;  ?>
     <?php  echo $form->field($model , 'child_id')->hiddenInput(['value' => Yii::$app->request->get('child_id')])->label(false); ?>
     <?php  echo $form->field($model , 'sub_id')->hiddenInput(['value' => Yii::$app->request->get('sub_id')])->label(false); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
