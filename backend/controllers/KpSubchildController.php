<?php

namespace backend\controllers;

use Yii; 
use app\models\KpSubchild;
use app\models\KpSubchildSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\AccessRule;
use common\models\User ; 

/**
 * KpSubchildController implements the CRUD actions for KpSubchild model.
 */
class KpSubchildController extends Controller
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
        $kpiId = empty(Yii::$app->request->get('kpi_id'))? 0  : Yii::$app->request->get('kpi_id'); 
        $childId = empty(Yii::$app->request->get('child_id'))? 0  : Yii::$app->request->get('child_id'); 
        $searchModel = new KpSubchildSearch();
        $dataProvider = $searchModel->searchSubchild($kpiId , $childId);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($subchild_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($subchild_id),
        ]);
    }
    public function actionCreate()
    {
        try{
            $model = new KpSubchild();
            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'subchild_id' => $model->subchild_id]);
                }
            } else {
                $model->loadDefaultValues();
            }
            return $this->render('create', [
                'model' => $model,
            ]);
        }catch(Exception $e){
            throw new Exception("Error Processing Request", 1);
        }
        
    }
    public function actionUpdate($subchild_id)
    {
        $model = $this->findModel($subchild_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'subchild_id' => $model->subchild_id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionDelete($subchild_id)
    {
        $this->findModel($subchild_id)->delete();

        return $this->redirect(['index']);
    }
    protected function findModel($subchild_id)
    {
        if (($model = KpSubchild::findOne(['subchild_id' => $subchild_id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
