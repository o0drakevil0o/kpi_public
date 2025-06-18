<?php
use yii\helpers\Url ;
$this->title = 'โรงพยาบาลฟากท่า';
?>
<div class="site-index">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <a href="<?= Url::to(['/kt-resulte/kt-dashboard'])?>" class="text-decoration-none">
                    <div class="card btn btn-success">
                        <div class="text-center text-black">
                             <i class="fa-solid fa-house fa-5x"></i>
                             <h4 class="my-3">ระบบติดตามกองทุน</h4>
                        </div>
                    </div>
                </a>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                        <a href="<?= Url::to(['/kp-reslute/kp-select-dashboard'])?>" class="text-decoration-none">
                            <div class="card  btn btn-success">
                                <div class="text-center text-black ">
                                    <i class="fa-solid fa-gauge fa-5x"></i>
                                    <h4 class="my-3">ระบบติดตามตัวชีวัด</h4>
                                </div>
                            </div>
                        </a>
                </div>
            </div>
        </div>
</div>
