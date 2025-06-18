<?php

namespace frontend\controllers;

use Yii ;
use app\models\User ; 
use app\models\UserSearch ; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\UpdateUserForm ; 

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
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdateUser($id)
    {
         if(empty($id)) $id = Yii::$app->user->identity->id ;
         
         $modelF = new UpdateUserForm() ;
         $model = UpdateUserForm::getUser($id) ;
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
            return $this->redirect(['site/login']);
        }
        return $this->render('update', [
            'model' => $model,
            'modelF' => $modelF
        ]);
    }
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
