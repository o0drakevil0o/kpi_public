<?php

namespace backend\controllers;

use Yii ;
use app\models\User ; 
use app\models\UserSearch ; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\UpdateUserForm ; 
use yii\base\Security;


class UserManageController extends \yii\web\Controller
{

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




    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

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
        $model = new User();
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
         $modelF = new UpdateUserForm() ;
         $model = UpdateUserForm::getUser($id) ;
         $security = new Security() ; 
         $modelF->fname = $model->fname ;
         $modelF->lname = $model->lname ;
         $modelF->username = $model->username ;
         $modelF->email = $model->email ;
         $modelF->status = $model->status ;
         $modelF->role = $model->role ;
         $modelF->cid = $model->cid ; 
         $modelF->cid_hash = hash('sha256', $model->cid) ;
         $modelF->hcode = $model->hcode;   
        if ($modelF->load(Yii::$app->request->post()) && $modelF->update($id)) { 
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'modelF' => $modelF
        ]);
    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
