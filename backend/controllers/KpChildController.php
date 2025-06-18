<?php

namespace backend\controllers;

use Yii ;
use app\models\KpChild;
use app\models\KpChildSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\AccessRule;
use common\models\User ; 

/**
 * KpChildController implements the CRUD actions for KpChild model.
 */
class KpChildController extends Controller
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
        try{    
            $child_id = empty(Yii::$app->request->get('kpi_id')) ? 0 : Yii::$app->request->get('kpi_id') ; 
            $searchModel = new KpChildSearch();
            $dataProvider = $searchModel->searchFromKpi($child_id);
        }catch(Exception $e){ 
            throw $e ;
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($child_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($child_id),
        ]);
    }
    public function actionCreate()
    {
            try{
                $model = new KpChild();
                if ($this->request->isPost) {
                    if ($model->load($this->request->post())) {
                        if($model->save()){
                            return $this->redirect(['view', 'child_id' => $model->child_id]); 
                        }
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
    public function actionUpdate($child_id)
    {
        $model = $this->findModel($child_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'child_id' => $model->child_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionDelete($child_id)
    {
        $this->findModel($child_id)->delete();

        return $this->redirect(['index']);
    }
    protected function findModel($child_id)
    {
        if (($model = KpChild::findOne(['child_id' => $child_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
