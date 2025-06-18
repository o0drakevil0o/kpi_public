<?php 
    use yii\helpers\Url;
    use yii\helpers\Html;
    $this->title = "รายงาน" ; 
?>
    <div class="container">
        <div class="row">
             <?php if(count($dataTable) >= 3){foreach($dataTable as $key => $value) {?> 
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">    
                    <div class="card">
                        <div id="high-chart-<?= $key ?>"></div>
                    </div>       
                </div>
            <?php } ?>  
          </div>
          <?php if(intval($dataStragic[0]['stratetgic'] != 0 && $dataStragic[0]['stratetgic'] != null))  {?>
          <div class="row my-3">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                             <div class="row">
                                <?php  for($i = 0 ; $i < 4 ; $i++){ 
                                        if(intval($dataStragic[$i]['stratetgic']) != 0){
                                ?>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-3">
                                        <div class="card">
                                                <div class="card-header">
                                                     <h6>ประจำปีงบ<?= ' '.$dataStragic[$i]['BUDYEAR_NAME'] ?></h6>
                                                </div>
                                                <div class="card-body bg-primary text-white ">
                                                    <h5 class="card-title"><?= number_format($dataStragic[$i]['percent'] , 2) ?></h5>
                                                    <p class="card-text">ร้อยละตัวชี้วัดที่ตัวชี้วัดตามแผนยุทธศาสตร์ <?= $dataStragic[$i]['stratetgic'] ?></p>
                                                </div>
                                                <div class="card-footer">
                                                <?=  Html::a("View Details" , ['kp-reslute/kp-statregy' , 'level' => $_GET['level'] , 'year' => $dataStragic[$i]['BUDYEAR_ID'] ,'statregy' => $dataStragic[$i]['stratetgic'] ]) ?>
                                                </div>
                                        </div>
                                     </div>
                                 <?php }} ?>
                            </div>
                 </div>
                 <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                             <div class="row">
                                <?php  for($i = 4 ; $i < 8 ; $i++){ 
                                        if(intval($dataStragic[$i]['stratetgic']) != 0){
                                ?>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-3">
                                        <div class="card">
                                                <div class="card-header">
                                                     <h6>ประจำปีงบ<?= ' '.$dataStragic[$i]['BUDYEAR_NAME'] ?></h6>
                                                </div>
                                                <div class="card-body bg-primary text-white ">
                                                    <h5 class="card-title"><?= number_format($dataStragic[$i]['percent'] , 2) ?></h5>
                                                    <p class="card-text">ร้อยละตัวชี้วัดที่ตัวชี้วัดตามแผนยุทธศาสตร์ <?= $dataStragic[$i]['stratetgic'] ?></p>
                                                </div>
                                                <div class="card-footer">
                                                        <?=  Html::a("View Details" , ['kp-reslute/kp-statregy' , 'level' => $_GET['level'] , 'year' => $dataStragic[$i]['BUDYEAR_ID'] ,'statregy' => $dataStragic[$i]['stratetgic'] ]) ?>
                                                </div>
                                        </div>
                                     </div>
                                 <?php }} ?>
                            </div>
                 </div>
                 <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                             <div class="row">
                                <?php  for($i = 8 ; $i < 12 ; $i++){ 
                                        if(intval($dataStragic[$i]['stratetgic']) != 0){
                                ?>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-3">
                                        <div class="card">
                                                <div class="card-header">
                                                     <h6>ประจำปีงบ<?= ' '.$dataStragic[$i]['BUDYEAR_NAME'] ?></h6>
                                                </div>
                                                <div class="card-body bg-primary text-white ">
                                                    <h5 class="card-title"><?= number_format($dataStragic[$i]['percent'] , 2) ?></h5>
                                                    <p class="card-text">ร้อยละตัวชี้วัดที่ตัวชี้วัดตามแผนยุทธศาสตร์ <?= $dataStragic[$i]['stratetgic'] ?></p>
                                                </div>
                                                <div class="card-footer">
                                                <?=  Html::a("View Details" , ['kp-reslute/kp-statregy' , 'level' => $_GET['level'] , 'year' => $dataStragic[$i]['BUDYEAR_ID'] ,'statregy' => $dataStragic[$i]['stratetgic'] ]) ?>   
                                                </div>
                                        </div>
                                    </div>
                                 <?php }} ?>
                            </div>
                 </div>
          </div>
          <?php } ?>
          <div class="row my-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                          <div id="bar-chart-kpi"></div>
                    </div>
                </div>
          </div>
          <?php }else { ?>
                <div class="row my-3">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card p-5">
                            <div id="No-data-respone" class="text-center">ไม่พบช้อมูล หรือ ข้อมูลไม่ครบสามปี</div>
                        </div>
                    </div>
                </div>
             <?php  } ?>
    </div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    let dataType = [];
    dataType = JSON.parse(`<?= json_encode($dataTable) ?>`) ;
    let DataBar = [];
    if(dataType.length >= 3){ 
        dataType.forEach((value , key) => { 
        let SumKPI = parseInt(value.sum_pass) + parseInt(value.sum_not_pass) + parseInt(value.not_have_condition) + parseInt(value.Working) ;
        let SumRange = (parseInt(value.sum_pass)/SumKPI)*100; 
        let SumPercise =  parseFloat(SumRange.toFixed(2))
        console.log(SumPercise)
        DataBar[key] = [value.BUDYEAR_NAME, parseInt(value.sum_pass) , parseInt(value.sum_not_pass) , parseInt(value.not_have_condition) , parseInt(value.Working)] ; 
        const gaugeOptions = {
                        chart: {
                            type: 'solidgauge'
                        },

                        title: {
                            text: `ตัวชี้วัดที่ผ่านเกณฑ์ประจำปีงบ ${value.BUDYEAR_NAME}`
                        },

                        pane: {
                            center: ['50%', '85%'],
                            size: '100%',
                            startAngle: -90,
                            endAngle: 90,
                            background: {
                                backgroundColor:
                                    Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
                                innerRadius: '60%',
                                outerRadius: '100%',
                                shape: 'arc'
                            }
                        },

                        exporting: {
                            enabled: false
                        },

                        tooltip: {
                            enabled: false
                        },

                        // the value axis
                        yAxis: {
                            stops: [
                                [80, '#55BF3B'], // green
                                [50, '#DDDF0D'], // yellow
                                [10, '#DF5353'] // red
                            ],
                            lineWidth: 0,
                            tickWidth: 0,
                            minorTickInterval: null,
                            tickAmount: 2,
                            title: {
                                y: -70
                            },
                            labels: {
                                y: 16
                            }
                        },

                        plotOptions: {
                            solidgauge: {
                                dataLabels: {
                                    y: 5,
                                    borderWidth: 0,
                                    useHTML: true
                                }
                            }
                        },
                        responsive: {  
                            rules: [{  
                                condition: {  
                                maxWidth: 500  
                                },  
                                chartOptions: {  
                                legend: {  
                                    enabled: false  
                                }  
                                }  
                            }]  
                            }
                    };
            const chartSpeed = Highcharts.chart(`high-chart-${key}`, Highcharts.merge(gaugeOptions, {
                yAxis: {
                    min: 0,
                    max: 100,
                },

                credits: {
                    enabled: false
                },

                series: [{
                    name: `ตัวชี้วัดที่ผ่านเกณฑ์ประจำปีงบ ${value.BUDYEAR_NAME}`,
                    data: [SumPercise],
                    dataLabels: {
                            format:
                                    '<div style="text-align:center">' +
                                    '<span style="font-size:25px">{y}</span><br/>' +
                                    '<span style="font-size:12px;opacity:0.4">ร้อยละ (%)</span>' +
                                    '</div>'
                    },
                    tooltip: {
                        valueSuffix: ' %'
                    }
                }]

            }));
        }) ;
            Highcharts.chart('bar-chart-kpi', {
            chart: {
                type: 'column'
            },
            title: {
                text: `แผนภูมิแท่งเปรียบเทียบตัวชีั้วัด ปีงบประมาณ ${DataBar[0][0]} - ${DataBar[2][0]} `,
                align: 'center'
            },
            xAxis: {
                categories: [DataBar[0][0], DataBar[1][0], DataBar[2][0]],
                crosshair: true,
                accessibility: {
                    description: 'ปีงบประมาณ'
                }
            },
            yAxis: {
                min: 0,
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                {
                    name: 'จำนวนตัวชี้วัดที่ผ่านเกณฑ์',
                    data: [
                      {y:DataBar[0][1] , color:"#00FF00"}
                    , {y:DataBar[1][1] , color:"#00FF00"}
                    , {y:DataBar[2][1], color:"#00FF00"}
                    ],
                },
                {
                    name: 'จำนวนตัวชี้วัดที่ไม่ผ่านเกณฑ์',
                    data: [
                      {y:DataBar[0][2] , color:"#fc0324"}
                    , {y:DataBar[1][2] , color:"#fc0324"}
                    , {y:DataBar[2][2], color:"#fc0324"}
                    ]
                },
                {
                    name: 'จำนวนตัวชี้วัดที่กำลังดำเนินการ',
                    data: [
                          {y:DataBar[0][4] , color:"#ff8000"}
                        , {y:DataBar[1][4] , color:"#ff8000"}
                        , {y:DataBar[2][4] , color:"#ff8000"}
                    ],
                },
                {
                    name: 'จำนวนตัวชี้วัดที่ไม่มีการประเมินผล',
                    data: [
                          {y:DataBar[0][3] , color:"#8e9191"}
                        , {y:DataBar[1][3] , color:"#8e9191"}
                        , {y:DataBar[2][3] , color:"#8e9191"}
                    ]
                    ,
                },
            ]
        });
    }
</script>