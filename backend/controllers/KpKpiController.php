<?php

namespace backend\controllers;

use Yii ;
use app\models\KpKpi;
use app\models\KpKpiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\AccessRule;
use app\models\KpBudyear;
use app\models\KpLevelKpi ; 
use app\models\KpTemplete ; 
use common\models\User ; 
use app\models\KpChild ; 
use app\models\KpSubchild ; 
use app\models\KpDepartmentRegister ; 
use app\models\KpTeamRegister ;
use app\models\KpStratetgicOriginal ;
use app\models\KpGoal ;
use app\models\KpProject ;
use app\models\KpPlanDuration ;
use app\models\KpResulte ;





/**
 * KpKpiController implements the CRUD actions for KpKpi model.
 */
class KpKpiController extends Controller
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
                'only'=> ['create' ,'update' , 'delete' ,'view' ,'index'],
                'ruleConfig'=>[
                    'class'=>AccessRule::className()
                ],
                'rules'=>[
                    [
                        'actions'=>['create' , 'update' , 'delete' , 'view' ,'index'],
                        'allow'=> true,
                        'roles'=>[
                            User::ROLE_ADMIN
                        ]
                    ], 
                ]
            ]
        ];
    }
    public function actionIndex()
    {
        $searchModel = new KpKpiSearch();
        $dataBudYear = KpBudyear::find()->orderBy('BUDYEAR_NAME ASC')->all() ; 
        $dataKpiLevel = KpLevelKpi::find()->all() ; 
        $dataStatergic  = KpStratetgicOriginal::find()->all() ;
        $dataGoal = KpGoal::find()->all();
        $dataProject = KpProject::find()->all();
        $dataUser = User::find()->all() ;
        $dataPlanDuration = KpPlanDuration::find()->all(); 
        $dataProvider  = $searchModel->searchYearType($this->request->queryParams) ; 
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataBudYear' => $dataBudYear , 
            'dataKpiLevel' => $dataKpiLevel ,
        ]);
    }
    public function actionView($kpi_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($kpi_id),
        ]);
    }
    public function actionCreate()
    {
        $model = new KpKpi();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'kpi_id' => $model->kpi_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionUpdate($kpi_id)
    {
        $model = $this->findModel($kpi_id);
        if ($this->request->isPost && $model->load($this->request->post())) {
            try{ 
                if($model->budyear != Yii::$app->request->post('budyear') || $model->level_kpi != Yii::$app->request->post('level_kpi') || $model->type_kpi != Yii::$app->request->post('type_kpi'))
                { 
                     $modelReslute = KpResulte::find()->where(['kpi_id' => $kpi_id , 'child_id' => 0 , 'subchild_id' => 0])->all() ;
                     if($modelReslute->delete()){
                         $model->save();
                     }
                }
            }catch(Exception $e){ 

            }
            return $this->redirect(['view', 'kpi_id' => $model->kpi_id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionDelete($kpi_id)
    {
        $this->findModel($kpi_id)->delete();

        return $this->redirect(['index']);
    }
    protected function findModel($kpi_id)
    {
        if (($model = KpKpi::findOne(['kpi_id' => $kpi_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    // api section 
    public function actionGetData(){ 
        if(Yii::$app->request->post()) { 
            try{ 
                $kpi_template_id = Yii::$app->request->post('kpi_template_id');  
                $data =  KpTemplete::find()->where(['id' => $kpi_template_id])->asArray()->all(); 
                $dataKpi = KpKpi::find()->where(['kpi_id' => $data[0]['kpi_id']])->asArray()->all();
                $dataKpiManager = User::find()->select('id,fname,lname')->where(["id" => $dataKpi[0]['manager']])->asArray()->all();
                    $dataChild = [] ; 
                    $dataChildManager = [] ;
                    $dataSubChild = [] ;
                if($data[0]['child_id'] != "0"){
                    $dataChild = KpChild::find()->where(['child_id' => $data[0]['child_id']])->asArray()->all(); 
                    $dataChildManager = User::find()->select('id,fname,lname')->where(["id" => $dataChild[0]['manager']])->asArray()->all();
                    $dataSubChild = KpSubchild::find()->where(['subchild_id' => $data[0]['sub_id']])->asArray()->all() ; 
                }
                if(!empty($dataSubChild)){
                    $dataSubManager = User::find()->select('id,fname,lname')->where(["id" => $dataSubChild[0]['manager']])->asArray()->all();
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
    protected function getDataSelection(){ 
        $dataBudYear = KpBudyear::find()->orderBy('BUDYEAR_NAME ASC')->all() ; 
        $dataKpiLevel = KpLevelKpi::find()->all() ; 
        $dataStatergic  = KpStratetgicOriginal::find()->all() ;
        $dataGoal = KpGoal::find()->all();
        $dataProject = KpProject::find()->all();
        $dataUser = User::find()->all() ;
        $dataPlanDuration = KpPlanDuration::find()->all(); 
         
        return  [ 
            $dataBudyear , 
            $dataKpiLevel , 
            $dataStatergic , 
            $dataGoal , 
            $dataProject , 
            $dataUser , 
            $dataPlanDuration , 
        ] ;
    }
}
