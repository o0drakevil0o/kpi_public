<?php
use yii\helpers\Url ;
$this->title = 'เลือกรายงานตัวชี้วัด';
?>
<div class="container">
    <div class="row">
        <?php foreach($levelKpi as $key => $value) { if(intval($value['typelevel_id']) == 1){?>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-3">
                         <a href="<?= Url::to(['/kp-reslute/kp-dashboard-service' , 'level' => $value['typelevel_id']])?>" class="text-decoration-none">
                            <div class="card  btn btn-success">
                                <div class="text-center text-black ">
                                    <i class="fa-solid fa-gauge fa-5x"></i>
                                    <h4 class="my-3">ระบบติดตามตัวชีวัด <?= $value['typelevel_name'] ?></h4>
                                </div>
                            </div>
                        </a>
                </div>
        <?php }else { ?>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-3">
                         <a href="<?= Url::to(['/kp-reslute/kp-dashboard' , 'level' => $value['typelevel_id']])?>" class="text-decoration-none">
                            <div class="card  btn btn-success">
                                <div class="text-center text-black ">
                                    <i class="fa-solid fa-gauge fa-5x"></i>
                                    <h4 class="my-3">ระบบติดตามตัวชีวัด <?= $value['typelevel_name'] ?></h4>
                                </div>
                            </div>
                        </a>
                </div>
       <?php }} ?>
    </div>
</div>