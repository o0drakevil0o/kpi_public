<?php

namespace frontend\controllers;
use Yii ;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use common\models\User ; 
use yii\data\Pagination;
use yii\db\Query;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use common\components\AccessRule;
use app\models\KpTemplete ; 
use app\models\KpBudyear ; 
use app\models\KpLevelKpi ; 
use app\models\KpKpi ;
use app\models\KpChild ;
use app\models\KpSubchild ;
use app\models\HrDepartment ; 
use app\models\HrTeam ; 
use app\models\KpDepartmentRegister ; 
use app\models\KpTeamRegister ; 
use app\models\KpMonth ; 
use app\models\KpHcode ; 
use app\models\KpResulte ; 
use app\models\KpSuccess ;
use app\models\KpResultCalculateTmp ; 

class KpResluteController extends \yii\web\Controller
{
    public function behaviors(){
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access'=>[
                'class'=>AccessControl::className(),
                'only'=> ['create' ,'update' , 'delete-department' , 'add-department' , 'add-teams' , 'delete-teams' ,'add-resulte' , 'search-resulte' ,'kp-dashboard-year' , 'kp-dashboard-detail' , 'kp-statregy'],
                'ruleConfig'=>[
                    'class'=>AccessRule::className()
                ],
                'rules'=>[
                    [
                        'actions'=>['create' , 'add-resulte' , 'search-resulte' , 'kp-dashboard-year' , 'kp-dashboard-detail' ,'kp-statregy'],
                        'allow'=> true,
                        'roles'=>[
                            User::ROLE_USER,
                            User::ROLE_ADMIN
                        ]
                    ], 
                    [
                        'actions'=>['delete-department', 'add-department' ,'add-department' , 'create' , 'delete-teams' ,'add-teams' , 'search-resulte'],
                        'allow'=> true,
                        'roles'=>[User::ROLE_ADMIN]
                    ]
                ]
            ]
        ];
    }

    public function actionKpSelectDashboard(){ 
         $LevelKpi = KpLevelKpi::find()->all() ;
         return $this->render("select-dashboard" , [
            "levelKpi" => $LevelKpi , 
         ]);
    }
    public function actionIndex()
    {
        return $this->redirect('kp-reslute/kp-select-dashboard');
    }
    public function actionCreate(){ 
        $data = KpTemplete::find()->all() ;
        $dataBudYear = KpBudyear::find()->orderBy('BUDYEAR_NAME ASC')->all() ; 
        $dataKpiLevel = KpLevelKpi::find()->all() ; 
        $dataDepartment = HrDepartment::find()->all() ; 
        $dataTeam = HrTeam::find()->all() ; 
        $dataMonth = KpMonth::find()->all() ; 
        $dataHcode = KpHcode::find()->all() ;
        $dataSuccess = KpSuccess::find()->all() ;
        $dataKpi = [] ; 
        if(Yii::$app->request->post()){ 
            $year = Yii::$app->request->post('bud_select') ;
            $level = Yii::$app->request->post('level_select') ;
             $sql = "
             SELECT 
               kpst.name 
             , if(kpd.plan_name is null, kpl.typelevel_name  , kpd.plan_name) as 'plan_duaration_name'
             , kpl.typelevel_name 
             , kpt.* 
             , kpb.* 
             FROM kp_templete kpt
             LEFT JOIN kp_subchild kps ON kpt.sub_id = kps.subchild_id
             LEFT JOIN kp_child kpc ON kpt.child_id = kpc.child_id
             LEFT JOIN kp_kpi kpi ON kpi.kpi_id = kpt.kpi_id
             LEFT JOIN kp_budyear kpb ON kpb.BUDYEAR_ID = kpi.budyear 
             LEFT JOIN kp_send_type kpst ON kpst.id = kpt.send_type
             LEFT JOIN kp_plan_duration kpd on kpd.id = kpt.plan
             LEFT JOIN kp_level_kpi kpl ON kpl.typelevel_id = kpi.level_kpi OR kpl.typelevel_id = kpc.type_kpi OR kpl.typelevel_id = kps.type_kpi
             WHERE kpi.budyear = ".$year." AND (kpi.level_kpi = ".$level." OR kpc.type_kpi = ".$level." OR kps.type_kpi = ".$level." )
             " ;
             $dataKpi = \Yii::$app->db->createCommand($sql)->queryAll() ; 
        }
        return $this->render('create' , [
            'dataKpi' => $dataKpi , 
            'dataBudyear' => $dataBudYear , 
            'dataDepartment' => $dataDepartment , 
            'dataTeam' => $dataTeam , 
            'dataKpiLevel' => $dataKpiLevel   , 
            'dataMonth' => $dataMonth ,
            'dataHcode' => $dataHcode , 
            'dataSuccess' => $dataSuccess 
        ]);
    }
    //  Section Dashboard 
    public function actionKpDashboardDetail($year , $level , $kpiid , $childid , $subchildid){ 
        try{ 
            $hcodeQuery = \Yii::$app->db->createCommand("SELECT hcode FROM kp_hcode WHERE id = 1")->queryAll() ; 
            $hcode =  $hcodeQuery[0]["hcode"] ;
                if($year != 0 && $level != 0 && ($kpiid != 0 || $childid != 0 || $subchildid != 0) )
                {
                if($level != 2 && $level != 1 ){ 
                    $data = $this->DashboardDetail($year , $level , $kpiid , $childid , $subchildid) ; 
                    return $this->render('dashboard-detail' , $data);
                }
                else if($level == 2)
                { 
                    if(!empty(Yii::$app->request->get("hcode"))){
                        $hcode = Yii::$app->request->get("hcode") ;
                    }  
                    $data = $this->DashboardDetailMou($year , $level , $kpiid , $childid , $subchildid , $hcode) ; 
                    return $this->render('dashboard-detail' , $data);
                }
           
                }else{ 
                    return $this->render('dashboard-detail' , [
                        'datadetail' => []
                    ]);
                }
        }catch(Exception $e){ 
            echo 'Error is :'.$e ; 
        }
        
        
    }
    public function actionKpDashboard($level){
        $date = DATE("Y-m-d") ; 
        $sqlYear = "SELECT kpb.BUDYEAR_ID FROM kp_budyear kpb WHERE '" . $date . "'"." BETWEEN kpb.BUDYEAR_DATE_START AND kpb.BUDYEAR_DATE_END" ; 
        $year  = \Yii::$app->db->createCommand($sqlYear)->queryAll() ; 
        if($level == 4 || $level == 3) { 
           $data =  $this->DashbarshThreeYear($level , $year[0]['BUDYEAR_ID']) ; 
            return $this->render('dashboard' , $data); 
        }
        else{ 
           $data =  $this->QueryStepForMou($year[0]['BUDYEAR_ID'] , $level  ,$yearOne="Three") ;
           return $this->render('dashboard' , $data); 
        }

    }
    public function actionKpDashboardYear($year , $level){ 
        if($level != 2 && $level != 1) { 
            $data = $this->DashboardYearCal($year , $level) ; 
            return $this->render('dashboard-year' , $data);
        }
        else if($level == 2){ 
            $data = $this->QueryStepForMou($year , $level , "One") ;
            return $this->render('dashboard-year' , $data);
        }
    } 
    public function actionKpStatregy($year , $level , $statregy){ 

         $sql = '
         SELECT  
         kpt.kpi_id , 
         kpt.child_id , 
         kpt.sub_id , 
         kpt.send_type , 
         kpt.tem_kpiname,
         kpst.STRAT_NAME,
         kpg.GOAL_NAME , 
         kpp.P_name ,
         IF(kpi.budyear is null , IF(kpc.budyear is null,kps.budyear,kpc.budyear) ,kpi.budyear) as `budyear` ,
         IF(kpi.stratetgic is null , IF(kpc.strategic is null,kps.strategic,kpc.strategic) ,kpi.stratetgic) as `strategic`,
         IF(kpi.type_kpi is null , IF(kpc.type_kpi is null,kps.strategic,kpc.type_kpi) ,kpi.type_kpi) as `type_kpi`

         FROM kp_templete kpt 
         LEFT JOIN kp_subchild kps ON kps.subchild_id = kpt.sub_id  
         LEFT JOIN kp_child kpc ON kpc.child_id = kpt.child_id 
         LEFT JOIN kp_kpi kpi ON kpi.kpi_id = kpt.kpi_id 
         LEFT JOIN kp_stratetgic kpst ON kpst.STRAT_ID = IF(kpi.stratetgic is null , IF(kpc.strategic is null,kps.strategic,kpc.strategic) ,kpi.stratetgic) 
         LEFT JOIN kp_goal kpg ON kpg.GOAL_ID = IF(kpi.goal is null , IF(kpc.goal is null,kps.goal,kpc.goal) ,kpi.goal) 
         LEFT JOIN kp_project kpp ON kpp.P_id = IF(kpi.project is null , IF(kpc.project is null,kps.project,kpc.project) ,kpi.project) 
         WHERE (kpi.type_kpi = '.$level.' OR kpc.type_kpi = '.$level.' OR kps.type_kpi = '.$level.')
         AND (kpi.budyear = '.$year.' OR kpc.budyear = '.$year.' OR kps.budyear = '.$year.')  
         AND (kpi.stratetgic = '.$statregy.' OR kpc.strategic = '.$statregy.' OR kps.strategic = '.$statregy.')
         ' ; 

         $datastatregy =  \Yii::$app->db->createCommand($sql)->queryAll() ; 
         return $this->render('statregy'  , [
            'datastatregy' => $datastatregy
         ]);
    }
    public function actionKpDashboardService($level) 
    { 
        return $this->render("dashboard-service-plan" , []);
    }
    // api for select data and ux
    public function actionGetTypeSend(){ 
        if(Yii::$app->request->post()) { 
            try{ 

                $kpi_template_id = Yii::$app->request->post('kpi_template_id');  
                // $data =  KpTemplete::find()->where(['id' => $kpi_template_id])->asArray()->all(); 
                $data =  (new \yii\db\Query())->select(['id', 'kpi_id', 'child_id', 'sub_id', 'tem_kpiname', 'tem_dic', 'tem_unit', 'unit_a', 'dic_a', 'unit_b', 'dic_b', 'unit_c', 'dic_c', 'unit_d', 'dic_d', 'cal', 'min_traget', 'people_target', 'process_data', 'description', 'created_at', 'updated_at', 'support_people', 'condition', 'weight', 'send_type', 'plan'])->from('kp_templete')->where(['id' => $kpi_template_id])->limit(1)->all();
                $dataKpi = KpKpi::find()->where(['kpi_id' => $data[0]['kpi_id']])->asArray()->all();
                $dataKpiManager = User::find()->select('fname,lname')->where(["id" => $dataKpi[0]['manager']])->asArray()->all();
                    $dataChild = [] ; 
                    $dataChildManager = [] ;
                    $dataSubChild = [] ;
                if($data[0]['child_id'] != "0"){
                    $dataChild = KpChild::find()->where(['child_id' => $data[0]['child_id']])->asArray()->all(); 
                    $dataChildManager = User::find()->select('fname,lname')->where(["id" => $dataChild[0]['manager']])->asArray()->all();
                    $dataSubChild = KpSubchild::find()->where(['subchild_id' => $data[0]['sub_id']])->asArray()->all() ; 
                }
                if(!empty($dataSubChild)){
                    $dataSubManager = User::find()->select('fname,lname')->where(["id" => $dataSubChild[0]['manager']])->asArray()->all();
                }
                else $dataSubManager = [] ;

                $dataDepartment = KpDepartmentRegister::find()->select('hd.* , kp_department_register.id')->leftjoin('hr_department hd' , 'hd.hr_department_id = department')
                ->where(["kp_department_register.kpi_id" => $data[0]['kpi_id'] 
                , "kp_department_register.child_id" => $data[0]['child_id'] 
                , "kp_department_register.subchild_id" => $data[0]['sub_id']])->asArray()->all();

                $dataTeam = KpTeamRegister::find()->select('hd.* , kp_team_register.id')->leftjoin('hr_team hd' , 'hd.hr_team_id = team')
                ->where(["kp_team_register.kpi_id" => $data[0]['kpi_id'] 
                , "kp_team_register.child_id" => $data[0]['child_id'] 
                , "kp_team_register.subchild_id" => $data[0]['sub_id']])->asArray()->all();

                $json =  json_encode([
                    "type" => $data[0]['send_type'] ,
                    "detail" => [  
                        "kpi_tem" => $data ,
                        "kpi_main" => $dataKpi , 
                        "kpi_child" => $dataChild , 
                        "dataSubChild" => $dataSubChild ,
                        "managerKPI" => $dataKpiManager,
                        "managerChild" => $dataChildManager,
                        "managerSub" => $dataSubManager,
                        "Department" => $dataDepartment ,
                        "Teams" => $dataTeam 
                    ],
                    "status" => "200" 
                ]);
                return $json ;
            }catch(Exception $e) {  
                return json_encode([
                    "massage" => "Not Found Type And Found Error ".$e ,
                    "status" => "201" 
                ]);
            }
        }       
    }
    public function actionAddDepartment(){ 
         if(Yii::$app->request->post()){ 
            try{ 
                $dataTemplateID = Yii::$app->request->post('kpi_template_id') ; 
                $dataTemplate = KpTemplete::find()->select('kpi_id , child_id , sub_id')->where(['id' => $dataTemplateID])->asArray()->all() ;
                $dataDepartment = Yii::$app->request->post('department') ; 
                $model = new KpDepartmentRegister() ; 
                $model->kpi_id = $dataTemplate[0]['kpi_id']; 
                $model->child_id = $dataTemplate[0]['child_id']; 
                $model->subchild_id = $dataTemplate[0]['sub_id']; 
                $model->department = $dataDepartment ;  
                if($model->save()){ 
                    $data_respone_all = KpDepartmentRegister::find()->select('hd.* ,kp_department_register.id')->leftjoin('hr_department hd' , 'hd.hr_department_id = department')
                    ->where(
                    ["kp_department_register.kpi_id" => $dataTemplate[0]['kpi_id'] , 
                    "kp_department_register.child_id" => $dataTemplate[0]['child_id'] , 
                    "kp_department_register.subchild_id" => $dataTemplate[0]['sub_id']])
                    ->asArray()->all();

                    return json_encode([
                        "massage" => "Add Success" ,
                        "data_respone" => $data_respone_all , 
                        "status" => "200" 
                    ]); 
                } 
            }catch(Exception $e){ 
                return json_encode([
                    "massage" => "Not Found Type And Found Error ".$e ,
                    "status" => "201" 
                ]);
            }
         }
    }
    public function actionDeleteDepartment(){ 
        if(Yii::$app->request->post()){ 
            try{ 
                $id = Yii::$app->request->post('department_id');
                $model = KpDepartmentRegister::findOne(['id' , $id]) ; 
                $dataKPI = $model['kpi_id'] ; 
                $dataChild = $model['child_id'] ; 
                $dataSUB = $model['subchild_id'] ; 
                if($model->delete()){ 
                    $data_respone = KpDepartmentRegister::find()->select('hd.* ,kp_department_register.id')->leftjoin('hr_department hd' , 'hd.hr_department_id = department')
                    ->where(
                    ["kp_department_register.kpi_id" => $dataKPI, 
                    "kp_department_register.child_id" => $dataChild , 
                    "kp_department_register.subchild_id" => $dataSUB])
                    ->asArray()->all();


                    return json_encode([
                        "massage" => "Add Success" ,
                        "data_respone" => $data_respone , 
                        "status" => "200" 
                    ]); 
                }
            }catch(Exception $e){ 
                return json_encode([
                    "massage" => "Not Found Type And Found Error ".$e ,
                    "status" => "201"  
                ]);
            }
        }
    }
    public function actionAddTeams() { 
        if(Yii::$app->request->post()){ 
            try{ 
                $dataTemplateID = Yii::$app->request->post('kpi_template_id') ; 
                $dataTemplate = KpTemplete::find()->select('kpi_id , child_id , sub_id')->where(['id' => $dataTemplateID])->asArray()->all() ;
                $team = Yii::$app->request->post('teams') ; 
                $model = new KpTeamRegister() ; 
                $model->kpi_id = $dataTemplate[0]['kpi_id']; 
                $model->child_id = $dataTemplate[0]['child_id']; 
                $model->subchild_id = $dataTemplate[0]['sub_id']; 
                $model->team = $team ;  
                if($model->save()){ 
                    $data_respone_all = KpTeamRegister::find()->select('ht.* ,kp_team_register.id')->leftjoin('hr_team ht' , 'ht.hr_team_id = team')
                    ->where(
                    ["kp_team_register.kpi_id" => $dataTemplate[0]['kpi_id'] , 
                    "kp_team_register.child_id" => $dataTemplate[0]['child_id'] , 
                    "kp_team_register.subchild_id" => $dataTemplate[0]['sub_id']])
                    ->asArray()->all();

                    return json_encode([
                        "massage" => "Add Success" ,
                        "data_respone" => $data_respone_all , 
                        "status" => "200" 
                    ]); 
                } 
            }catch(Exception $e){ 
                return json_encode([
                    "massage" => "Not Found Type And Found Error ".$e ,
                    "status" => "201" 
                ]);
            }
         }
    }
    public function actionDeleteTeams() { 
        if(Yii::$app->request->post()){ 
            try{ 
                $id = Yii::$app->request->post('team_id');
                $model = KpTeamRegister::findOne(['id' , $id]) ; 
                $dataKPI = $model['kpi_id'] ; 
                $dataChild = $model['child_id'] ; 
                $dataSUB = $model['subchild_id'] ; 
                if($model->delete()){ 
                    $data_respone = KpTeamRegister::find()->select('ht.* ,kp_team_register.id')->leftjoin('hr_team ht' , 'ht.hr_team_id = team')
                    ->where(
                    ["kp_team_register.kpi_id" => $dataKPI, 
                    "kp_team_register.child_id" => $dataChild , 
                    "kp_team_register.subchild_id" => $dataSUB])
                    ->asArray()->all();
                    return json_encode([
                        "massage" => "Add Success" ,
                        "data_respone" => $data_respone , 
                        "status" => "200" 
                    ]); 
                }
            }catch(Exception $e){ 
                return json_encode([
                    "massage" => "Not Found Type And Found Error ".$e ,
                    "status" => "201"  
                ]);
            }
        }
    }
    public function actionSearchResulte(){ 
        if(Yii::$app->request->post()){ 
            try{ 
                 $dataTemplateID = Yii::$app->request->post('kpi_template_id') ;
                 $dataHcode = Yii::$app->request->post('hcode') ;
                 $dataTemplate = KpTemplete::find()->select('kpi_id , child_id , sub_id')->where(['id' => $dataTemplateID])->asArray()->all() ;
                 $dataResulte = KpResulte::find()->where(["kpi_id" => $dataTemplate[0]['kpi_id'] 
                 , "child_id" => $dataTemplate[0]['child_id'] 
                 , "subchild_id" => $dataTemplate[0]['sub_id'] 
                 , "hcode" => $dataHcode
                 ])->asArray()->all() ;
                 return json_encode([
                    "massage" => "Search Success" ,
                    "data_respone" => $dataResulte , 
                    "status" => "200" 
                ]); 
            }catch(Exception $e){ 
                return json_encode([
                    "massage" => "Not Found Type And Found Error ".$e ,
                    "status" => "201"  
                ]);
            }
        }
    }
    public function actionAddResulte(){ 
            if(Yii::$app->request->post()) { 
                try{
                    $status = "" ; 
                    $dataTemplateID = Yii::$app->request->post('kpi_template_id') ;
                    $dataTemplate = KpTemplete::find()->select('kpi_id , child_id , sub_id , min_traget , send_type')->where(['id' => $dataTemplateID])->asArray()->all() ;
                    $dataInsert = Yii::$app->request->post('dataForm') ; 
                    $dataHcode = Yii::$app->request->post('hcode');

                    $dataResulte = KpResulte::find()->where(["kpi_id" => $dataTemplate[0]['kpi_id'] 
                    , "child_id" => $dataTemplate[0]['child_id'] 
                    , "subchild_id" => $dataTemplate[0]['sub_id'] 
                    , "hcode" => $dataHcode
                    ])->asArray()->all() ;

                    if($dataTemplate[0]['min_traget'] !== "ผ่าน")
                    {
                            if(sizeof($dataResulte) === 0){
                                foreach($dataInsert as $key => $value){ 
                                    $model = new KpResulte() ;
                                    $model->hcode = $dataHcode ; 
                                    $model->kpi_id = intval($dataTemplate[0]['kpi_id']);
                                    $model->child_id = intval($dataTemplate[0]['child_id']);
                                    $model->subchild_id = intval($dataTemplate[0]['sub_id']);
                                    $model->target = $dataTemplate[0]['min_traget'];
                                    $model->send_type = intval($dataTemplate[0]['send_type']);
                                    $model->value_a =  intval($value['input_a']);
                                    $model->value_b =  intval($value['input_b']);
                                    $model->value_c =  intval($value['input_c']);
                                    $model->value_d =  intval($value['input_d']);
                                    $model->result =  floatval($value['input_resulte']);
                                    $model->crearted_by = Yii::$app->user->identity->id ;
                                    $model->created_at = date("Y-m-d H:i:s");
                                    if(intval($dataTemplate[0]['send_type']) == 1) { 
                                        $model->count =  $value['month'];
                                    }
                                    else if(intval($dataTemplate[0]['send_type']) == 2) { 
                                        $model->count =  $key+1 ; 
                                    }
                                    else if(intval($dataTemplate[0]['send_type']) == 3) { 
                                        $model->count =  $key+1 ; 
                                    }
                                    else if(intval($dataTemplate[0]['send_type']) == 4) { 
                                        $model->count =  $key+1 ; 
                                    }
                                    else{
                                        return ; 
                                    }
                                    if($model->save(false)) $status = "200" ;
                                }
                                return json_encode([
                                    "massage" => "Save Success" ,
                                    "status" => $status 
                                ]); 
                            }
                            else { 
                                foreach($dataInsert as $key => $value){ 
                                    $model = KpResulte::findOne(['id' => $dataResulte[$key]['id']])  ;
                                    $model->hcode = $dataHcode ; 
                                    $model->kpi_id = intval($dataTemplate[0]['kpi_id']);
                                    $model->child_id = intval($dataTemplate[0]['child_id']);
                                    $model->subchild_id = intval($dataTemplate[0]['sub_id']);
                                    $model->target = $dataTemplate[0]['min_traget'];
                                    $model->send_type = intval($dataTemplate[0]['send_type']);
                                    $model->value_a =  intval($value['input_a']);
                                    $model->value_b =  intval($value['input_b']);
                                    $model->value_c =  intval($value['input_c']);
                                    $model->value_d =  intval($value['input_d']);
                                    $model->result =  floatval($value['input_resulte']);
                                    $model->updated_by = Yii::$app->user->identity->id ;
                                    $model->updated_by = date("Y-m-d H:i:s");
                                        if(intval($dataTemplate[0]['send_type']) == 1) { 
                                            $model->count =  $value['month'];
                                        }
                                        else if(intval($dataTemplate[0]['send_type']) == 2) { 
                                            $model->count =  $key+1 ; 
                                        }
                                        else if(intval($dataTemplate[0]['send_type']) == 3) { 
                                            $model->count =  $key+1 ; 
                                        }
                                        else if(intval($dataTemplate[0]['send_type']) == 4) { 
                                            $model->count =  $key+1 ; 
                                        }
                                        else{
                                            return ; 
                                        }
                                        if($model->save(false)) $status = "200" ;
        
                                }
                                return json_encode([
                                    "massage" => "Save Success" ,
                                    "status" => $status 
                                ]); 
                            }
                        
                    }else{ 
                        if(sizeof($dataResulte) === 0 ){ 
                            foreach($dataInsert as $key => $value){ 
                                $model = new KpResulte() ;
                                $model->hcode = $dataHcode ; 
                                $model->kpi_id = intval($dataTemplate[0]['kpi_id']);
                                $model->child_id = intval($dataTemplate[0]['child_id']);
                                $model->subchild_id = intval($dataTemplate[0]['sub_id']);
                                $model->target = $dataTemplate[0]['min_traget'];
                                $model->send_type = intval($dataTemplate[0]['send_type']);
                                $model->crearted_by = Yii::$app->user->identity->id ;
                                $model->created_at = date("Y-m-d H:i:s");
                                if(intval($value['input_checkbox_1']) != 0){ 
                                    $model->reslute_check = $value['input_checkbox_1'] ;
                                }
                                if(intval($value['input_checkbox_2']) != 0){ 
                                    $model->reslute_check = $value['input_checkbox_2'] ;
                                }
                                if(intval($value['input_checkbox_3']) != 0){ 
                                    $model->reslute_check = $value['input_checkbox_3'] ;
                                }
                                if(intval($value['input_checkbox_4']) != 0){ 
                                    $model->reslute_check = $value['input_checkbox_4'] ;
                                }
 
                                if(intval($dataTemplate[0]['send_type']) == 1) { 
                                    $model->count =  $value['month'];
                                }
                                else if(intval($dataTemplate[0]['send_type']) == 2) { 
                                    $model->count =  $key+1 ; 
                                }
                                else if(intval($dataTemplate[0]['send_type']) == 3) { 
                                    $model->count =  $key+1 ; 
                                }
                                else if(intval($dataTemplate[0]['send_type']) == 4) { 
                                    $model->count =  $key+1 ; 
                                }
                                else{
                                    return ; 
                                }
                                if($model->save(false)) $status = "200" ;
                            }
                            return json_encode([
                                "massage" => "Save Success" ,
                                "status" => $status 
                            ]); 
                        }
                        else { 
                            foreach($dataInsert as $key => $value){ 
                                $model = KpResulte::findOne(['id' => $dataResulte[$key]['id']])  ;
                                $model->hcode = $dataHcode ; 
                                $model->kpi_id = intval($dataTemplate[0]['kpi_id']);
                                $model->child_id = intval($dataTemplate[0]['child_id']);
                                $model->subchild_id = intval($dataTemplate[0]['sub_id']);
                                $model->target = $dataTemplate[0]['min_traget'];
                                $model->send_type = intval($dataTemplate[0]['send_type']);
                                $model->updated_by = Yii::$app->user->identity->id ;
                                $model->updated_by = date("Y-m-d H:i:s");
                                if(intval($value['input_checkbox_1']) != 0){ 
                                    $model->reslute_check = $value['input_checkbox_1'] ;
                                }
                                if(intval($value['input_checkbox_2']) != 0){ 
                                    $model->reslute_check = $value['input_checkbox_2'] ;
                                }
                                if(intval($value['input_checkbox_3']) != 0){ 
                                    $model->reslute_check = $value['input_checkbox_3'] ;
                                }
                                if(intval($value['input_checkbox_4']) != 0){ 
                                    $model->reslute_check = $value['input_checkbox_4'] ;
                                }
 
                                if(intval($dataTemplate[0]['send_type']) == 1) { 
                                    $model->count =  $value['month'];
                                }
                                else if(intval($dataTemplate[0]['send_type']) == 2) { 
                                    $model->count =  $key+1 ; 
                                }
                                else if(intval($dataTemplate[0]['send_type']) == 3) { 
                                    $model->count =  $key+1 ; 
                                }
                                else if(intval($dataTemplate[0]['send_type']) == 4) { 
                                    $model->count =  $key+1 ; 
                                }
                                else{
                                    return ; 
                                }
                                if($model->save(false)) $status = "200" ;
                            }
                            return json_encode([
                                "massage" => "Save Success" ,
                                "status" => $status 
                            ]); 
                        }
                    }
                    
                }catch(Exception $e){ 
                    return json_encode([
                        "massage" => "Not Found Type And Found Error ".$e ,
                        "status" => "201"  
                    ]);
                }
            }
    }
    private function DashboardYearCal($year , $level){ 
        $sqlCheckPass = 'SELECT
        kpbm.BUDYEAR_NAME
        ,SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1,0 )) as `sum_pass`
        ,SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1,0 )) as `sum_not_pass` 
        ,SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0)) as `not_have_condition`
        ,SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)) as `Working`
        ,(SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) / 
        (SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) 
        + SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1, 0 )) 
        + SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0))
        + SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)))
        )*100 as `pass_percent`
        ,(SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1,0 )) / 
        (SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) 
        + SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1, 0 )) 
        + SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0))
        + SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)))
        )*100 as `not_pass_percent`
        ,(SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0)) / 
        (SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) 
        + SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1, 0 )) 
        + SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0))
        + SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)))
        )*100 as `not_condition_percent`
        ,(SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)) / 
        (SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) 
        + SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1, 0 )) 
        + SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0))
        + SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)))
        )*100 as `Working_percent`
        FROM kp_templete kptm 
          LEFT JOIN (
        SELECT
            kpt.id ,
            kpt.kpi_id,
            kpt.child_id,
            kpt.sub_id,
        IF
            ( kps.`name` IS NULL, IF ( kpc.`name` IS NULL, kpi.`name`, kpc.`name` ), kps.`name` ) AS `name`,
            kpt.min_traget,
            kpr.reslute_check,
            kpr.result AS `reslut_total`,
        IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1)  
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ))) AS `result`,
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
            ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1)  
            ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 )) as `SENT_ COUNT_DATA` , 
        CASE
                kpt.CONDITION 
                WHEN "=" THEN
            IF
                (
                IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0  
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) 
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ))) = kpt.min_traget,
                    1,
                    0 
                ) 
                WHEN ">=" THEN
            IF
                (
                IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0  
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) AS INT)  
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ) AS INT)
            
            )) >=  CAST(min_traget AS INT),
                    1,
                    0 
                ) 
                WHEN "<=" THEN
            IF
                (
        IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0  
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) as INT) 
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ) AS INT )
            )) <= CAST(min_traget AS INT),
                    1,
                    0 
                ) ELSE 2 
            END AS `PASS_CHECK`,
            kpt.people_target,
            kpb.BUDYEAR_NAME,
            kpr.count,
            kpr.send_type,
            kpst.`name` AS `send_type_name`,
            kpso.STRAT_NAME,
            kpt.description 
        FROM
            kp_templete kpt
            LEFT JOIN kp_resulte kpr ON kpt.kpi_id = kpr.kpi_id 
            AND kpt.child_id = kpr.child_id 
            AND kpt.sub_id = kpr.subchild_id
            LEFT JOIN kp_kpi kpi ON kpi.kpi_id = kpr.kpi_id
            LEFT JOIN kp_child kpc ON kpc.kpi_id = kpr.kpi_id 
            AND kpc.child_id = kpr.child_id
            LEFT JOIN kp_subchild kps ON kps.kpi_id = kpr.kpi_id 
            AND kps.child_id = kpr.child_id 
            AND kps.subchild_id = kpr.subchild_id
            LEFT JOIN kp_stratetgic_original kpso ON kpso.STRAT_ID = kpi.stratetgic
            LEFT JOIN kp_budyear kpb ON kpb.BUDYEAR_ID = kpi.budyear
            LEFT JOIN kp_send_type kpst ON kpst.id = kpr.send_type 
        WHERE
            kpi.budyear = '.$year.'
            AND (kpi.level_kpi = '.$level.'   OR kpc.type_kpi = '.$level.' OR kps.type_kpi = '.$level.' )
         GROUP BY kpt.kpi_id , kpt.child_id , kpt.sub_id 
        ORDER BY
            kpr.send_type DESC
            ) as `kpi_reslute_check` ON kpi_reslute_check.id = kptm.id
            LEFT JOIN kp_kpi kpim ON kpim.kpi_id = kptm.kpi_id
            LEFT JOIN kp_child kpcm ON kpcm.kpi_id = kptm.kpi_id 
            AND kpcm.child_id = kptm.child_id
            LEFT JOIN kp_subchild kpsm ON kpsm.kpi_id = kptm.kpi_id 
            AND kpsm.child_id = kptm.child_id 
            AND kpsm.subchild_id = kptm.sub_id
            LEFT JOIN kp_budyear kpbm ON kpbm.BUDYEAR_ID = kpim.budyear
        WHERE
            kpim.budyear = '.$year.'
            AND (kpim.level_kpi = '.$level.'   OR kpcm.type_kpi = '.$level.' OR kpsm.type_kpi = '.$level.' )
        GROUP BY kpim.budyear 
        ';
        $sqlDetailReslute = '
        SELECT
        kpbm.BUDYEAR_ID
        ,kpbm.BUDYEAR_NAME
        ,kptm.tem_kpiname 
        ,kpi_reslute_check.*
        FROM kp_templete kptm 
          LEFT JOIN (
        SELECT
            kpt.id ,
            kpt.kpi_id,
            kpt.child_id,
            kpt.sub_id,
            IF(kpi.level_kpi = 0 AND kpi.type_kpi = 0 , 
            IF(kpc.type_kpi = 0  , 
            IF(kps.type_kpi <> 0 , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi) ,"")
            , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kpc.type_kpi) )
            , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi OR kpts.typelevel_id = kpi.level_kpi)) as level_id , 
            IF(kpi.level_kpi = 0 AND kpi.type_kpi = 0 , 
            IF(kpc.type_kpi = 0  , 
            IF(kps.type_kpi <> 0 , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi) ,"")
            , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kpc.type_kpi) )
            , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi OR kpts.typelevel_id = kpi.level_kpi)) as level_name , 
        IF
            ( kps.`name` IS NULL, IF ( kpc.`name` IS NULL, kpi.`name`, kpc.`name` ), kps.`name` ) AS `name`,
            kpt.min_traget,
            kpr.reslute_check,
            kpr.result AS `reslut_total`,
        IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1)  
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ))) AS `result`,
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
            ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1)  
            ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 )) as `SENT_ COUNT_DATA` , 
        CASE
                kpt.CONDITION 
                WHEN "=" THEN
            IF
                (
                IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0  
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) 
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ))) = kpt.min_traget,
                    1,
                    0 
                ) 
                WHEN ">=" THEN
            IF
                (
                IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0  
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) AS INT)  
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ) AS INT)
            
            )) >=  CAST(min_traget AS INT),
                    1,
                    0 
                ) 
                WHEN "<=" THEN
            IF
                (
        IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) as INT) 
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ) AS INT )
            )) <= CAST(min_traget AS INT),
                    1,
                    0 
                ) ELSE 2 
            END AS `PASS_CHECK`,
            kpt.people_target,
            kpb.BUDYEAR_NAME,
            kpr.count,
            kpr.send_type,
            kpst.`name` AS `send_type_name`,
            kpso.STRAT_NAME,
            kpt.description 
        FROM
            kp_templete kpt
            LEFT JOIN kp_resulte kpr ON kpt.kpi_id = kpr.kpi_id 
            AND kpt.child_id = kpr.child_id 
            AND kpt.sub_id = kpr.subchild_id
            LEFT JOIN kp_kpi kpi ON kpi.kpi_id = kpr.kpi_id
            LEFT JOIN kp_child kpc ON kpc.kpi_id = kpr.kpi_id 
            AND kpc.child_id = kpr.child_id
            LEFT JOIN kp_subchild kps ON kps.kpi_id = kpr.kpi_id 
            AND kps.child_id = kpr.child_id 
            AND kps.subchild_id = kpr.subchild_id
            LEFT JOIN kp_stratetgic_original kpso ON kpso.STRAT_ID = kpi.stratetgic
            LEFT JOIN kp_budyear kpb ON kpb.BUDYEAR_ID = kpi.budyear
            LEFT JOIN kp_send_type kpst ON kpst.id = kpr.send_type 
        WHERE
            kpi.budyear = '.$year.'
            AND (kpi.level_kpi = '.$level.'   OR kpc.type_kpi = '.$level.' OR kps.type_kpi = '.$level.' )
         GROUP BY kpt.kpi_id , kpt.child_id , kpt.sub_id 
        ORDER BY
            kpr.send_type DESC
            ) as `kpi_reslute_check` ON kpi_reslute_check.id = kptm.id
            LEFT JOIN kp_kpi kpim ON kpim.kpi_id = kptm.kpi_id
            LEFT JOIN kp_child kpcm ON kpcm.kpi_id = kptm.kpi_id 
            AND kpcm.child_id = kptm.child_id
            LEFT JOIN kp_subchild kpsm ON kpsm.kpi_id = kptm.kpi_id 
            AND kpsm.child_id = kptm.child_id 
            AND kpsm.subchild_id = kptm.sub_id
            LEFT JOIN kp_budyear kpbm ON kpbm.BUDYEAR_ID = kpim.budyear
        WHERE
            kpim.budyear = '.$year.'
            AND (kpim.level_kpi = '.$level.'   OR kpcm.type_kpi = '.$level.' OR kpsm.type_kpi = '.$level.' )
        ' ; 
        $dataCheckPass  = \Yii::$app->db->createCommand($sqlCheckPass)->queryAll() ;      
        $dataDetailReslute =  \Yii::$app->db->createCommand($sqlDetailReslute)->queryAll() ; 

        return [
        'dataCheckPass' => $dataCheckPass , 
        'dataDetailReslute' => $dataDetailReslute 
        ] ; 
    }
    private function QueryStepForMou($year , $level  ,$yearOne="One"){
             if($level == 2 && $yearOne == "One"){ 
                $sqlSectionFirst = ' SELECT 
                    kpt.id ,
                    kpt.kpi_id,
                    kpt.child_id,
                    kpt.sub_id,
                    IF(kpi.level_kpi = 0 AND kpi.type_kpi = 0 , 
                    IF(kpc.type_kpi = 0  , 
                    IF(kps.type_kpi <> 0 , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi) ,"")
                    , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kpc.type_kpi) )
                    , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi OR kpts.typelevel_id = kpi.level_kpi)) as level_id , 
                    IF(kpi.level_kpi = 0 AND kpi.type_kpi = 0 , 
                    IF(kpc.type_kpi = 0  , 
                    IF(kps.type_kpi <> 0 , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi) ,"")
                    , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kpc.type_kpi) )
                    , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi OR kpts.typelevel_id = kpi.level_kpi)) as level_name ,
                    IF
                        ( kps.`name` IS NULL, IF ( kpc.`name` IS NULL, kpi.`name`, kpc.`name` ), kps.`name` ) AS `name`,
                        kpt.min_traget,
                        kpr.reslute_check,
                        kpr.result AS `reslut_total`,
                        kpt.condition ,
                        IF
                        ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
                    IF(kpt.min_traget <= kpt.min_traget 
                        ,(SELECT (REPLACE(REPLACE(REPLACE(REPLACE(kpt.cal,"D",sum(kprd.value_d)),"C",sum(kprd.value_c)),"B",sum(kprd.value_b)),"A",SUM(value_a))) as result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id  GROUP BY kprd.kpi_id , kprd.child_id , kprd.subchild_id  ORDER BY kprd.id DESC LIMIT 1 ) 
                        ,(SELECT (REPLACE(REPLACE(REPLACE(REPLACE(kpt.cal,"D",sum(kprd.value_d)),"C",sum(kprd.value_c)),"B",sum(kprd.value_b)),"A",SUM(value_a))) as result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 GROUP BY kprd.kpi_id , kprd.child_id , kprd.subchild_id  ORDER BY kprd.id DESC LIMIT 1)  )) AS `result`,  
                    IF(kpt.min_traget <= kpt.min_traget 
                        ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1)  
                        ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id  ORDER BY kprd.id DESC LIMIT 1 )) as `SENT_COUNT_DATA` , 
                        kpt.people_target,
                        kpb.BUDYEAR_NAME,
                        kpr.count,
                        kpr.send_type,
                        kpst.`name` AS `send_type_name`,
                        kpso.STRAT_NAME,
                        kpt.description 
                    FROM
                        kp_templete kpt
                        LEFT JOIN kp_resulte kpr ON kpt.kpi_id = kpr.kpi_id 
                        AND kpt.child_id = kpr.child_id 
                        AND kpt.sub_id = kpr.subchild_id
                        LEFT JOIN kp_kpi kpi ON kpi.kpi_id = kpr.kpi_id
                        LEFT JOIN kp_child kpc ON kpc.kpi_id = kpr.kpi_id 
                        AND kpc.child_id = kpr.child_id
                        LEFT JOIN kp_subchild kps ON kps.kpi_id = kpr.kpi_id 
                        AND kps.child_id = kpr.child_id 
                        AND kps.subchild_id = kpr.subchild_id
                        LEFT JOIN kp_stratetgic_original kpso ON kpso.STRAT_ID = kpi.stratetgic
                        LEFT JOIN kp_budyear kpb ON kpb.BUDYEAR_ID = kpi.budyear
                        LEFT JOIN kp_send_type kpst ON kpst.id = kpr.send_type 
                    WHERE
                        kpi.budyear IN (
                            SELECT kpbmm.BUDYEAR_ID  FROM kp_budyear kpbmm 
                    WHERE kpbmm.BUDYEAR_NAME IN ( SELECT  CAST(kpb.BUDYEAR_NAME AS INT) as `YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.'  )) 
                        AND (kpi.level_kpi = '.$level.'   OR kpc.type_kpi = '.$level.' OR kps.type_kpi = '.$level.' )
                    GROUP BY kpt.kpi_id , kpt.child_id , kpt.sub_id  
                    ORDER BY
                        kpr.send_type DESC' ; 
        
                      $dataSectionFirst  = \Yii::$app->db->createCommand($sqlSectionFirst)->queryAll() ; 
                      $this->CreateResultTemp($dataSectionFirst);
                $sqlMouSummary =  "SELECT
                                kpbm.BUDYEAR_NAME
                                ,SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1,0 )) as `sum_pass`
                                ,SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1,0 )) as `sum_not_pass` 
                                ,SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0)) as `not_have_condition`
                                ,SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)) as `Working`
                                ,(SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) / 
                                (SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) 
                                + SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1, 0 )) 
                                + SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0))
                                + SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)))
                                )*100 as `pass_percent`
                                ,(SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1,0 )) / 
                                (SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) 
                                + SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1, 0 )) 
                                + SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0))
                                + SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)))
                                )*100 as `not_pass_percent`
                                ,(SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0)) / 
                                (SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) 
                                + SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1, 0 )) 
                                + SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0))
                                + SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)))
                                )*100 as `not_condition_percent`
                                ,(SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)) / 
                                (SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) 
                                + SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1, 0 )) 
                                + SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0))
                                + SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)))
                                )*100 as `Working_percent`
                                FROM kp_templete kptm 
                                LEFT JOIN (SELECT * FROM `kp_result_calculate_tmp` kprc WHERE kprc.BUDYEAR_NAME IN  (SELECT CAST(kpb.BUDYEAR_NAME AS INT) as `YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  ".$year." )) as `kpi_reslute_check` ON  kpi_reslute_check.kpt_id = kptm.id
                                LEFT JOIN kp_kpi kpim ON kpim.kpi_id = kptm.kpi_id
                                LEFT JOIN kp_child kpcm ON kpcm.kpi_id = kptm.kpi_id 
                                AND kpcm.child_id = kptm.child_id
                                LEFT JOIN kp_subchild kpsm ON kpsm.kpi_id = kptm.kpi_id 
                                AND kpsm.child_id = kptm.child_id 
                                AND kpsm.subchild_id = kptm.sub_id
                                LEFT JOIN kp_budyear kpbm ON kpbm.BUDYEAR_ID = kpim.budyear
                                WHERE
                                kpim.budyear = ".$year."
                                AND (kpim.level_kpi = ".$level."   OR kpcm.type_kpi = ".$level." OR kpsm.type_kpi = ".$level." )
                                GROUP BY kpim.budyear 
                        " ; 
                $sqlDetailYear = 'SELECT
                      kpbm.BUDYEAR_ID
                      ,kpbm.BUDYEAR_NAME
                      ,kptm.tem_kpiname 
                      ,kpi_reslute_check.*
                      FROM kp_templete kptm 
                      LEFT JOIN (SELECT * FROM `kp_result_calculate_tmp` kprc WHERE kprc.BUDYEAR_NAME IN  (SELECT CAST(kpb.BUDYEAR_NAME AS INT) as `YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  5 )) as `kpi_reslute_check` ON  kpi_reslute_check.kpt_id = kptm.id
                          LEFT JOIN kp_kpi kpim ON kpim.kpi_id = kptm.kpi_id
                          LEFT JOIN kp_child kpcm ON kpcm.kpi_id = kptm.kpi_id 
                          AND kpcm.child_id = kptm.child_id
                          LEFT JOIN kp_subchild kpsm ON kpsm.kpi_id = kptm.kpi_id 
                          AND kpsm.child_id = kptm.child_id 
                          AND kpsm.subchild_id = kptm.sub_id
                          LEFT JOIN kp_budyear kpbm ON kpbm.BUDYEAR_ID = kpim.budyear
                      WHERE
                          kpim.budyear = '.$year.'
                          AND (kpim.level_kpi = '.$level.'   OR kpcm.type_kpi = '.$level.' OR kpsm.type_kpi = '.$level.' )' ;




                $dataMouSummary  = \Yii::$app->db->createCommand($sqlMouSummary)->queryAll() ;  
                $dataDetailReslute  = \Yii::$app->db->createCommand($sqlDetailYear)->queryAll() ;  

                return [
                    'dataCheckPass' => $dataMouSummary , 
                    'dataDetailReslute' => $dataDetailReslute 
                ] ; 



             }else if($level == 2 && $yearOne = "Three"){ 
                $sqlSectionFirst =  ' SELECT 
                    kpt.id ,
                    kpt.kpi_id,
                    kpt.child_id,
                    kpt.sub_id,
                    IF(kpi.level_kpi = 0 AND kpi.type_kpi = 0 , 
                    IF(kpc.type_kpi = 0  , 
                    IF(kps.type_kpi <> 0 , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi) ,"")
                    , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kpc.type_kpi) )
                    , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi OR kpts.typelevel_id = kpi.level_kpi)) as level_id , 
                    IF(kpi.level_kpi = 0 AND kpi.type_kpi = 0 , 
                    IF(kpc.type_kpi = 0  , 
                    IF(kps.type_kpi <> 0 , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi) ,"")
                    , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kpc.type_kpi) )
                    , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi OR kpts.typelevel_id = kpi.level_kpi)) as level_name ,
                    IF
                        ( kps.`name` IS NULL, IF ( kpc.`name` IS NULL, kpi.`name`, kpc.`name` ), kps.`name` ) AS `name`,
                        kpt.min_traget,
                        kpr.reslute_check,
                        kpr.result AS `reslut_total`,
                        kpt.condition ,
                        IF
                        ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
                    IF(kpt.min_traget <= kpt.min_traget 
                        ,(SELECT (REPLACE(REPLACE(REPLACE(REPLACE(kpt.cal,"D",sum(kprd.value_d)),"C",sum(kprd.value_c)),"B",sum(kprd.value_b)),"A",SUM(value_a))) as result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id  GROUP BY kprd.kpi_id , kprd.child_id , kprd.subchild_id  ORDER BY kprd.id DESC LIMIT 1 ) 
                        ,(SELECT (REPLACE(REPLACE(REPLACE(REPLACE(kpt.cal,"D",sum(kprd.value_d)),"C",sum(kprd.value_c)),"B",sum(kprd.value_b)),"A",SUM(value_a))) as result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 GROUP BY kprd.kpi_id , kprd.child_id , kprd.subchild_id  ORDER BY kprd.id DESC LIMIT 1)  )) AS `result`,  
                    IF(kpt.min_traget <= kpt.min_traget 
                        ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1)  
                        ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id  ORDER BY kprd.id DESC LIMIT 1 )) as `SENT_COUNT_DATA` , 
                        kpt.people_target,
                        kpb.BUDYEAR_NAME,
                        kpr.count,
                        kpr.send_type,
                        kpst.`name` AS `send_type_name`,
                        kpso.STRAT_NAME,
                        kpt.description 
                    FROM
                        kp_templete kpt
                        LEFT JOIN kp_resulte kpr ON kpt.kpi_id = kpr.kpi_id 
                        AND kpt.child_id = kpr.child_id 
                        AND kpt.sub_id = kpr.subchild_id
                        LEFT JOIN kp_kpi kpi ON kpi.kpi_id = kpr.kpi_id
                        LEFT JOIN kp_child kpc ON kpc.kpi_id = kpr.kpi_id 
                        AND kpc.child_id = kpr.child_id
                        LEFT JOIN kp_subchild kps ON kps.kpi_id = kpr.kpi_id 
                        AND kps.child_id = kpr.child_id 
                        AND kps.subchild_id = kpr.subchild_id
                        LEFT JOIN kp_stratetgic_original kpso ON kpso.STRAT_ID = kpi.stratetgic
                        LEFT JOIN kp_budyear kpb ON kpb.BUDYEAR_ID = kpi.budyear
                        LEFT JOIN kp_send_type kpst ON kpst.id = kpr.send_type 
                    WHERE
                        kpi.budyear IN (
                        SELECT kpbmm.BUDYEAR_ID  FROM kp_budyear kpbmm WHERE kpbmm.BUDYEAR_NAME IN (
                        SELECT CAST(kpb.BUDYEAR_NAME AS INT) as `YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID = '.$year.' 
                        UNION
                        SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-1) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.' 
                        UNION
                        SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-2) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.' )
                        ORDER BY kpbmm.BUDYEAR_NAME DESC) 
                        AND (kpi.level_kpi = '.$level.'   OR kpc.type_kpi = '.$level.' OR kps.type_kpi = '.$level.' )
                    GROUP BY kpt.kpi_id , kpt.child_id , kpt.sub_id  
                    ORDER BY
                        kpr.send_type DESC' ; 
        
                      $dataSectionFirst  = \Yii::$app->db->createCommand($sqlSectionFirst)->queryAll() ; 
                      $this->CreateResultTemp($dataSectionFirst);

                    $sqlStretegie  = 'SELECT
                    kpbm.BUDYEAR_NAME
                    ,kpbm.BUDYEAR_ID
                    ,kpim.stratetgic
                    ,SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) as `sum_pass`
                    ,SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1, 0 )) as `sum_not_pass` 
                    ,SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0)) as `not_have_condition`
                    ,SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)) as `Working`
                    ,(SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) / 
                        (SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) 
                        + SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1, 0 )) 
                        + SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0))
                        + SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)))
                        )*100 as `percent`
                    FROM kp_templete kptm 
                          LEFT JOIN (SELECT * FROM `kp_result_calculate_tmp` kprc WHERE kprc.BUDYEAR_NAME IN  
                          (
                          SELECT CAST(kpb.BUDYEAR_NAME AS INT) as `YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.' 
                          UNION
                          SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-1) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.'
                          UNION
                          SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-2) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.'
                          )) as `kpi_reslute_check` ON  kpi_reslute_check.kpt_id = kptm.id
                        LEFT JOIN kp_kpi kpim ON kpim.kpi_id = kptm.kpi_id
                        LEFT JOIN kp_child kpcm ON kpcm.kpi_id = kptm.kpi_id 
                        AND kpcm.child_id = kptm.child_id
                        LEFT JOIN kp_subchild kpsm ON kpsm.kpi_id = kptm.kpi_id 
                        AND kpsm.child_id = kptm.child_id 
                        AND kpsm.subchild_id = kptm.sub_id
                        LEFT JOIN kp_budyear kpbm ON kpbm.BUDYEAR_ID = kpim.budyear
                    WHERE
                        kpim.budyear IN (
                            SELECT kpbmm.BUDYEAR_ID  FROM kp_budyear kpbmm 
                    WHERE kpbmm.BUDYEAR_NAME IN (
                    SELECT 
                    CAST(kpb.BUDYEAR_NAME AS INT) as `YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.'
                    UNION
                    SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-1) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID = '.$year.'
                    UNION
                    SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-2) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.'
                    )
                        ) 
                        AND (kpim.level_kpi = '.$level.'   OR kpcm.type_kpi = '.$level.' OR kpsm.type_kpi = '.$level.' ) 
                    GROUP BY kpim.budyear , kpim.stratetgic
                    ORDER BY kpbm.BUDYEAR_NAME DESC , kpim.stratetgic ASC ' ;      
                    $sqlGuage = ' SELECT
                    kpbm.BUDYEAR_NAME
                    ,SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) as `sum_pass`
                    ,SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1, 0 )) as `sum_not_pass` 
                    ,SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0)) as `not_have_condition`
                    ,SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)) as `Working`
                    FROM kp_templete kptm 
                          LEFT JOIN (SELECT * FROM `kp_result_calculate_tmp` kprc WHERE kprc.BUDYEAR_NAME IN  
                          (
                          SELECT CAST(kpb.BUDYEAR_NAME AS INT) as `YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID = '.$year.' 
                          UNION
                          SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-1) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.'
                          UNION
                          SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-2) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.'
                          )) as `kpi_reslute_check` ON  kpi_reslute_check.kpt_id = kptm.id
                        LEFT JOIN kp_kpi kpim ON kpim.kpi_id = kptm.kpi_id
                        LEFT JOIN kp_child kpcm ON kpcm.kpi_id = kptm.kpi_id 
                        AND kpcm.child_id = kptm.child_id
                        LEFT JOIN kp_subchild kpsm ON kpsm.kpi_id = kptm.kpi_id 
                        AND kpsm.child_id = kptm.child_id 
                        AND kpsm.subchild_id = kptm.sub_id
                        LEFT JOIN kp_budyear kpbm ON kpbm.BUDYEAR_ID = kpim.budyear
                    WHERE
                        kpim.budyear IN (
                            SELECT kpbmm.BUDYEAR_ID  FROM kp_budyear kpbmm 
                    WHERE kpbmm.BUDYEAR_NAME IN (
                    SELECT 
                    CAST(kpb.BUDYEAR_NAME AS INT) as `YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.' 
                    UNION
                    SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-1) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.'
                    UNION
                    SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-2) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.'
                    )
                        ) 
                    AND (kpim.level_kpi = '.$level.'   OR kpcm.type_kpi = '.$level.' OR kpsm.type_kpi = '.$level.')
                    GROUP BY kpim.budyear
                    ORDER BY kpbm.BUDYEAR_NAME DESC' ; 
                    $dataTable = \Yii::$app->db->createCommand($sqlGuage)->queryAll() ; 
                    $dataStragic = \Yii::$app->db->createCommand($sqlStretegie)->queryAll() ; 

                    return  [
                        'dataTable' => $dataTable ,
                        'dataStragic' => $dataStragic , 
                    ] ;
             }  
             else{ 

             }
    } 
    private function DashbarshThreeYear($level , $year) {
        $sqlStretegie =  'SELECT
        kpbm.BUDYEAR_NAME
        ,kpbm.BUDYEAR_ID
        ,kpim.stratetgic
        ,SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) as `sum_pass`
        ,SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1, 0 )) as `sum_not_pass` 
        ,SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0)) as `not_have_condition`
        ,SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)) as `Working`
        ,(SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) / 
            (SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) 
            + SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1, 0 )) 
            + SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0))
            + SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)))
            )*100 as `percent`
        FROM kp_templete kptm 
        LEFT JOIN (
        SELECT
            kpt.id ,
            kpt.kpi_id,
            kpt.child_id,
            kpt.sub_id,
            IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1)  
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ))) AS `result`,
        IF(kpt.min_traget <= kpt.min_traget 
            ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0  ORDER BY kprd.id DESC LIMIT 1)  
            ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 )) as `SENT_ COUNT_DATA` , 
        CASE
                kpt.CONDITION 
                WHEN "=" THEN
            IF
                (
                IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0  ORDER BY kprd.id DESC LIMIT 1) 
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ))) = kpt.min_traget,
                    1,
                    0 
                ) 
                WHEN ">=" THEN
            IF
                (
                IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) AS INT)  
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ) AS INT)
            
            )) >=  CAST(min_traget AS INT),
                    1,
                    0 
                ) 
                WHEN "<=" THEN
            IF
                (
        IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) as INT) 
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ) AS INT )
            )) <= CAST(min_traget AS INT),
                    1,
                    0 
                ) ELSE 2 
            END AS `PASS_CHECK`,
            kpt.people_target,
            kpb.BUDYEAR_NAME,
            kpr.count,
            kpr.send_type,
            kpst.`name` AS `send_type_name`,
            kpso.STRAT_NAME,
            kpt.description 
        FROM
            kp_templete kpt
            LEFT JOIN kp_resulte kpr ON kpt.kpi_id = kpr.kpi_id 
            AND kpt.child_id = kpr.child_id 
            AND kpt.sub_id = kpr.subchild_id
            LEFT JOIN kp_kpi kpi ON kpi.kpi_id = kpr.kpi_id
            LEFT JOIN kp_child kpc ON kpc.kpi_id = kpr.kpi_id 
            AND kpc.child_id = kpr.child_id
            LEFT JOIN kp_subchild kps ON kps.kpi_id = kpr.kpi_id 
            AND kps.child_id = kpr.child_id 
            AND kps.subchild_id = kpr.subchild_id
            LEFT JOIN kp_stratetgic_original kpso ON kpso.STRAT_ID = kpi.stratetgic
            LEFT JOIN kp_budyear kpb ON kpb.BUDYEAR_ID = kpi.budyear
            LEFT JOIN kp_send_type kpst ON kpst.id = kpr.send_type 
        WHERE
            kpi.budyear IN (
                SELECT kpbmm.BUDYEAR_ID  FROM kp_budyear kpbmm 
        WHERE kpbmm.BUDYEAR_NAME IN (
        SELECT 
        CAST(kpb.BUDYEAR_NAME AS INT) as `YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID = '.$year.' 
        UNION
        SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-1) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.' 
        UNION
        SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-2) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.' 
        )
        ORDER BY kpbmm.BUDYEAR_NAME DESC
            ) 
            AND (kpi.level_kpi = '.$level.'   OR kpc.type_kpi = '.$level.' OR kps.type_kpi = '.$level.' ) 
        GROUP BY kpt.kpi_id , kpt.child_id , kpt.sub_id 
        ORDER BY
            kpr.send_type DESC
            ) as `kpi_reslute_check` ON kpi_reslute_check.id = kptm.id
            LEFT JOIN kp_kpi kpim ON kpim.kpi_id = kptm.kpi_id
            LEFT JOIN kp_child kpcm ON kpcm.kpi_id = kptm.kpi_id 
            AND kpcm.child_id = kptm.child_id
            LEFT JOIN kp_subchild kpsm ON kpsm.kpi_id = kptm.kpi_id 
            AND kpsm.child_id = kptm.child_id 
            AND kpsm.subchild_id = kptm.sub_id
            LEFT JOIN kp_budyear kpbm ON kpbm.BUDYEAR_ID = kpim.budyear
        WHERE
            kpim.budyear IN (
                SELECT kpbmm.BUDYEAR_ID  FROM kp_budyear kpbmm 
        WHERE kpbmm.BUDYEAR_NAME IN (
        SELECT 
        CAST(kpb.BUDYEAR_NAME AS INT) as `YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.' 
        UNION
        SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-1) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.' 
        UNION
        SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-2) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.' 
        )
            ) 
            AND (kpim.level_kpi = '.$level.'   OR kpcm.type_kpi = '.$level.' OR kpsm.type_kpi = '.$level.' ) 
        GROUP BY kpim.budyear , kpim.stratetgic
        ORDER BY kpbm.BUDYEAR_NAME DESC , kpim.stratetgic ASC ' ; 
        $sqlGuage =  'SELECT
        kpbm.BUDYEAR_NAME
        ,SUM(IF(kpi_reslute_check.PASS_CHECK = 1 , 1, 0 )) as `sum_pass`
        ,SUM(IF(kpi_reslute_check.PASS_CHECK = 0 , 1, 0 )) as `sum_not_pass` 
        ,SUM(IF(kpi_reslute_check.PASS_CHECK = 2 , 1 ,0)) as `not_have_condition`
        ,SUM(IF(kpi_reslute_check.PASS_CHECK is null , 1 ,0)) as `Working`
        FROM kp_templete kptm 
        LEFT JOIN (
        SELECT
            kpt.id ,
            kpt.kpi_id,
            kpt.child_id,
            kpt.sub_id,
        IF
            ( kps.`name` IS NULL, IF ( kpc.`name` IS NULL, kpi.`name`, kpc.`name` ), kps.`name` ) AS `name`,
            kpt.min_traget,
            kpr.reslute_check,
            kpr.result AS `reslut_total`,
            IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget 
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1)  
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1 ))) AS `result`,
        IF(kpt.min_traget <= kpt.min_traget 
            ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1)  
            ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1 )) as `SENT_ COUNT_DATA` , 
        CASE
                kpt.CONDITION 
                WHEN "=" THEN
            IF
                (
                IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) 
            ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ))) = kpt.min_traget,
                    1,
                    0 
                ) 
                WHEN ">=" THEN
            IF
                (
                IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0  ORDER BY kprd.id DESC LIMIT 1) AS INT)  
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ) AS INT)
            
            )) >=  CAST(min_traget AS INT),
                    1,
                    0 
                ) 
                WHEN "<=" THEN
            IF
                (
        IF
            ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
        IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0  ORDER BY kprd.id DESC LIMIT 1) as INT) 
            ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ) AS INT )
            )) <= CAST(min_traget AS INT),
                    1,
                    0 
                ) ELSE 2 
            END AS `PASS_CHECK`,
            kpt.people_target,
            kpb.BUDYEAR_NAME,
            kpr.count,
            kpr.send_type,
            kpst.`name` AS `send_type_name`,
            kpso.STRAT_NAME,
            kpt.description 
        FROM
            kp_templete kpt
            LEFT JOIN kp_resulte kpr ON kpt.kpi_id = kpr.kpi_id 
            AND kpt.child_id = kpr.child_id 
            AND kpt.sub_id = kpr.subchild_id
            LEFT JOIN kp_kpi kpi ON kpi.kpi_id = kpr.kpi_id
            LEFT JOIN kp_child kpc ON kpc.kpi_id = kpr.kpi_id 
            AND kpc.child_id = kpr.child_id
            LEFT JOIN kp_subchild kps ON kps.kpi_id = kpr.kpi_id 
            AND kps.child_id = kpr.child_id 
            AND kps.subchild_id = kpr.subchild_id
            LEFT JOIN kp_stratetgic_original kpso ON kpso.STRAT_ID = kpi.stratetgic
            LEFT JOIN kp_budyear kpb ON kpb.BUDYEAR_ID = kpi.budyear
            LEFT JOIN kp_send_type kpst ON kpst.id = kpr.send_type 
        WHERE
            kpi.budyear IN (
                SELECT kpbmm.BUDYEAR_ID  FROM kp_budyear kpbmm 
        WHERE kpbmm.BUDYEAR_NAME IN (
        SELECT 
        CAST(kpb.BUDYEAR_NAME AS INT) as `YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID = '.$year.' 
        UNION
        SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-1) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.' 
        UNION
        SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-2) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.' 
        )
        ORDER BY kpbmm.BUDYEAR_NAME DESC
            ) 
            AND (kpi.level_kpi = '.$level.'   OR kpc.type_kpi = '.$level.' OR kps.type_kpi = '.$level.' )
        GROUP BY kpt.kpi_id , kpt.child_id , kpt.sub_id  
        ORDER BY
            kpr.send_type DESC
            ) as `kpi_reslute_check` ON kpi_reslute_check.id = kptm.id
            LEFT JOIN kp_kpi kpim ON kpim.kpi_id = kptm.kpi_id
            LEFT JOIN kp_child kpcm ON kpcm.kpi_id = kptm.kpi_id 
            AND kpcm.child_id = kptm.child_id
            LEFT JOIN kp_subchild kpsm ON kpsm.kpi_id = kptm.kpi_id 
            AND kpsm.child_id = kptm.child_id 
            AND kpsm.subchild_id = kptm.sub_id
            LEFT JOIN kp_budyear kpbm ON kpbm.BUDYEAR_ID = kpim.budyear
        WHERE
            kpim.budyear IN (
                SELECT kpbmm.BUDYEAR_ID  FROM kp_budyear kpbmm 
        WHERE kpbmm.BUDYEAR_NAME IN (
        SELECT 
        CAST(kpb.BUDYEAR_NAME AS INT) as `YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.' 
        UNION
        SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-1) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.' 
        UNION
        SELECT (CAST(kpb.BUDYEAR_NAME AS INT)-2) as `BEFORE_ONE_YEAR` FROM kp_budyear kpb WHERE kpb.BUDYEAR_ID =  '.$year.' 
        )
            ) 
        AND (kpim.level_kpi = '.$level.'   OR kpcm.type_kpi = '.$level.' OR kpsm.type_kpi = '.$level.' )
        GROUP BY kpim.budyear
        ORDER BY kpbm.BUDYEAR_NAME DESC' ; 

        $dataTable = \Yii::$app->db->createCommand($sqlGuage)->queryAll() ; 
        $dataStragic = \Yii::$app->db->createCommand($sqlStretegie)->queryAll() ; 

        return [
            'dataTable' => $dataTable ,
            'dataStragic' => $dataStragic
        ]; 
    }
    private function CreateResultTemp($dataSectionFirst){ 
        foreach($dataSectionFirst as $key => $value){ 
            $result = 0; 
            $passcheck = 0 ;
            if($value['min_traget'] != "ผ่าน"){
                if(!strpos($value['result'], "/0")){
                    eval('$result = ' .$value['result']. ';');
                    $result = number_format(round($result, 1), 2); 
                }else{ 
                    $result = $value['reslut_total']; 
                }
                
            }
           


            if($value['min_traget'] == "ผ่าน") { 
                if($dataSectionFirst[$key]["result"] == "ผ่าน" || $dataSectionFirst[$key]["reslute_check"] == 4){
                    $passcheck = 1;
                    $result = "ผ่าน"; 
                } else { 
                    $passcheck = 0;
                    $result = "ไม่ผ่าน"; 
                }
            }
            else { 
                switch ($value['condition']) {
                    case "=":
                        $passcheck = ($value['min_traget'] == $result) ? 1 : 0;
                        break;
                    case ">=":
                        $passcheck = ($result >= $value['min_traget']  ) ? 1 : 0;
                        break;
                    case "<=":
                        $passcheck = ($result <= $value['min_traget'] ) ? 1 : 0;
                        break;
                }
            }
            $sqlCalCheck = "SELECT * FROM kp_result_calculate_tmp krc WHERE krc.kpi_id = ".$value['kpi_id']." AND krc.child_id = ".$value['child_id']." AND krc.sub_id = " .$value['sub_id']; 
            $dataCalCheck  = \Yii::$app->db->createCommand($sqlCalCheck)->queryAll() ;  
            if(empty($dataCalCheck)){ 
                Yii::$app->db->createCommand()->insert('kp_result_calculate_tmp', [
                    'kpt_id' => $value['id'],
                    'kpi_id' => $value['kpi_id'],
                    'child_id' => $value['child_id'],
                    'sub_id' => $value['sub_id'],
                    'level_id' => $value['level_id'],
                    'level_name' => $value['level_name'],
                    'name' => $value['name'],
                    'min_traget' => $value['min_traget'],
                    'reslute_check' => $value['reslute_check'],
                    'reslut_total' => $value['reslut_total'],
                    'result' => $result,
                    'SENT_ COUNT_DATA' => $value['SENT_COUNT_DATA'],
                    'PASS_CHECK' => $passcheck,
                    'people_target' => $value['people_target'],
                    'BUDYEAR_NAME' => $value['BUDYEAR_NAME'],
                    'count' => $value['count'],
                    'send_type' => $value['send_type'],
                    'send_type_name' => $value['send_type_name'],
                    'STRAT_NAME' => $value['STRAT_NAME'],
                    'description' => $value['description'],
                ])->execute();
                
            }else { 
                $updatedRows = Yii::$app->db->createCommand()->update(
                    'kp_result_calculate_tmp', // Table name
                    [ // Columns to update
                        'kpt_id' => $value['id'],
                        'kpi_id' => $value['kpi_id'],
                        'child_id' => $value['child_id'],
                        'sub_id' => $value['sub_id'],
                        'level_id' => $value['level_id'],
                        'level_name' => $value['level_name'],
                        'name' => $value['name'],
                        'min_traget' => $value['min_traget'],
                        'reslute_check' => $value['reslute_check'],
                        'reslut_total' => $value['reslut_total'],
                        'result' => $result,
                        'SENT_ COUNT_DATA' => $value['SENT_COUNT_DATA'],
                        'PASS_CHECK' => $passcheck,
                        'people_target' => $value['people_target'],
                        'BUDYEAR_NAME' => $value['BUDYEAR_NAME'],
                        'count' => $value['count'],
                        'send_type' => $value['send_type'],
                        'send_type_name' => $value['send_type_name'],
                        'STRAT_NAME' => $value['STRAT_NAME'],
                        'description' => $value['description']
                    ],
                    ['id' => $dataCalCheck[0]['id']]
                )->execute();
                
                if ($updatedRows > 0) {
                    Yii::info("Record updated successfully.", __METHOD__);
                } else {
                    Yii::error("No records updated. Record may not exist.", __METHOD__);
                }
            }
        }
    }
    private function DashboardDetail($year , $level , $kpiid , $childid , $subchildid  ){ 
        $sql = 'SELECT
        kpt.id ,
        kpt.kpi_id,
        kpt.child_id,
        kpt.sub_id,
                    kpt.dic_a , 
                    kpt.dic_b , 
                    kpt.dic_c , 
                    kpt.dic_d ,
                    kpt.min_traget ,
                    kpt.cal ,
                    kpt.condition ,
                    IF(kpi.level_kpi = 0 AND kpi.type_kpi = 0 , 
                    IF(kpc.type_kpi = 0  , 
                    IF(kps.type_kpi <> 0 , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi) ,"")
                    , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kpc.type_kpi) )
                    , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi OR kpts.typelevel_id = kpi.level_kpi)) as level_id , 
                    IF(kpi.level_kpi = 0 AND kpi.type_kpi = 0 , 
                    IF(kpc.type_kpi = 0  , 
                    IF(kps.type_kpi <> 0 , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi) ,"")
                    , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kpc.type_kpi) )
                    , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi OR kpts.typelevel_id = kpi.level_kpi)) as level_name , 
                IF
                    ( kps.`name` IS NULL, IF ( kpc.`name` IS NULL, kpi.`name`, kpc.`name` ), kps.`name` ) AS `name`,
                    kpt.min_traget,
                                kpr.value_a , 
                                kpr.value_b , 
                                kpr.value_c , 
                                kpr.value_d ,
                    kpr.reslute_check,
                    kpr.result AS `reslut_total`,
                IF
                    ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
                IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
                    ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1)  
                    ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id  ORDER BY kprd.id DESC LIMIT 1 ))) AS `result`,
                IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
                    ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1)  
                    ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 )) as `SENT_ COUNT_DATA` , 
                CASE
                        kpt.CONDITION 
                        WHEN "=" THEN
                    IF
                        (
                        IF
                    ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
                IF(kpt.min_traget <= kpt.min_traget  AND kpt.min_traget <> 0 
                    ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) 
                    ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ))) = kpt.min_traget,
                            1,
                            0 
                        ) 
                        WHEN ">=" THEN
                    IF
                        (
                        IF
                    ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
                IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
                    ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) AS INT)  
                    ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ) AS INT)
                    
                    )) >=  CAST(min_traget AS INT),
                            1,
                            0 
                        ) 
                        WHEN "<=" THEN
                    IF
                        (
                IF
                    ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
                IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
                    ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) as INT) 
                    ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ) AS INT )
                    )) <= CAST(min_traget AS INT),
                            1,
                            0 
                        ) ELSE 2 
                    END AS `PASS_CHECK`,
                    kpt.people_target,
                    kpb.BUDYEAR_NAME,
                    kpr.count,
                    kpr.send_type,
                    kpst.`name` AS `send_type_name`,
                    kpso.STRAT_NAME,
                    kpt.description 
                FROM
                    kp_templete kpt
                    LEFT JOIN kp_resulte kpr ON kpt.kpi_id = kpr.kpi_id 
                    AND kpt.child_id = kpr.child_id 
                    AND kpt.sub_id = kpr.subchild_id
                    LEFT JOIN kp_kpi kpi ON kpi.kpi_id = kpr.kpi_id
                    LEFT JOIN kp_child kpc ON kpc.kpi_id = kpr.kpi_id 
                    AND kpc.child_id = kpr.child_id
                    LEFT JOIN kp_subchild kps ON kps.kpi_id = kpr.kpi_id 
                    AND kps.child_id = kpr.child_id 
                    AND kps.subchild_id = kpr.subchild_id
                    LEFT JOIN kp_stratetgic_original kpso ON kpso.STRAT_ID = kpi.stratetgic
                    LEFT JOIN kp_budyear kpb ON kpb.BUDYEAR_ID = kpi.budyear
                    LEFT JOIN kp_send_type kpst ON kpst.id = kpr.send_type 
                WHERE
                    kpi.budyear = '.$year.'
                    AND kpi.level_kpi = '.$level.'
                    AND kpt.kpi_id = '.$kpiid.'
                    AND kpt.child_id = '.$childid.'
                    AND kpt.sub_id = '.$subchildid.'
                ORDER BY
                    kpr.send_type DESC' ;
        $dataDetail = \Yii::$app->db->createCommand($sql)->queryAll() ; 
        return [
            'datadetail' => $dataDetail
        ] ; 
    }
    private function DashboardDetailMou($year , $level , $kpiid , $childid , $subchildid , $hcode ){ 
        $sql = 'SELECT
                    kpt.id ,
                    kpt.kpi_id,
                    kpt.child_id,
                    kpt.sub_id,
                    kpt.dic_a , 
                    kpt.dic_b , 
                    kpt.dic_c , 
                    kpt.dic_d ,
                    kpt.min_traget ,
                    kpt.cal ,
                    kpt.condition ,
                    kph.hname ,
                    IF(kpi.level_kpi = 0 AND kpi.type_kpi = 0 , 
                    IF(kpc.type_kpi = 0  , 
                    IF(kps.type_kpi <> 0 , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi) ,"")
                    , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kpc.type_kpi) )
                    , (SELECT kpts.typelevel_id FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi OR kpts.typelevel_id = kpi.level_kpi)) as level_id , 
                    IF(kpi.level_kpi = 0 AND kpi.type_kpi = 0 , 
                    IF(kpc.type_kpi = 0  , 
                    IF(kps.type_kpi <> 0 , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi) ,"")
                    , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kpc.type_kpi) )
                    , (SELECT kpts.typelevel_name FROM kp_level_kpi kpts WHERE kpts.typelevel_id = kps.type_kpi OR kpts.typelevel_id = kpi.level_kpi)) as level_name , 
                IF
                    ( kps.`name` IS NULL, IF ( kpc.`name` IS NULL, kpi.`name`, kpc.`name` ), kps.`name` ) AS `name`,
                    kpt.min_traget,
                                kpr.value_a , 
                                kpr.value_b , 
                                kpr.value_c , 
                                kpr.value_d ,
                    kpr.reslute_check,
                    kpr.result AS `reslut_total`,
                IF
                    ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
                IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
                    ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1)  
                    ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id  ORDER BY kprd.id DESC LIMIT 1 ))) AS `result`,
                IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
                    ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1)  
                    ,(SElECT kprd.count FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 )) as `SENT_ COUNT_DATA` , 
                CASE
                        kpt.CONDITION 
                        WHEN "=" THEN
                    IF
                        (
                        IF
                    ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
                IF(kpt.min_traget <= kpt.min_traget  AND kpt.min_traget <> 0 
                    ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) 
                    ,(SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ))) = kpt.min_traget,
                            1,
                            0 
                        ) 
                        WHEN ">=" THEN
                    IF
                        (
                        IF
                    ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
                IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
                    ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) AS INT)  
                    ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ) AS INT)
                    
                    )) >=  CAST(min_traget AS INT),
                            1,
                            0 
                        ) 
                        WHEN "<=" THEN
                    IF
                        (
                IF
                    ( kpt.min_traget = "ผ่าน", ( SELECT s.s_name FROM kp_success s WHERE s.s_id = kpr.reslute_check ), 
                IF(kpt.min_traget <= kpt.min_traget AND kpt.min_traget <> 0 
                    ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id AND kprd.result <> 0 ORDER BY kprd.id DESC LIMIT 1) as INT) 
                    ,CAST((SElECT kprd.result FROM kp_resulte kprd WHERE kprd.kpi_id = kpt.kpi_id AND kprd.child_id = kpt.child_id AND kprd.subchild_id = kpt.sub_id ORDER BY kprd.id DESC LIMIT 1 ) AS INT )
                    )) <= CAST(min_traget AS INT),
                            1,
                            0 
                        ) ELSE 2 
                    END AS `PASS_CHECK`,
                    kpt.people_target,
                    kpb.BUDYEAR_NAME,
                    kpr.count,
                    kpr.send_type,
                    kpst.`name` AS `send_type_name`,
                    kpso.STRAT_NAME,
                    kpt.description 
                FROM
                    kp_templete kpt
                    LEFT JOIN kp_resulte kpr ON kpt.kpi_id = kpr.kpi_id 
                    AND kpt.child_id = kpr.child_id 
                    AND kpt.sub_id = kpr.subchild_id
                    LEFT JOIN kp_kpi kpi ON kpi.kpi_id = kpr.kpi_id
                    LEFT JOIN kp_child kpc ON kpc.kpi_id = kpr.kpi_id 
                    AND kpc.child_id = kpr.child_id
                    LEFT JOIN kp_subchild kps ON kps.kpi_id = kpr.kpi_id 
                    AND kps.child_id = kpr.child_id 
                    AND kps.subchild_id = kpr.subchild_id
                    LEFT JOIN kp_stratetgic_original kpso ON kpso.STRAT_ID = kpi.stratetgic
                    LEFT JOIN kp_hcode kph ON kph.hcode = kpr.hcode 
                    LEFT JOIN kp_budyear kpb ON kpb.BUDYEAR_ID = kpi.budyear
                    LEFT JOIN kp_send_type kpst ON kpst.id = kpr.send_type 
                WHERE
                    kpi.budyear = '.$year.'
                    AND kpi.level_kpi = '.$level.'
                    AND kpt.kpi_id = '.$kpiid.'
                    AND kpt.child_id = '.$childid.'
                    AND kpt.sub_id = '.$subchildid.'
                    AND kpr.hcode = '.$hcode.'
                ORDER BY
                    kpr.send_type DESC' ;
        $dataDetail = \Yii::$app->db->createCommand($sql)->queryAll() ; 
        return [
            'datadetail' => $dataDetail
        ] ; 
    }
}
