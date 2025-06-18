<?php

/** @var \yii\web\View $this */
/** @var string $content */
// use Yii ;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use \kartik\bs5dropdown\DropdownX ; 
use kartik\nav\NavX;
use yii\helpers\Url; 
use app\models\KpBudyear ; 
use app\models\KpLevelKpi ; 

AppAsset::register($this);
    $dataLinkReport = [[],[],[],[]] ;
    foreach(KpBudyear::find()->orderBy('BUDYEAR_NAME ASC')->all() as $key => $value){ 
        foreach(KpLevelKpi::find()->all() as $keyLevel => $valueLevel){ 
            $dataLinkReport[$keyLevel][] = ['label'=>'รายงาน'.$valueLevel['typelevel_name'].' '.$value['BUDYEAR_NAME'] , "url" => ['/kp-reslute/kp-dashboard-year' , 'level' => $valueLevel['typelevel_id'] , 'year' => $value['BUDYEAR_ID']]] ;
        }
    }

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <?php $this->head() ?>
    <style>
            .provider-btn {
                border: 1px solid #d1d5db;
                background-color: #ffffff;
                color: #374151;
                font-weight: 500;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                transition: all 0.3s ease;
            }

            .provider-btn:hover {
                background-color: #029c30;
                color: #374151;
            }

            .provider-btn:focus {
                box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.5);
                border-color: #3b82f6;
            }

            .provider-logo {
                height: 1.25rem;
            }

            .provider-text {
                color: #fff;
            }
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
        <?php 
             $menuItems = [
                ['label' => 'ระบบติดตามกองทุน', 'url' => ['#'] , "items" => [
                    ['label' => "เพิ่มผลการติดตามข้อมูลกองทุน" , 'url' => ['/kt-resulte/index']] 
                ]],
                ['label' => "ระบบติดตามตัวชี้วัด" , 'url' => ['#'] , "items" =>[
                    ['label' => "เพิ่มผลการทำงาน" , 'url' => ['/kp-reslute/create']],
                    ['label' => "รายงานตัวชี้วััด-ยุทธศาสตร์" , 'url' => ['#'] , 'items'=>$dataLinkReport[3]],
                    ['label' => "รายงานตัวชี้วััด-การพัฒนาคุณภาพ" , 'url' => ['#'] , 'items'=>$dataLinkReport[2]],
                    ['label' => "รายงานตัวชี้วััด-จังหวัด MOU" , 'url' => ['#'] , 'items'=>$dataLinkReport[1]] , 
                    ['label' => "รายงานตัวชี้วััด-SERVICE PLAN" , 'url' => ['#'] , 'items'=>$dataLinkReport[0]] , 
                ]]
            ];
                NavBar::begin([
                    'brandLabel' => Yii::$app->name,
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
                    ],
                ]);
       
                echo NavX::widget([
                'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0' /*"class" => 'nav nav-pills'*/],
                    'items' => $menuItems,
                ]);
                if (Yii::$app->user->isGuest) {
                    $menuisGuest[] = ['label' => "เข้าสู่ระบบ" , 'url' => ['/site/login']] ; 
                    echo Nav::widget([
                        'options' => ['class' => 'navbar-nav mx-left mb-2 mb-md-0'],
                        'items' => $menuisGuest,
                    ]);
                } else {
                    $nameUser = "คุณ".Yii::$app->user->identity->fname ; 
                    $menuisUser[] = ['label' => $nameUser , 'url' => ['/site/login'] , "items" =>[ 
                          ['label' => 'จัดการข้อมูลผู้ใช้' , 'url' =>['/user-manage/view' , 'id' => Yii::$app->user->identity->id]],
                          Html::submitButton("ออกจากระบบ", ["class" => "btn btn-link text-decoration-none text-secondary"])
                    ]] ; 
                    echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex']) ; //create form in yii type
                    echo NavX::widget([
                        'options' => ['class' => 'navbar-nav mx-left  mb-2 mb-md-0'],
                        'items' => $menuisUser,
                    ]);
                    echo Html::endForm(); // end form in yii type
                }
                
                NavBar::end();
            ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" crossorigin="anonymous"></script>
</body>
</html>
<?php $this->endPage(); ?>