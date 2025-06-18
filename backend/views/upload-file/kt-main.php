<?php 
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url; 

$this->title = "upload file" ;
?>
    
    <div class="container my-5">
        <h1>Upload Data From File excel </h1>
        <?= Html::a("download template" , ['/upload-file/download-template'] , ['class' => 'btn btn-success mb-2']) ?>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-lg-12">
                <div class="card p-3">
                <?php  echo  Html::beginForm(['/upload-file/upload-file-ktmain'] , 'post' ,['enctype' => 'multipart/form-data']) ; ?>
                    <div class="input-group my-3">
                        <label class="input-group-text" for="file" >Upload Data From  File/Import Data From File</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                    </div>
                    <button type="submit" name="submit_btn" id="submit_btn" class="btn btn-primary" >Upload</button> 
                    <?php echo Html::endForm() ; ?>
                </div>

            </div>  
        </div>
    </div>