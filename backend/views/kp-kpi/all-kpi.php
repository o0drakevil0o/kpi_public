<?php 
   use \yii\helpers\Html ;
   use yii\helpers\ArrayHelper; 
   use yii\helpers\Url;


   $this->title = "แก้ไข้ข้อมูลตัวชี้วัด" ;

   echo '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />' ; // echo css 
   echo '<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" /> ';
?>

<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card p-5">
                    <div class="row">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <select id="bud_select" class="form-select" name="bud_select">
                                        <option value="0" selected="selected">เลือกปีงบประมาณ</option>
                                        <?php foreach($dataBudYear as $key => $value){  ?>
                                                <option value="<?php echo $value["BUDYEAR_ID"] ; ?>"><?php echo $value['BUDYEAR_NAME'] ;?> </option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <select id="level_select" class="form-select" name="level_select">
                                        <option value="0" selected="selected">ระดับตัวชี้้วัด</option>
                                        <?php foreach($dataKpiLevel as $key => $value){  ?>
                                                <option value="<?php echo $value["typelevel_id"] ; ?>"><?php echo $value['typelevel_name'] ;?> </option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-3">
                                <button type="submit" class="btn btn-primary w-100" name="btn_search" id="btn_search">ค้นหา</button>
                            </div>
                        </div>
                        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken)?>
                    </form>
                    </div>
                </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="table-responsive">
                  <table class="table table-borderless table-light table-hover" id="table-kpi"> 
                          <thead> 
                                <tr> 
                                    <td>ลำดับ</td>
                                    <td>แผน/ประเภทตัวชี้วัด</td>
                                    <td>ชือตัวชี้วัด</td>
                                    <td>ปีงบประมาณ</td>
                                    <td>ประเภทการส่งข้อมูล</td>
                                    <td>Ref</td>
                                </tr>        
                          </thead>
                          <tbody> 
                              <?php foreach($dataKpi as $key => $value) {   ?> 
                                <tr> 
                                    <td><?= $key+1 ?></td>
                                    <td><?= $value['plan_duaration_name']?></td>
                                    <td><?= $value['tem_kpiname']?></td>
                                    <td><?= $value['BUDYEAR_NAME']?></td>
                                    <td><?= $value['name']?></td>
                                    <td><?= $value['id']?></td>
                                </tr>  
                               <?php } ?>    
                          </tbody>
                  </table>
              </div>                                   
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal modal-xl fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">แก้ไข้ข้อมูลตัวชี้วัด</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                         <ul class="nav nav-tabs" id="tab-quarter" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-kpi-link" data-bs-toggle="tab" data-bs-target="#tab-kpi-content" type="button" role="tab" aria-controls="tab-kpi-content" aria-selected="true">ตัวชี้วัดหลัก</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-child-link" data-bs-toggle="tab" data-bs-target="#tab-child-content" type="button" role="tab" aria-controls="tab-child-content" aria-selected="false">ตัวชี้วัดรอง</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-subchild-link" data-bs-toggle="tab" data-bs-target="#tab-subchild-content" type="button" role="tab" aria-controls="tab-subchild-content" aria-selected="false">ตัวชี้วัดย่อย</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-template-link" data-bs-toggle="tab" data-bs-target="#tab-template-content" type="button" role="tab" aria-controls="tab-template-content" aria-selected="false">รายละเอียดตัวชี้วัด</button>
                            </li>
                        </ul>  
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab-kpi-content" role="tabpanel" aria-labelledby="tab-kpi-content">
                                <form action="" method="post" id="form-save-kpi">
                                        <div class="my-3">
                                            <label for="" class="form-label">ชื่อตัวชี้วัด</label>
                                            <input type="text" class="form-control" name="kpi_name" id="kpi_name" aria-describedby="helpId" placeholder="กรุณาใส่ชื่อ" require/>
                                            <small id="helpId" class="form-text text-muted"></small>
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">ยุทธศาสตร์</label>
                                                <select class="form-select" name="kpi_stratetgic" id="kpi_stratetgic">
                                                    <option value="0">เลือกยุทธศาสตร์</option>
                                                    <?php foreach($dataStatergic as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['STRAT_ID'] ?>" id="kpi_strat_<?= $value['STRAT_ID']?>"><?= $value['STRAT_NAME'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">เป้าหมาย</label>
                                                <select class="form-select" name="kpi_goal" id="kpi_goal">
                                                    <option value="0">เลือกเป้าหมาย</option>
                                                    <?php foreach($dataGoal as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['GOAL_ID'] ?>" id="kpi_goal_<?= $value['GOAL_ID']?>"><?= $value['GOAL_NAME'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">โครงการ</label>
                                                <select class="form-select" name="kpi_project" id="kpi_project">
                                                    <option value="0">เลือกโครงการ</option>
                                                    <?php foreach($dataProject as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['P_id'] ?>" id="kpi_project_<?= $value['P_id']?>"><?= $value['P_name'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">ปีงบประมาณ</label>
                                                <select class="form-select" name="kpi_year" id="kpi_year">
                                                    <option value="0">เลือกปีงบประมาณ</option>
                                                    <?php foreach($dataBudYear as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['BUDYEAR_ID'] ?>" id="kpi_year_<?= $value['BUDYEAR_ID']?>"><?= $value['BUDYEAR_NAME'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">ระดับตัวชี้วัด</label>
                                                <select class="form-select" name="kpi_level" id="kpi_level">
                                                    <option value="0">เลือกระดับตัวชี้วัด</option>
                                                    <?php foreach($dataKpiLevel as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['typelevel_id'] ?>" id="kpi_level_<?= $value['typelevel_id']?>"><?= $value['typelevel_name'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">ผู้รับผิดชอบ</label>
                                                <select class="form-select" name="kpi_manager" id="kpi_manager">
                                                    <option value="0">เลือกผู้รับผิดชอบ</option>
                                                    <?php foreach($dataUser as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['id'] ?>" id="kpi_manager_<?= $value['id']?>"><?= $value['fname'].' '.$value['lname'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                            <label for="" class="form-label">ค่าน้ำหนักตัวชี้วัด</label>
                                            <input type="number" class="form-control" name="kpi_weight" id="kpi_weight" aria-describedby="helpId" placeholder="กรุณาใส่ค่าน้ำหนัก" require/>
                                            <small id="helpId" class="form-text text-muted"></small>
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">แผนยุทธศาสตร์</label>
                                                <select class="form-select" name="kpi_plan" id="kpi_plan">
                                                    <option value="0" id="kpi_plan_0">ไม่มีแผนยุทธศาสตร์</option>
                                                    <?php foreach($dataPlanDuration as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['id'] ?>" id="kpi_plan_<?= $value['id']?>"><?= $value['plan_name'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <button type="submit" name="btn-submit-form-kpi" id="btn-submit-form-kpi" class="btn btn-primary w-100">บันทึก</button>     
                                </form>
                            </div>
                            <div class="tab-pane fade show" id="tab-child-content" role="tabpanel" aria-labelledby="tab-child-content">
                                   <form action="" method="post" id="form-save-child">
                                        <div class="my-3">
                                            <label for="" class="form-label">ชื่อตัวชี้วัด</label>
                                            <input type="text" class="form-control" name="child_name" id="child_name" aria-describedby="helpId" placeholder="กรุณาใส่ชื่อ" require/>
                                            <small id="helpId" class="form-text text-muted"></small>
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">ยุทธศาสตร์</label>
                                                <select class="form-select" name="child_stratetgic" id="child_stratetgic">
                                                    <option value="0">เลือกยุทธศาสตร์</option>
                                                    <?php foreach($dataStatergic as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['STRAT_ID'] ?>" id="child_strat_<?= $value['STRAT_ID']?>"><?= $value['STRAT_NAME'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">เป้าหมาย</label>
                                                <select class="form-select" name="child_goal" id="child_goal">
                                                    <option value="0">เลือกเป้าหมาย</option>
                                                    <?php foreach($dataGoal as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['GOAL_ID'] ?>" id="child_goal_<?= $value['GOAL_ID']?>"><?= $value['GOAL_NAME'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">โครงการ</label>
                                                <select class="form-select" name="child_project" id="child_project">
                                                    <option value="0">เลือกโครงการ</option>
                                                    <?php foreach($dataProject as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['P_id'] ?>" id="child_project_<?= $value['P_id']?>"><?= $value['P_name'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">ปีงบประมาณ</label>
                                                <select class="form-select" name="child_year" id="child_year">
                                                    <option value="0">เลือกปีงบประมาณ</option>
                                                    <?php foreach($dataBudYear as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['BUDYEAR_ID'] ?>" id="child_year_<?= $value['BUDYEAR_ID']?>"><?= $value['BUDYEAR_NAME'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">ระดับตัวชี้วัด</label>
                                                <select class="form-select" name="child_level" id="child_level">
                                                    <option value="0">เลือกระดับตัวชี้วัด</option>
                                                    <?php foreach($dataKpiLevel as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['typelevel_id'] ?>" id="child_level_<?= $value['typelevel_id']?>"><?= $value['typelevel_name'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">ผู้รับผิดชอบ</label>
                                                <select class="form-select" name="child_manager" id="child_manager">
                                                    <option value="0">เลือกผู้รับผิดชอบ</option>
                                                    <?php foreach($dataUser as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['id'] ?>" id="child_manager_<?= $value['id']?>"><?= $value['fname'].' '.$value['lname'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                            <label for="" class="form-label">ค่าน้ำหนักตัวชี้วัด</label>
                                            <input type="number" class="form-control" name="child_weight" id="child_weight" aria-describedby="helpId" placeholder="กรุณาใส่ค่าน้ำหนัก" require/>
                                            <small id="helpId" class="form-text text-muted"></small>
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">แผนยุทธศาสตร์</label>
                                                <select class="form-select" name="child_plan" id="child_plan">
                                                    <option value="0" id="child_plan_0">ไม่มีแผนยุทธศาสตร์</option>
                                                    <?php foreach($dataPlanDuration as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['id'] ?>" id="child_plan_<?= $value['id']?>"><?= $value['plan_name'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <button type="submit" name="btn-submit-form-child" id="btn-submit-form-child" class="btn btn-primary w-100">บันทึก</button>     
                                   </form>                      
                            </div>
                            <div class="tab-pane fade show" id="tab-subchild-content" role="tabpanel" aria-labelledby="tab-subchild-content">
                            <form action="" method="post" id="form-save-subchild">
                                        <div class="my-3">
                                            <label for="" class="form-label">ชื่อตัวชี้วัด</label>
                                            <input type="text" class="form-control" name="subchild_name" id="subchild_name" aria-describedby="helpId" placeholder="กรุณาใส่ชื่อ" require/>
                                            <small id="helpId" class="form-text text-muted"></small>
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">ยุทธศาสตร์</label>
                                                <select class="form-select" name="subchild_stratetgic" id="subchild_stratetgic">
                                                    <option value="0">เลือกยุทธศาสตร์</option>
                                                    <?php foreach($dataStatergic as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['STRAT_ID'] ?>" id="subchild_strat_<?= $value['STRAT_ID']?>"><?= $value['STRAT_NAME'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">เป้าหมาย</label>
                                                <select class="form-select" name="subchild_goal" id="subchild_goal">
                                                    <option value="0">เลือกเป้าหมาย</option>
                                                    <?php foreach($dataGoal as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['GOAL_ID'] ?>" id="subchild_goal_<?= $value['GOAL_ID']?>"><?= $value['GOAL_NAME'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">โครงการ</label>
                                                <select class="form-select" name="subchild_project" id="subchild_project">
                                                    <option value="0">เลือกโครงการ</option>
                                                    <?php foreach($dataProject as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['P_id'] ?>" id="subchild_project_<?= $value['P_id']?>"><?= $value['P_name'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">ปีงบประมาณ</label>
                                                <select class="form-select" name="subchild_year" id="subchild_year">
                                                    <option value="0">เลือกปีงบประมาณ</option>
                                                    <?php foreach($dataBudYear as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['BUDYEAR_ID'] ?>" id="subchild_year_<?= $value['BUDYEAR_ID']?>"><?= $value['BUDYEAR_NAME'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">ระดับตัวชี้วัด</label>
                                                <select class="form-select" name="subchild_level" id="subchild_level">
                                                    <option value="0">เลือกระดับตัวชี้วัด</option>
                                                    <?php foreach($dataKpiLevel as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['typelevel_id'] ?>" id="subchild_level_<?= $value['typelevel_id']?>"><?= $value['typelevel_name'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">ผู้รับผิดชอบ</label>
                                                <select class="form-select" name="subchild_manager" id="subchild_manager">
                                                    <option value="0">เลือกผู้รับผิดชอบ</option>
                                                    <?php foreach($dataUser as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['id'] ?>" id="subchild_manager_<?= $value['id']?>"><?= $value['fname'].' '.$value['lname'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <div class="my-3">
                                            <label for="" class="form-label">ค่าน้ำหนักตัวชี้วัด</label>
                                            <input type="number" class="form-control" name="subchild_weight" id="subchild_weight" aria-describedby="helpId" placeholder="กรุณาใส่ค่าน้ำหนัก" require/>
                                            <small id="helpId" class="form-text text-muted"></small>
                                        </div>
                                        <div class="my-3">
                                                <label for="" class="form-label">แผนยุทธศาสตร์</label>
                                                <select class="form-select" name="subchild_plan" id="subchild_plan">
                                                    <option value="0" id="child_plan_0">ไม่มีแผนยุทธศาสตร์</option>
                                                    <?php foreach($dataPlanDuration as $key => $value){  ?>
                                                        <option value ="<?php  echo $value['id'] ?>" id="subchild_plan_<?= $value['id']?>"><?= $value['plan_name'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                        <button type="submit" name="btn-submit-form-subchild" id="btn-submit-form-subchild" class="btn btn-primary w-100">บันทึก</button>     
                                   </form>     
                            </div>
                            <div class="tab-pane fade show" id="tab-template-content" role="tabpanel" aria-labelledby="tab-template-content">

                            </div>
                        </div>                 
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Data Tavle -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Math JS  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/12.0.0/math.js" integrity="sha512-rffRpOvP8/vOkbpVUpjesEh2AI40+pNcMh0LAAdOKBE96pLnJh1IGKGhu/RL5lrmW8fA9p5ph5GkCOlMNXr3eg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script> 
    $(document).ready(() => {
        let table = new DataTable('#table-kpi');
        $('#table-kpi tbody').on('click', 'tr', function() {
             data = $(this).find('td:last').text();
             if(data !== "No data available in table"){
                $(`#staticBackdrop`).modal('show');
                try{ 
                        $.ajax({ 
                        url:"<?php echo Url::to(['get-data']); ?>" , 
                        method:"post" , 
                        data:{
                            kpi_template_id: data , 
                            "<?= Yii::$app->request->csrfParam ?>" : "<?= Yii::$app->request->csrfToken ?>"
                        }
                    }).done((res) => {
                        const dataResapone = JSON.parse(res) 
                        WriteDataKpi(dataResapone)
                        WriteDataChildKpi(dataResapone)
                    })
                }catch(error){ 
                    console.log(error)
                }
                
             }
        });

        $(`#form-save-kpi`).on('submit' , (event) => {
            event.preventDefault()
        })
        $(`#form-save-child`).on('submit' , (event) => {
            event.preventDefault()
        })
        $(`#form-save-subchild`).on('submit' , (event) => {
            event.preventDefault()
        })
        $(`#form-save-template`).on('submit' , (event) => {
            event.preventDefault()
        })



    })

           const WriteDataKpi = (dataResapone) => { 
                   if(dataResapone.detail.kpi_main.length !== 0){
                            const dataKpi = { 
                                name: dataResapone.detail.kpi_main[0].name,
                                budyear: dataResapone.detail.kpi_main[0].budyear,
                                goal: dataResapone.detail.kpi_main[0].goal,
                                kpi_id: dataResapone.detail.kpi_main[0].kpi_id,
                                level_kpi: dataResapone.detail.kpi_main[0].level_kpi,
                                manager: dataResapone.detail.kpi_main[0].manager,
                                plan: dataResapone.detail.kpi_main[0].plan,
                                project: dataResapone.detail.kpi_main[0].project,
                                stratetgic: dataResapone.detail.kpi_main[0].stratetgic,
                                weight: dataResapone.detail.kpi_main[0].weight,
                            };
                            $(`#kpi_name`).val(dataKpi.name)
                            $(`#kpi_stratetgic option[id='kpi_strat_${dataKpi.stratetgic}']`).attr("selected", "selected");
                            $(`#kpi_goal option[id='kpi_goal_${dataKpi.goal}']`).attr("selected", "selected");
                            $(`#kpi_project option[id='kpi_project_${parseInt(dataKpi.project)}']`).attr("selected", "selected");
                            $(`#kpi_year option[id='kpi_year_${dataKpi.budyear}']`).attr("selected", "selected");
                            $(`#kpi_level option[id='kpi_level_${dataKpi.level_kpi}']`).attr("selected", "selected");
                            $(`#kpi_manager option[id='kpi_manager_${dataKpi.manager}']`).attr("selected", "selected");
                            $(`#kpi_weight`).val(dataKpi.weight)
                            $(`#kpi_plan option[id='kpi_plan_${dataKpi.plan}']`).attr("selected", "selected");
                        }else{ 
                            $('#form-save-kpi').empty() 
                        }
            }
            const WriteDataChildKpi  = (dataResapone) => { 
                        if(dataResapone.detail.kpi_child.length !== 0){
                            const dataKpi = { 
                                name: dataResapone.detail.kpi_child[0].name,
                                budyear: dataResapone.detail.kpi_child[0].budyear,
                                goal: dataResapone.detail.kpi_child[0].goal,
                                kpi_id: dataResapone.detail.kpi_child[0].kpi_id,
                                level_kpi: dataResapone.detail.kpi_child[0].level_kpi,
                                manager: dataResapone.detail.kpi_child[0].manager,
                                plan: dataResapone.detail.kpi_child[0].plan,
                                project: dataResapone.detail.kpi_child[0].project,
                                stratetgic: dataResapone.detail.kpi_child[0].stratetgic,
                                weight: dataResapone.detail.kpi_child[0].weight,
                            };
                            $(`#child_name`).val(dataKpi.name)
                            $(`#child_stratetgic option[id='child_strat_${dataKpi.stratetgic}']`).attr("selected", "selected");
                            $(`#child_goal option[id='child_goal_${dataKpi.goal}']`).attr("selected", "selected");
                            $(`#child_project option[id='child_project_${parseInt(dataKpi.project)}']`).attr("selected", "selected");
                            $(`#child_year option[id='child_year_${dataKpi.budyear}']`).attr("selected", "selected");
                            $(`#child_level option[id='child_level_${dataKpi.level_kpi}']`).attr("selected", "selected");
                            $(`#child_manager option[id='child_manager_${dataKpi.manager}']`).attr("selected", "selected");
                            $(`#child_weight`).val(dataKpi.weight)
                            $(`#child_plan option[id='child_plan_${dataKpi.plan}']`).attr("selected", "selected");
                        }
                        else{ 
                            $('#form-save-child').empty() 
                        }
            }
            const WriteDataSubChildKpi  = (dataResapone) => { 
                // dataSubChild
                      if(dataResapone.detail.dataSubChild.length !== 0){
                            const dataKpi = { 
                                name: dataResapone.detail.dataSubChild[0].name,
                                budyear: dataResapone.detail.dataSubChild[0].budyear,
                                goal: dataResapone.detail.dataSubChild[0].goal,
                                kpi_id: dataResapone.detail.dataSubChild[0].kpi_id,
                                level_kpi: dataResapone.detail.dataSubChild[0].level_kpi,
                                manager: dataResapone.detail.dataSubChild[0].manager,
                                plan: dataResapone.detail.dataSubChild[0].plan,
                                project: dataResapone.detail.dataSubChild[0].project,
                                stratetgic: dataResapone.detail.dataSubChild[0].stratetgic,
                                weight: dataResapone.detail.dataSubChild[0].weight,
                            };
                            $(`#subchild_name`).val(dataKpi.name)
                            $(`#subchild_stratetgic option[id='subchild_strat_${dataKpi.stratetgic}']`).attr("selected", "selected");
                            $(`#subchild_goal option[id='subchild_goal_${dataKpi.goal}']`).attr("selected", "selected");
                            $(`#subchild_project option[id='subchild_project_${parseInt(dataKpi.project)}']`).attr("selected", "selected");
                            $(`#subchild_year option[id='subchild_year_${dataKpi.budyear}']`).attr("selected", "selected");
                            $(`#subchild_level option[id='subchild_level_${dataKpi.level_kpi}']`).attr("selected", "selected");
                            $(`#subchild_manager option[id='subchild_manager_${dataKpi.manager}']`).attr("selected", "selected");
                            $(`#subchild_weight`).val(dataKpi.weight)
                            $(`#subchild_plan option[id='subchild_plan_${dataKpi.plan}']`).attr("selected", "selected");
                        }else{ 
                            $('#form-save-subchild').empty() 
                        }
            }
            const WriteDataTempleteKpi = (dataResapone) => { 

            }





</script>