<?php
use yii\helpers\Html;


$this->title = 'Management';
?>
<div class="site-index">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 6 col-lg-4 col-xl-4 col-xxl-4">
                    <div class="card">
                            <div class="card-header">
                                    <h4>จัดการผู้ใช้งาน</h4>
                            </div>
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col"><?= Html::a("จัดการผู้ใช้" ,['/user-manage/'] ,  ["class" => "btn btn-primary w-100"]) ?></div>
                                        <div class="col"><?= Html::a("สมัครสมาชิก" ,['/site/signup'] ,  ["class" => "btn btn-success w-100"]) ?></div>
                                    </div>
                            </div>  
                    </div>
            </div>  
            <div class="col-12 col-sm-12 6 col-lg-4 col-xl-4 col-xxl-4">
                    <div class="card">
                            <div class="card-header"> <h4>จัดการระบบกองทุน</h4>  </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12"><?= Html::a("ตั้งค่าปีงบประมาณ" ,['/kt-budyear/'] ,  ["class" => "btn  btn-block btn-primary mt-2 w-100"]) ?> </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12"><?= Html::a("ตั้งค่ากองทุน" ,['/kt-main/'] ,  ["class" => "btn btn-block btn-primary mt-2 w-100"]) ?> </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12"><?= Html::a("ตั้งค่าเดือน" ,['/kt-month/'] ,  ["class" => "btn btn-block btn-primary mt-2 w-100"]) ?> </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12"><?= Html::a("ตั้งค่าปี" ,['/kt-year/'] ,  ["class" => "btn btn-block btn-primary mt-2 w-100"]) ?> </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12"><?= Html::a("นำเข้าข้อมูลกองทุน" ,['/upload-file/'] ,  ["class" => "btn btn-block btn-primary mt-2 w-100"]) ?> </div>
                                </div>
                            </div>
                    </div>      
            </div>  
            <div class="col-12 col-sm-12 6 col-lg-4 col-xl-4 col-xxl-4">
            <div class="card">
                            <div class="card-header"> <h4>จัดการระบบติดตามตัวชี้วัด</h4>  </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12"><?= Html::a("นำเข้าข้อมูลตัวชี้วัด" ,['/upload-file/index-kpi'] ,  ["class" => "btn btn-block btn-primary mt-2 w-100"]) ?> </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12"><?= Html::a("แก้ไข้ข้อมูลตัวชี้วัด" ,['/kp-kpi/index'] ,  ["class" => "btn btn-block btn-primary mt-2 w-100"]) ?> </div>
                                </div>
                            </div>
                    </div>      
            </div>  
        </div>
    </div>
</div>
