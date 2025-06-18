<?php 

namespace backend\controllers;

use Yii;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use frontend\models\SignupForm;
use yii\helpers\Url;
use yii\web\UploadedFile; 
use app\models\KtMain;
use app\models\KtSubmain;
use app\models\KpKpi ; 
use app\models\KpChild ; 
use app\models\KpSubchild ; 
use app\models\KpTemplete ; 
use app\models\KpDepartmentRegister ; 
use app\models\KpTeamRegister ; 
use app\models\KpSendTypeRegister ; 



class UploadFileController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','index-kpi' , 'signup' , 'upload-file-ktmain' ,'upload-file-kpi' , 'download-template' , 'download-template-kpi'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

     /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */

    public function actionIndex(){
        return $this->render('kt-main' , []) ; 
    }
    public function actionIndexKpi(){
        return $this->render('kp-main' , []) ; 
    }

    public function actionUploadFileKtmain(){
        $pathUpload = 'upload/kt-main/files/' ; 
        try{ 
            if(Yii::$app->request->post() !== null){ 
                $file = UploadedFile::getInstanceByName('file') ; 
                $fileName = time().'_'.$file->name;
                $full_path = Yii::getAlias('@webroot').'/'.$pathUpload.$fileName ;
                if($file->saveAs($full_path)){
                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($full_path) ; 
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                    $i = 0;
                    $j = 1;
                    $data = [];
                    foreach($sheetData as $s => $k){
                        foreach($k as $g){
                            $i++;
                            $data[$j][] = $g;
                        }
                        $j++;
                    }
                    foreach($data as $key => $value){ 
                        $model = new KtMain();
                        $modelsub = new KtSubmain() ; 
                        if($key >= 1){ 
                            if($value[0] == "1"){
                                $model->name = $data[$key][2] ; 
                                $model->traget = $data[$key][3] ; 
                                $model->year = $data[$key][4] ;
                                $model->owner = $data[$key][5] ; 
                                $model->save() ; 
                               //echo "parent".$key ; 
                            }
                            else if($value[1] == "1"){
                                $modelcheck = KtMain::find()->orderBy(["id" => SORT_DESC])->limit(1)->all() ; 
                                $modelsub->name = $data[$key][2] ;
                                $modelsub->year = $data[$key][4] ;
                                $modelsub->traget = $data[$key][3] ;
                                $modelsub->owner = $data[$key][5] ;
                                $modelsub->kt_mian_id = $modelcheck[0]["id"];
                                $modelsub->save() ; 
                                //echo "sub".$modelcheck[0]["id"];
                            }   
                            else{ 

                            }
                        }
                    }
                    unlink($full_path);
                    Yii::$app->session->setFlash("success" , "Import Data khongtun to Database complete") ; 
                }
                return $this->redirect(['./upload-file/index']);
            }       
            }catch(Exception $e){ 

            }
    }

    public function actionUploadFileKpi(){
        
        $pathUpload = 'upload/kp-main/files/' ; 
        try{ 
            if(Yii::$app->request->post() !== null){ 
                $file = UploadedFile::getInstanceByName('file') ; 
                $fileName = time().'_'.$file->name;
                $full_path = Yii::getAlias('@webroot').'/'.$pathUpload.$fileName ;
                if($file->saveAs($full_path)){
                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($full_path) ; 
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                    $i = 0;
                    $j = 1;
                    $data = [];
                    foreach($sheetData as $s => $k){
                        foreach($k as $g){
                            $i++;
                            $data[$j][] = $g;
                        }
                        $j++;
                    }
                    foreach($data as $key => $value){ 
                        // create Model for insert data to data base
                        $model = new KpKpi() ; 
                        $modelChild = new KpChild() ; 
                        $modelSubChild = new KpSubchild() ; 
                        $modelTemplate= new KpTemplete() ; 
                        $modelSendTypeRegister = new KpSendTypeRegister() ; 
                        $modelDepartmentRegister = new KpDepartmentRegister() ; 
                        $modelTeamRegister = new KpTeamRegister() ; 
                        if($key >= 1){ 
                            if($value[0] === "1"){ 
                                $model->name = $value[3]; // kpi name & kpi template name not differrant
                                $model->budyear = intval($value[4]);
                                $model->type_kpi = intval($value[24]);
                                $model->stratetgic = intval($value[26]);
                                $model->goal = intval($value[27]);
                                $model->level_kpi = intval($value[24]);
                                $model->manager = intval($value[10]) ;
                                $model->plan = intval($value[28]) ; 
                                $model->project = intval($value[29]);
                                if($model->save()){
                                    if($value[5] === "1"){ 
                                        $modelGetId = KpKpi::find()->orderBy(["kpi_id" => SORT_DESC])->limit(1)->all() ;
                                        $modelTemplate->kpi_id = $modelGetId[0]['kpi_id'];
                                        $modelTemplate->child_id = 0 ;
                                        $modelTemplate->sub_id = 0 ;
                                        $modelTemplate->tem_kpiname =  $value[3] ;  // kpi name & kpi template name not differrant
                                        $modelTemplate->condition =  $value[6]; //$data[$key][6]  ; 
                                        $modelTemplate->min_traget =  $value[7]; //$data[$key][7] ; 
                                        $modelTemplate->weight =  $value[8] ; //$data[$key][8];  
                                        $modelTemplate->send_type =  $value[9];    //$data[$key][9];  
                                        // $modelTemplate->manager =  $value[10] ;   //$data[$key][10];  
                                        $modelTemplate->tem_dic =   $value[11];  //$data[$key][11];
                                        $modelTemplate->unit_a = $value[12];//  $data[$key][12];   
                                        $modelTemplate->unit_b = $value[13];  //$data[$key][13];   
                                        $modelTemplate->unit_c =  $value[14]; //$data[$key][14];   
                                        $modelTemplate->unit_d = $value[15];  //$data[$key][15];   
                                        $modelTemplate->dic_a = $value[16]; //$data[$key][16];   
                                        $modelTemplate->dic_b= $value[17]; //$data[$key][17];   
                                        $modelTemplate->dic_c= $value[18];  //$data[$key][18];   
                                        $modelTemplate->dic_d= $value[19]; //$data[$key][19];   
                                        $modelTemplate->cal = $value[20]; //$data[$key][20]; 
                                        $modelTemplate->people_target = $value[21]; //$data[$key][21]; 
                                        $modelTemplate->description = $value[22]; //$data[$key][22]; 
                                        $modelTemplate->process_data = $value[23];  //$data[$key][23]; 
                                        $modelTemplate->plan = intval($value[28]) ; 
                                        $modelTemplate->save() ;
                                    } 
                                } 
                            }else if($value[1] === "1"){ 
                                $modelGetId = KpKpi::find()->orderBy(["kpi_id" => SORT_DESC])->limit(1)->all() ;  
                                $modelChild->kpi_id = $modelGetId[0]['kpi_id'] ;
                                $modelChild->name =  $value[3]; //$data[$key][3]; // kpi name & kpi template name not differrant
                                $modelChild->budyear = $value[4]; //$data[$key][4];
                                $modelChild->type_kpi = intval($value[24]);
                                $modelChild->strategic = intval($value[26]);
                                $modelChild->goal = intval($value[27]);
                                $modelChild->manager = intval($value[10]) ;
                                $modelChild->plan = intval($value[28]) ; 
                                $modelChild->project = intval($value[29]);
                                if($modelChild->save())
                                {
                                    if($value[5] === "1"){ 
                                        $modelChildGetId = KpChild::find()->orderBy(["child_id" => SORT_DESC])->limit(1)->all() ; 
                                        $modelTemplate->kpi_id = $modelGetId[0]['kpi_id'];
                                        $modelTemplate->child_id = $modelChildGetId[0]['child_id'] ;
                                        $modelTemplate->sub_id = 0 ;
                                        $modelTemplate->tem_kpiname =  $value[3] ;  // kpi name & kpi template name not differrant
                                        $modelTemplate->condition =  $value[6]; //$data[$key][6]  ; 
                                        $modelTemplate->min_traget =  $value[7]; //$data[$key][7] ; 
                                        $modelTemplate->weight =  $value[8] ; //$data[$key][8];  
                                        $modelTemplate->send_type =  $value[9];    //$data[$key][9];  
                                        // $modelTemplate->manager =  $value[10] ;   //$data[$key][10];  
                                        $modelTemplate->tem_dic =   $value[11];  //$data[$key][11];
                                        $modelTemplate->unit_a = $value[12];//  $data[$key][12];   
                                        $modelTemplate->unit_b = $value[13];  //$data[$key][13];   
                                        $modelTemplate->unit_c =  $value[14]; //$data[$key][14];   
                                        $modelTemplate->unit_d = $value[15];  //$data[$key][15];   
                                        $modelTemplate->dic_a = $value[16]; //$data[$key][16];   
                                        $modelTemplate->dic_b= $value[17]; //$data[$key][17];   
                                        $modelTemplate->dic_c= $value[18];  //$data[$key][18];   
                                        $modelTemplate->dic_d= $value[19]; //$data[$key][19];   
                                        $modelTemplate->cal = $value[20]; //$data[$key][20]; 
                                        $modelTemplate->people_target = $value[21]; //$data[$key][21]; 
                                        $modelTemplate->description = $value[22]; //$data[$key][22]; 
                                        $modelTemplate->process_data = $value[23];  //$data[$key][23]; 
                                        $modelTemplate->plan = intval($value[28]) ; 
                                        $modelTemplate->save() ;
                                    }   
                                }
                            }else if($value[2] === "1"){ 
                                $modelGetId = KpKpi::find()->orderBy(["kpi_id" => SORT_DESC])->limit(1)->all() ;  
                                $modelChildGetId = KpChild::find()->orderBy(["child_id" => SORT_DESC])->limit(1)->all() ;
                                $modelSubChild->kpi_id = $modelGetId[0]['kpi_id']; 
                                $modelSubChild->child_id = $modelChildGetId[0]['child_id'] ;  
                                $modelSubChild->name = $value[3] ; 
                                $modelSubChild->budyear = $value[4] ; 
                                $modelSubChild->strategic = intval($value[26]);
                                $modelSubChild->type_kpi = intval($value[24]);
                                $modelSubChild->goal = intval($value[27]);
                                $modelSubChild->manager = intval($value[10]) ;
                                $modelSubChild->plan = intval($value[28]) ; 
                                $modelSubChild->project = intval($value[29]);
                                if($modelSubChild->save()){ 
                                    $modelSubChildGetId = KpSubchild::find()->orderBy(["subchild_id" => SORT_DESC])->limit(1)->all() ; 
                                        $modelTemplate->kpi_id = $modelGetId[0]['kpi_id'];
                                        $modelTemplate->child_id = $modelChildGetId[0]['child_id'] ;
                                        $modelTemplate->sub_id = $modelSubChildGetId[0]['subchild_id'] ;
                                        $modelTemplate->tem_kpiname =  $value[3] ;  // kpi name & kpi template name not differrant
                                        $modelTemplate->condition =  $value[6]; //$data[$key][6]  ; 
                                        $modelTemplate->min_traget =  $value[7]; //$data[$key][7] ; 
                                        $modelTemplate->weight =  $value[8] ; //$data[$key][8];  
                                        $modelTemplate->send_type =  $value[9];    //$data[$key][9];  
                                        // $modelTemplate->manager =  $value[10] ;   //$data[$key][10];  
                                        $modelTemplate->tem_dic =   $value[11];  //$data[$key][11];
                                        $modelTemplate->unit_a = $value[12];//  $data[$key][12];   
                                        $modelTemplate->unit_b = $value[13];  //$data[$key][13];   
                                        $modelTemplate->unit_c =  $value[14]; //$data[$key][14];   
                                        $modelTemplate->unit_d = $value[15];  //$data[$key][15];   
                                        $modelTemplate->dic_a = $value[16]; //$data[$key][16];   
                                        $modelTemplate->dic_b= $value[17]; //$data[$key][17];   
                                        $modelTemplate->dic_c= $value[18];  //$data[$key][18];   
                                        $modelTemplate->dic_d= $value[19]; //$data[$key][19];   
                                        $modelTemplate->cal = $value[20]; //$data[$key][20]; 
                                        $modelTemplate->people_target = $value[21]; //$data[$key][21]; 
                                        $modelTemplate->description = $value[22]; //$data[$key][22]; 
                                        $modelTemplate->process_data = $value[23];  //$data[$key][23]; 
                                        $modelTemplate->plan = intval($value[28]) ; 
                                        $modelTemplate->save() ; 
                                }
                            }
                        }
                    }
                    unlink($full_path);
                    Yii::$app->session->setFlash("success" , "Import Data Kpi to Database complete") ; 
                }
                return $this->redirect(['./upload-file/index-kpi']);
            }       
            }catch(Exception $e){ 
                
            }
    }
    // Section Download File form yii
    public function actionDownloadTemplate(){ 
       $path = Yii::getAlias('@webroot')."/upload/kt-main/template/เทมเพส.xlsx" ;
       $this->downloadFile($path);
    }
    public function actionDownloadTemplateKpi(){ 
       $path = Yii::getAlias('@webroot')."/upload/kt-main/template/เทมเพสตัวชี้วัด.xlsx" ;
       $this->downloadFile($path);
    }

    public function downloadFile($fullpath)   {
        // function download file from yii2 
        if(!empty($fullpath)){ 
            header("Content-type:application/xlsx"); //for pdf file
            header('Content-Disposition: attachment; filename="'.basename($fullpath).'"'); 
            header('Content-Length: ' . filesize($fullpath));
            readfile($fullpath);
            Yii::app()->end();
        }
      }
    //  Section Method use for help 

}
