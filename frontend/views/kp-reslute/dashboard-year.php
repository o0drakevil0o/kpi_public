<?php 
    use app\models\KpMonth ;
    use yii\helpers\Html ; 
    $this->title = "รายงานตัวชี้วัดประจำปี" ; 
    echo '<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />';
?>
<div class="container">
    <div class="row">
        <?php if(!empty($dataCheckPass) || !empty($dataDetailReslute)){ ?>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="card p-5">
                    <div id="bar-chart-year"></div>
                </div>
        </div>
        <div class="col-12 .col-sm-12 col-md-6 col-lg-6 col-xl-6">
             <div class="card p-5">
                 <div id="pie-chart-year"></div>
             </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card p-5 my-5">
            <div class="table-responsive">
                <table class="table table-hover talbe-secondary" id="data-kpi-talble">
                     <thead> 
                            <tr>
                                <td>ลำดับ</td>
                                <td>ชื่อตัวชี้วัด</td>
                                <td>ประเภทการส่ง</td>
                                <td>เป้าหมาย</td>
                                <td>ผล</td>
                                <td>การประเมิน</td>
                                <td>ครั้งที่ส่ง/เดือน(ล่าสุด)</td>
                            </tr>
                     </thead>
                     <tbody> 
                         <?php foreach($dataDetailReslute as $key => $value) {
                                $sendTypeText = " " ;
                                if(intval($value['send_type']) == 1 ){ 
                                    if(!empty($value['SENT_ COUNT_DATA']) || !is_null($value['SENT_ COUNT_DATA'])){
                                        $dataMonth  = KpMonth::find()->where(['month_id' => $value['SENT_ COUNT_DATA']])->asArray()->all() ;
                                        if(!empty($dataMonth)){
                                            $sendTypeText = $dataMonth[0]['month_name'];
                                        }
                                    }
                                }
                                else if(intval($value['send_type']) == 2 ){ 
                                    $sendTypeText = "ไตรมาส ".$value['SENT_ COUNT_DATA'];
                                }
                                else if(intval($value['send_type']) == 3 ){ 
                                    $sendTypeText = "ครั้งที่ ".$value['SENT_ COUNT_DATA'];
                                }
                                else if(intval($value['send_type']) == 4 ){ 
                                    $sendTypeText = "ครั้งที่ ".$value['SENT_ COUNT_DATA'];
                                }
                            ?>
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td><?= Html::a($value['tem_kpiname'],['kp-dashboard-detail' 
                                , 'year' => $value['BUDYEAR_ID'] 
                                , 'level'=> empty($value['level_id']) ? 0 :$value['level_id']
                                , 'kpiid'=> empty($value['kpi_id']) ? 0 :$value['kpi_id']
                                , 'childid'=> empty($value['child_id']) ? 0 : $value['child_id']
                                , 'subchildid'=> empty($value['sub_id']) ? 0 : $value['sub_id']
                                ])?></td>
                                <td><?= $value['send_type_name'] ?></td>
                                <td><?= $value['min_traget'] ?></td>
                                <td><?= $value['result'] ?></td>
                                <td><?php  
                                if(intval($value['PASS_CHECK']) == 1)
                                { echo '<span class="badge bg-success" >ผ่านเกณฑ์</span>' ;}
                                else if(intval($value['PASS_CHECK']) == 0)
                                {echo '<span class="badge bg-danger" >ไม่ผ่านเกณฑ์</span>'   ;} 
                                else if(!empty($value['PASS_CHECK']) && intval($value['PASS_CHECK']) != 0 )
                                { echo  '<span class="badge bg-warning" >กำลังดำเนินการ</span>';}  ?>
                                </td>
                                <td><?= $sendTypeText ?></td>
                            </tr>
                        <?php } ?>
                     </tbody>
                </table>
             </div>
            </div>
        </div>
        <?php } else { ?>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                     <p class="text-center my-3">ไม่พบข้อมูล </p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script src="http://code.highcharts.com/modules/map.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<!-- <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script> -->

<!-- Data Tavle -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

<?php if(!empty($dataCheckPass)) {?>
<script> 
    let table = new DataTable('#data-kpi-talble');
    const dataBar = [
      {name: `ผ่านเกณฑ์การประเมิน` , y:<?= intval($dataCheckPass[0]['sum_pass']) ?> , color: "#00FF00" }  ,
      {name: `ไม่ผ่านเกณฑ์การประเมิน` , y:<?= intval($dataCheckPass[0]['sum_not_pass']) ?>  , color: "#fc0324"}  ,
      {name: `กำลังดำเนินการ` , y:<?= intval($dataCheckPass[0]['Working']) ?> ,color: "#ff8000" } 
    ]
    console.log(dataBar)
    const chart = new Highcharts.Chart({
    chart: {
        renderTo: 'bar-chart-year',
        type: 'column',
        options3d: {
            enabled: true,
            alpha: 0,
            beta: 0,
            depth: 0,
            viewDistance: 10
        }
    },
    xAxis: {
        categories: ['ผ่านเกณฑ์การประเมิน', 'ไม่ผ่านเกณฑ์การประเมิน', 'กำลังดำเนินการ'/*, 'ไม่มีการประเมิน'*/]
    },
    yAxis: {
        title: {
            enabled: false
        }
    },
    tooltip: {
        headerFormat: '<b>{point.key}</b><br>',
        pointFormat: 'จำนวน: {point.y}'
    },
    title: {
        text: 'จำนวนการดำเนินการประจำปีงบ <?= $dataCheckPass[0]['BUDYEAR_NAME']?>',
        align: 'left'
    },
    legend: {
        enabled: false
    },
    plotOptions: {
        column: {
            depth: 25
        }
    },
    series: [{
        data: dataBar , 
        colorByPoint: true
    }]
});
let dataPie =  [
            { name: 'ผ่านเกณฑ์การประเมิน', y: <?= floatval($dataCheckPass[0]['pass_percent'])  ?> , color: "#00FF00" },
            { name: 'ไม่ผ่านเกณฑ์การประเมิน', y: <?= floatval($dataCheckPass[0]['not_pass_percent'])  ?> ,color: "#fc0324" },
            { name: 'กำลังดำเนินการ', y: <?= floatval($dataCheckPass[0]['Working_percent'])  ?> ,color: "#ff8000" },
            { name: 'ไม่มีการประเมิน', y: <?= floatval($dataCheckPass[0]['not_condition_percent'])   ?> ,color: "#8e9191" }
        ] ; 
Highcharts.setOptions({
    colors: Highcharts.getOptions().colors.map(function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    })
});

// Build the chart
Highcharts.chart('pie-chart-year', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'ร้อยละการดำเนินการปีงบประมาณ <?= $dataCheckPass[0]['BUDYEAR_NAME']?>'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<span style="font-size: 1.2em"><b>{point.name}</b>' +
                    '</span><br>' +
                    '<span style="opacity: 0.6">{point.percentage:.1f} ' +
                    '%</span>',
                connectorColor: 'rgba(128,128,128,0.5)'
            }
        }
    },
    series: [{
        name: 'Share',
        data: dataPie
    }]
});


</script>
<?php } ?>