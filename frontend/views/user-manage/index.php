<?php
use yii\grid\GridView;
use yii\helpers\ArrayHelper ; 
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "User Management" ; 


?>
<h1>จัดการผู้ใช้งาน</h1>
<?= 
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'fname',
                'lname', 
                'username' , 
                'email' , 
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action,  $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                     }
                ],
            ],
        ])
?>


