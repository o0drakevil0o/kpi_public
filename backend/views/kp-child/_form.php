<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2 ;
use app\models\KpBudyear;
use app\models\KpLevelKpi ; 
use app\models\KpTemplete ; 
use app\models\User ; 
use app\models\KpChild ; 
use app\models\KpSubchild ; 
use app\models\KpDepartmentRegister ; 
use app\models\KpTeamRegister ;
use app\models\KpStratetgicOriginal ;
use app\models\KpGoal ;
use app\models\KpProject ;
use app\models\KpPlanDuration ;
use app\models\HrTeam ;

/** @var yii\web\View $this */
/** @var app\models\KpChild $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kp-child-form">

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?=  $form->field($model, 'strategic')->widget(Select2::classname() ,
    [
        'data' => ArrayHelper::map(KpStratetgicOriginal::find()->all()  , "STRAT_ID" , "STRAT_NAME"),
        'options' => ['placeholder' => 'เลือกยุทธศาสตร์ ...' , "id" => "STRAT"],
        'pluginOptions' => [
              'allowClear' => true
       ],
     ]) ;?>

    <?php // $form->field($model, 'issues')->textInput() ?>

    <?=  $form->field($model, 'goal')->widget(Select2::classname() ,
    [
        'data' => ArrayHelper::map(KpGoal::find()->all()  , "GOAL_ID" , "GOAL_NAME"),
        'options' => ['placeholder' => 'เลือกเป้าหมายที่หนึ่ง ...' , "id" => "GOAL"],
        'pluginOptions' => [
              'allowClear' => true
       ],
     ]) ;?>

    <?=  $form->field($model, 'goal2')->widget(Select2::classname() ,
      [
        'data' => ArrayHelper::map(KpGoal::find()->all()  , "GOAL_ID" , "GOAL_NAME"),
        'options' => ['placeholder' => 'เลือกเป้าหมายที่สอง ...' , "id" => "GOAL2"],
        'pluginOptions' => [
              'allowClear' => true
       ],
      ]) ;?>

    <?=  $form->field($model, 'project')->widget(Select2::classname() ,
    [
        'data' => ArrayHelper::map(KpProject::find()->all()  , "P_id" , "P_name"),
        'options' => ['placeholder' => 'เลือกโครงการ ...' , "id" => "Project"],
        'pluginOptions' => [
              'allowClear' => true
       ],
     ]) ;?>
     <?=  $form->field($model, 'team')->widget(Select2::classname() ,
    [
        'data' => ArrayHelper::map(HrTeam::find()->all()  , "HR_TEAM_ID" , "HR_TEAM_NAME"),
        'options' => ['placeholder' => 'เลือกทีมรับผิดชอบหลัก ...' , "id" => "Team"],
        'pluginOptions' => [
              'allowClear' => true
       ],
     ]) ;?>

    <?php 
    $manager = []; 
    foreach(User::find()->all() as $key => $value){ 
        $manager[$value['id']] = $value['fname'].' '.$value['lname'];
    }
    echo $form->field($model, 'manager')->widget(Select2::classname() ,
    [
        'data' => $manager,
        'options' => ['placeholder' => 'เลือกผู้รับผิดชอบ ...' , "id" => "manager"],
        'pluginOptions' => [
              'allowClear' => true
       ],
     ]) ;
     ?>

    <?php  echo $form->field($model, 'budyear')->widget(Select2::classname() ,
            [
            'data' => ArrayHelper::map(KpBudyear::find()->orderBy('BUDYEAR_NAME ASC')->all()  , "BUDYEAR_ID" , "BUDYEAR_NAME"),
            'options' => ['placeholder' => 'เลือกปีงบประมาณ ...' , "id" => "budyear"],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]
        ) ;
    ?>

    <?php  
         echo $form->field($model, 'type_kpi')->widget(Select2::classname() ,
            [
                'data' => ArrayHelper::map(KpLevelKpi::find()->all() , "typelevel_id" , "typelevel_name"),
                'options' => ['placeholder' => 'เลือกระดับตัวชี้วัด ...' , "id" => "type_kpi"],
                'pluginOptions' => [
                      'allowClear' => true
               ],
             ]
        ) ;?>

    <?= $form->field($model, 'weight')->textInput() ?>
    <?php  
            $dataPlan = ["0" => 'ไม่มีแผนยุทธศาสตร์'] ; 
            foreach(KpPlanDuration::find()->all() as $key => $value){ 
                $dataPlan[$value['id']] = $value['plan_name']  ;
            }
         echo $form->field($model, 'plan')->widget(Select2::classname() ,
            [
                'data' => $dataPlan,
                'options' => ['placeholder' => 'เลือกแผนยุทธศาสตร์ ...' , "id" => "plan_kpi"],
                'pluginOptions' => [
                      'allowClear' => true
               ],
             ]
        ) ;?>
     <?php   echo $form->field($model , 'kpi_id')->hiddenInput(['value' => Yii::$app->request->get('kpi_id')])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
