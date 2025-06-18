<?php
use yii\helpers\Url ;
use yii\grid\GridView;
// use for case not drill down standrand chart  
// use miloschuman\highcharts\Highcharts;
// use miloschuman\highcharts\HighchartsAsset;
// HighchartsAsset::register($this)->withScripts(['modules/stock', 'modules/exporting', 'modules/drilldown']);


$this->title = 'ติดตามกองทุน';

// part chart Year
$dataYear = [] ;
$dataSerial = [] ;
foreach($dataProviderYear as $key => $value){ 
    $dataYear[] = $value['bud_year'];
    // $dataYearProcess[] = intval($value['processing']) ;
    $dataYearSuccess[] = intval($value['success']) ;
    // $dataYearUnprocess[] = intval($value['unprocessing']) ;
    // $dataYearTarget[] = intval($value['target']) ;
    $dataSerial[] = [
        'type' => 'column',
        'name' => 'ผลรวมทุกกองทุน ปีงบ '.$value['bud_year'],
        'drilldown' => 'year'.$value['bud_year'],
        'data' => $dataYearSuccess,
    ] ;                               
}
// part chart month 

?>
    <div class="container">
         <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card p-5"><div id="chartSumation"></div></div>
                   </div>
              </div>
        </div>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>  

<script>
    $(`#chartSumation`).highcharts({ 
        title: {
            text: 'กองทุน'
        },
        xAxis: {
            // type: 'category'
            categories:<?=json_encode($dataYear)?>

        },
        legend: {
            enabled: false
        },

        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                }
            }
        },

        series: <?= json_encode($dataSerial)?> , 
        drilldown: {
            
        }
    })
</script>        

