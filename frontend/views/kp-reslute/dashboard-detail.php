<?php 
use yii\helpers\Url;
use app\models\KpMonth ;

if(!empty($datadetail)){
    $this->title  = "รายงานตัวชี้วัด" . $datadetail[0]['name'] ; 
}else{ 
    $this->title = 'ไม่พบข้อมูล' ;
}
echo '<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />';
$dataHcode = \Yii::$app->db->createCommand("SELECT * FROM kp_hcode")->queryAll() ;
?>
<?php  if(!empty($datadetail)) { ?>
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <?php    $level = \Yii::$app->getRequest()->getQueryParam('level'); 
                     $year = \Yii::$app->getRequest()->getQueryParam('year');
                     $kpiid = \Yii::$app->getRequest()->getQueryParam('kpiid');
                     $childid = \Yii::$app->getRequest()->getQueryParam('childid');
                     $subchildid = \Yii::$app->getRequest()->getQueryParam('subchildid');
                     $hcode = \Yii::$app->getRequest()->getQueryParam('hcode');
                    $data = [
                          "year" => $year  
                        , "level" => $level 
                        , "kpiid" => $kpiid 
                        , "childid" => $childid 
                        , "subchildid" => $subchildid
                        ] ;
            
            if($level == 2) {  ?>
             <select class="form-select" aria-label="Select Hcode" id="hcode-select" name="selectHcode">
                <?php 
               
                    foreach($dataHcode as $key =>$value ) {
                        if($key == 0) { 
                            if(empty($hcode) && $hcode == $value['hcode']){ 
                                echo '<option selected value=" '.$value["hcode"] .'">'.$value["hname"] .'</option>' ;
                            }else{ 
                                echo '<option  value=" '.$value["hcode"] .'">'.$value["hname"] .'</option>' ;
                            }
                        }
                        else{ 
                            if($hcode == $value['hcode']){ 
                                echo '<option selected value=" '.$value["hcode"] .'">'.$value["hname"] .'</option>' ;
                            }else{ 
                                echo '<option  value=" '.$value["hcode"] .'">'.$value["hname"] .'</option>' ;
                            }
                            
                        }
                    }
                ?>
            </select>
            <?php  } ?>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div id="bar-chart"></div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="table-responsive">
                <table class="table" id="table-detail-result">
                    <thead>
                        <tr>
                            <td>ลำดับ</td>
                            <td>ชื่อ</td>
                            <td>ครั้งที่ส่ง/เดือน</td>
                            <?php if($level == 2){ ?>
                            <td>สถานบริการ</td>
                            <?php } ?>
                            <td><?= empty($datadetail[0]['dic_a'])?'ไม่มี A':'A' ?></td>
                            <td><?= empty($datadetail[0]['dic_b'])?'ไม่มี B':'B' ?></td>
                            <td><?= empty($datadetail[0]['dic_c'])?'ไม่มี C':'C' ?></td>
                            <td><?= empty($datadetail[0]['dic_d'])?'ไม่มี D':'D' ?></td>
                            <td>ผล</td>
                            <td>เงื่อนไข</td>
                            <td>เป้าหมาย</td>
                            <td>ผลประเมิน</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                        $dataBarY = [] ; 
                        $dataBarX = [];
                        $datatarget = "" ;
                        foreach($datadetail as $key => $value) { 
                            $sendTypeText = " " ;
                            $dataBarY[] = $value['result'] != 'ผ่าน' ? intval($value['reslut_total']):100;
                            $datatarget = $value['min_traget'] != 'ผ่าน' ? intval($value['min_traget']):100 ;
                            if(intval($value['send_type']) == 1){ 
                                if(!empty($value['count']) || !is_null($value['count'])){
                                    $dataMonth  = KpMonth::find()->where(['month_id' => $value['count']])->asArray()->all() ;
                                    if(!empty($dataMonth)){
                                        $sendTypeText = $dataMonth[0]['month_name'];
                                        $dataBarX[] = $dataMonth[0]['month_name'];
                                    }
                                }
                            }
                            else if(intval($value['send_type']) == 2 ){ 
                                $sendTypeText = "ไตรมาส ".$value['count'];
                                $dataBarX[] = "ไตรมาส ".$value['count'];
                            }
                            else if(intval($value['send_type']) == 3 ){ 
                                $sendTypeText = "ครั้งที่ ".$value['count'];
                                $dataBarX[] = "ครั้งที่ ".$value['count'];
                            }
                            else if(intval($value['send_type']) == 4 ){ 
                                $sendTypeText = "ครั้งที่ ".$value['count'];
                                $dataBarX[] = "ครั้งที่ ".$value['count'];
                            }       
                        ?>
                        <tr>
                            <td><?= $key +1 ?></td>
                            <td><?= $value['name'] ?></td>
                            <td><?= $sendTypeText?></td>
                            <?php if($level == 2){ ?>
                                <td><?= $value["hname"]?></td>
                            <?php } ?>
                            <td><?= $value['value_a'] ?></td>
                            <td><?= $value['value_b'] ?></td>
                            <td><?= $value['value_c'] ?></td>
                            <td><?= $value['value_d'] ?></td>
                            <td><?= $value['reslut_total'] ?></td>
                            <td><?= $value['condition']?></td>
                            <td><?= $value['min_traget'] ?></td>
                            <td><?= $value['PASS_CHECK'] == 1 ? '<span class="badge bg-success" >ผ่านเกณฑ์</span>' : '<span class="badge bg-danger" >ไม่ผ่านเกณฑ์</span>'?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-xl-12 col-lg-12 my-3">
                <p>คำอธิบายตัวแปร A : <?= $datadetail[0]['dic_a']?></p>
                <p>คำอธิบายตัวแปร B : <?= $datadetail[0]['dic_b']?></p>
                <?php if(!empty($datadetail[0]['dic_c'])) {?> <p>คำอธิบายตัวแปร C : <?= $datadetail[0]['dic_c']  ?> </p> <?php }  ?>
                <?php if(!empty($datadetail[0]['dic_d'])) {?> <p>คำอธิบายตัวแปร C : <?= $datadetail[0]['dic_d']  ?> </p> <?php }  ?>
                <!-- <p>สูตรการคำนวณ : <?= $datadetail[0]['cal']?></p> -->
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<!-- Data Tavle -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

<script>
       let table = new DataTable('#table-detail-result' , { 
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
       });
       Highcharts.chart('bar-chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'ผลการดำเนินการ',
                align: 'center'
            },
            xAxis: {
                categories: <?= json_encode($dataBarX)?> ,
                crosshair: true,
                accessibility: {
                    description: 'Countries'
                }
            },
            yAxis: {
                min: 0,
                plotLines: [{
                    value: <?= intval($datatarget) ?>, //if value far excedes value of highest column axis doesn't adjust
                    color: 'red',
                    legend: {
                    enabled: false
                    },           
                    width: 2,
                    zIndex: 4,
                    dashStyle: 'longdash',
                    label: {
                        text: 'เป้าหมาย',
                        style: {
                        color: 'red',
                        fontWeight: 'bold',
                        },
                        
                        align: 'right',
                        x: -10 //pulls in to align 10px from right
                    }
                 }]  
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                {
                    name: 'ผลการดำเนินการ',
                    data: <?= json_encode($dataBarY)?>
                },
            
            ]
        });

</script>
<?php if($level == 2){ ?>
    <script>
            $(`#hcode-select`).on("change" , (e) => { 
                const hcode = $("#hcode-select").val();
                let url = new URL(window.location.href);
                url.searchParams.set("hcode", hcode);
                console.log(url.toString()); 
                window.location.href = url.toString(); 
            })
    </script>
<?php } ?>

<?php } else{  ?>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <p><h2 class="text-center">ไม่พบข้อมูล</h2></p>
                        </div>
                    </div>
                </div>
            </div>
<?php } ?>


