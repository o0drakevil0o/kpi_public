<?php

namespace backend\controllers;

use Yii ;
use app\models\KpTemplete;
use app\models\KpTempleteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\components\AccessRule;
use common\models\User ; 
use yii\filters\VerbFilter;
use app\models\KpResulte ; 
/**
 * KpTempleteController implements the CRUD actions for KpTemplete model.
 */
class KpTempleteController extends Controller
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
        $identifyKpi = [
            empty(Yii::$app->request->get('kpi_id'))? 0  : Yii::$app->request->get('kpi_id') , 
            empty(Yii::$app->request->get('child_id'))? 0  : Yii::$app->request->get('child_id'),
            empty(Yii::$app->request->get('sub_id'))? 0  : Yii::$app->request->get('sub_id')
        ] ;
        $searchModel = new KpTempleteSearch();
        $dataProvider = $searchModel->searchTemplete($identifyKpi);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionCreate()
    {
        $model = new KpTemplete();
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($this->request->isPost) {
            $model->load($this->request->post()) ; 
            $dataTemplete = KpTemplete::find()->where(['id' => $id])->all() ;
            if($dataTemplete[0]['send_type'] != $model->send_type){
               $dataReslute = KpResulte::find()->where(['kpi_id' => $model->kpi_id , 'child_id' => $model->child_id , 'subchild_id' => $model->sub_id , 'send_type' => $dataTemplete[0]['send_type'] ])->all();
                if($dataReslute->deleteAll()){
                    if($model->save()){
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }else{ 
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = KpTemplete::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
