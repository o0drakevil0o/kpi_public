<?php

namespace frontend\controllers;

use Yii ;
use app\models\KtResulte;
use app\models\KtResulteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\KtMonth ; 
use app\models\KtSubmain ; 
use app\models\KtMain ; 
use yii\helpers\Json;
use common\models\User ; 
use yii\data\Pagination;
use yii\db\Query;
use yii\data\ArrayDataProvider;

/**
 * KtResulteController implements the CRUD actions for KtResulte model.
 */
class KtResulteController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all KtResulte models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new KtResulteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionKtDashboard(){ 

        // query for year
        $queryYear = new Query() ; 
        $queryYear->select(['sum(kt.success) as success','kt.target','kt.processing','kt.unprocessing' , 'sum(kt.bud_success) as bud_success'  , 'kt.bud_proceesing', 'kt.bud_traget' , 'kt.bud_unprocessing' , 'kt.month_id' ,  'ktb.bud_year']) 
        ->from("kt_resulte kt")
        ->join("LEFT JOIN" ,"kt_main ktma" , "ktma.id = kt.main_id")
        ->join("LEFT JOIN" ,"kt_submain ktsma" , "ktsma.id = kt.submain_id")
        ->join("LEFT JOIN" ,"kt_budyear ktb" , "ktb.id = kt.budyear_id") 
        ->groupBy(["kt.budyear_id"]) ; 
        $commandYear = $queryYear->createCommand();
        $dataProviderYear = $commandYear->queryAll();

        // query for month
        $queryMonth = new Query() ; 
        $queryMonth->select(['sum(kt.success) as success','kt.target','kt.processing','kt.unprocessing' , 'ktm.id'  , 'sum(kt.bud_success) as bud_success'  , 'kt.bud_proceesing', 'kt.bud_traget' , 'kt.bud_unprocessing' , 'kt.month_id' ,   'ktm.month_name'])
        ->from("kt_resulte kt")
        ->join("LEFT JOIN" ,"kt_main ktma" , "ktma.id = kt.main_id")
        ->join("LEFT JOIN" ,"kt_submain ktsma" , "ktsma.id = kt.submain_id")
        ->join("LEFT JOIN" ,"kt_month ktm" , "ktm.id = kt.submain_id") 
        ->groupBy(["kt.month_id"]) ; 
        $commandMonth = $queryMonth->createCommand();
        $dataProviderMonth = $commandMonth->queryAll();


        return $this->render('dashboard' , [
            "dataProviderYear" => $dataProviderYear ,
            "dataProviderMonth" => $dataProviderMonth 
        ]) ; 
    }
    /**
     * Displays a single KtResulte model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new KtResulte model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new KtResulte();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing KtResulte model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing KtResulte model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the KtResulte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return KtResulte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KtResulte::findOne(['id' => $id])) !== null) {
            return $model;
        }
            
        throw new NotFoundHttpException('The requested page does not exist.');
    }



public function actionGetsubmain() {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $main = $parents[0];
            $out = $this->Getsubmain($main);
            echo Json::encode(['output'=>$out, 'selected'=>'']);
            return;
        }
    }
    echo Json::encode(['output'=>'', 'selected'=>'']);
}

public function actionGetOwner(){ 
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
         if (!empty($parents[1])) {
            $data =  KtSubmain::find()->where(['id' => $parents[1]])->all() ; 
            $dataFetch = $this->Mapdatafixname($data , 'id' , 'owner' , 'id' , 'owner');
            $dataOwner = User::find()->where(['id' => $dataFetch[0]['owner']])->all();
            $dataUserReturn[] = ["id" => 1 , "name" => $dataOwner[0]->fname. " " .  $dataOwner[0]->lname];  
            return Json::encode(['output'=> $dataUserReturn, 'selected'=>'1']);
         }
         else{ 
             $data = KtMain::find()->where(['id'=> $parents[0]])->all();
             $dataFetch = $this->Mapdatafixname($data , 'id' , 'owner' , 'id' , 'owner');
             $dataOwner = User::find()->where(['id' => $dataFetch[0]['owner']])->all();
             $dataUserReturn[] = ["id" => 1 , "name" => $dataOwner[0]->fname. " " .  $dataOwner[0]->lname];  
             return Json::encode(['output'=> $dataUserReturn, 'selected'=>'1']);
         }
    }
}



//  function extension for depdrop
protected function MapData($datas,$fieldId,$fieldName){
    $obj = [];
    foreach ($datas as $key => $value) {
        array_push($obj, ['id'=>$value->{$fieldId},'name'=>$value->{$fieldName}]);
    }
    return $obj;
}

protected function Mapdatafixname($datas , $fieldId , $fieldName , $argname1 , $argname2){
    $obj = [];
    foreach ($datas as $key => $value) {
        array_push($obj, [$argname1 => $value-> {$fieldId},$argname2 => $value->{$fieldName}]);
    }
    return $obj;
}


protected function Getsubmain($id){
    $datas = KtSubmain::find()->where(['kt_mian_id'=>$id])->all();
    return $this->MapData($datas,'id','name');
}



 
}
