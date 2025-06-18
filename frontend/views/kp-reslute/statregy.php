<?php 
 use yii\helpers\Url; 
 $this->title = "ตัวชี้วัดแยกตามยุทธศาสตร์" ; 
 echo '<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />';
?>


<?php if(empty($datastatregy)) { ?> 
        <div class="container">
            <div class="row">
                <div class="col-12">
                        <div class="card my-3">
                            <div class="card-body">
                                <h3>ไม่พบข้อมูล</h3>
                            </div>
                    </div>
                </div>
            </div>
        </div>
<?php }else{?>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                 <div class="table-responsive">
                    <table class="table table-secondary" id="table-stat">
                        <thead> 
                             <tr> 
                                <td>ลำดับ</td>
                                <td>ชื่อตัวชี้วัด</td>
                                <td>ยุทธศาสตร์</td>
                             </tr>
                        </thead>
                        <tbody> 
                            <?php foreach($datastatregy as $key  => $value) {  ?> 
                              <tr>
                                <td><?= $key+1 ?></td>
                                <td><a href="<?= Url::to(['kp-reslute/kp-dashboard-detail' 
                                , "year" => $value['budyear']  
                                , "level" => $value['type_kpi'] 
                                , "kpiid" => $value['kpi_id']
                                , "childid" => $value['child_id']
                                , "subchildid" => $value['sub_id']
                                ]) ?>" ><?= $value['tem_kpiname'] ?></a></td>
                                <td><?= $value['STRAT_NAME']  ?></td>
                              </tr>
                            <?php } ?> 
                        </tbody>
                    </table>
                 </div>
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
       let table = new DataTable('#table-stat' , { 
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
       });
</script>
<?php } ?>

