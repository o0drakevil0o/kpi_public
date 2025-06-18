<?php 
    use yii\helpers\ArrayHelper; 
    use yii\helpers\Url;
    use yii\helpers\Html ;
    $this->title = "เพิ่มผลตัวชี้วัด" ;
    echo '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />' ; // echo css 
    echo '<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    ' ; // echo css 
    // show section     

    $data_month  = [] ;
    $data_success = [] ;
    foreach($dataMonth as $key => $value) { 
        $data_month[] = ['month_name' => $value["month_name"] , "id" => $value['month_id']] ;
    }
    foreach($dataSuccess as $key => $value) [
         $data_success[] = ['id' => $value['s_id'] , 'name' => $value['s_name']]
    ]
?>


<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card p-5">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <select id="bud_select" class="form-select" name="bud_select">
                                    <option value="0" selected="selected">เลือกปีงบประมาณ</option>
                                    <?php foreach($dataBudyear as $key => $value){  ?>
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
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-5" id="showInput">
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
<!-- Modal Send Type Month -->
<div id="modal-month" class="modal modal-xl fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                        <div id="kpi_name-month"  class="my-3"></div> 
                        <div id="kpi_child_name-month" class="my-3"></div>         
                        <div id="kpi_sub_name-month" class="my-3"></div>         
                        <ul class="nav nav-tabs" id="tab-month" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-add-month" data-bs-toggle="tab" data-bs-target="#tab-month-content" type="button" role="tab" aria-controls="tab-month-content" aria-selected="true">หน่วยงาน/ผู้รับชอบ</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="detail-month" data-bs-toggle="tab" data-bs-target="#detail-month-content" type="button" role="tab" aria-controls="detail-month-content" aria-selected="false">รายละเอียด</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="document-month" data-bs-toggle="tab" data-bs-target="#document-month-content" type="button" role="tab" aria-controls="document-month-content" aria-selected="false">เอกสาร</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab-month-content" role="tabpanel" aria-labelledby="tab-add-month">
                                   <div id="sup-people-month" class="my-3"></div>
                                   <div id="unit-month" class="my-3"></div>
                                   <div id="kpi-dic-tab-month" class="my-3"></div>
                                   <div id="traget-tab-month" class="my-3"></div>
                                   <div id="condition-month" class="my-3"></div>
                                   <div id="date-end-month" class="my-3"></div>
                                    <ul class="nav nav-tabs" id="tab-list-month" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="co-person-tab-month" data-bs-toggle="tab" data-bs-target="#co-person-month" type="button" role="tab" aria-controls="co-person" aria-selected="false">ผู้รับผิดชอบร่วม</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="department-tab-month" data-bs-toggle="tab" data-bs-target="#department-month" type="button" role="tab" aria-controls="department" aria-selected="false">กลุ่มงานที่รับผิดชอบ</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="team-tab-month" data-bs-toggle="tab" data-bs-target="#team-month" type="button" role="tab" aria-controls="team" aria-selected="false">ทีมที่รับผิดชอบ</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="resulte-tab-month" data-bs-toggle="tab" data-bs-target="#resulte-month" type="button" role="tab" aria-controls="resulte" aria-selected="true">ผลตัวชี้วัด</button>
                                        </li>
                                    </ul>
                                        <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade" id="co-person-month" role="tabpanel" aria-labelledby="co-person-month">
                          
                                        </div>
                                        <div class="tab-pane fade" id="department-month" role="tabpanel" aria-labelledby="department-month">
                                            <div class="container my-3">
                                                    <div class="row my-3">
                                                        <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                                        <select id="select-department-month" class="form-select" name="level_select">
                                                                <option value="0" selected="selected">กลุ่มงานที่รับผิดชอบ</option>
                                                                <?php foreach($dataDepartment as $key => $value){  ?>
                                                                        <option value="<?php echo $value["HR_DEPARTMENT_ID"] ; ?>"><?php echo $value['HR_DEPARTMENT_NAME'] ;?> </option>
                                                                <?php } ?>
                                                        </select>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                            <button type="button" name="btn-department-add-month" class=" btn btn-primary btn-department-add">เพิ่ม</button>
                                                        </div>
                                                    </div>
                                                    <div class="row department my-3"></div>
                                                </div>
                                        </div>
                                        <div class="tab-pane fade" id="team-month" role="tabpanel" aria-labelledby="team-month">
                                                <div class="container my-3">
                                                    <div class="row my-3">
                                                        <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                                        <select id="select-team-month" class="form-select" name="level_select">
                                                                <option value="0" selected="selected">ทีมที่รับผิดชอบ</option>
                                                                <?php foreach($dataTeam as $key => $value){  ?>
                                                                        <option value="<?php echo $value["HR_TEAM_ID"] ; ?>"><?php echo $value['HR_TEAM_NAME'] ;?> </option>
                                                                <?php } ?>
                                                        </select>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                             <button type="button" name="btn-team-add-month"  class=" btn btn-primary btn-team-add">เพิ่ม</button>
                                                        </div>
                                                    </div>
                                                    <div class="row team my-3"></div>
                                                </div>

                                        </div>
                                        <div class="tab-pane fade show active" id="resulte-month" role="tabpanel" aria-labelledby="resulte-month">
                                                <form action="" method="post" >       
                                                    <div class="container"> 
                                                        <div class="row my-3">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                                <p class="alert alert-primary">ต้องกดค้นหาผลทุกครั้ง</p>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                                                <lable>1.เลือกสถานพยาบาล</lable>
                                                                <select id="select-hcode-month" class="form-select" name="level_select">
                                                                        <?php foreach($dataHcode as $key => $value){  
                                                                                if($value["hcode"] === "11161" )
                                                                                {
                                                                            ?>
                                                                                <option value="<?php echo $value["hcode"] ; ?>" selected="selected"><?php echo $value['hname'] ;?></option>
                                                                        <?php } else {?> 
                                                                            <option value="<?php echo $value["hcode"] ; ?>"><?php echo $value['hname'] ;?></option>
                                                                        <?php }}?>
                                                                </select>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                                                   <button type="button" name="search_resulte" id="search_resulte" class="btn btn-success w-100 my-4" onclick="ResulteSearchMonth()">2.ค้นหาผล</button>
                                                            </div>
                                                        </div>
                                                       <div class="row" id="show_month_input">

                                                       </div>
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-3">
                                                                    <button type="button" name="btn_submit_form_month"  id="btn_submit_form_month" class="btn btn-primary w-100" onclick="addreslutemonth()">3.บันทึก</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form> 
                                        </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="detail-month-content" role="tabpanel" aria-labelledby="detail-month">
                                 <div id="var-a-month" class="my-3"></div>
                                 <div id="var-b-month" class="my-3"></div>
                                 <div id="var-c-month" class="my-3"></div>
                                 <div id="var-d-month" class="my-3"></div>
                                 <div id="calculator-month" class="my-3"></div>
                                 <div id="traget-month" class="my-3"></div>
                            </div>
                            <div class="tab-pane fade" id="document-month-content" role="tabpanel" aria-labelledby="document-month">
                                    
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Send Type quarter -->
<div id="modal-quarter" class="modal modal-xl fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                   <div id="kpi_name-quarter"  class="my-3"></div> 
                        <div id="kpi_child_name-quarter" class="my-3"></div>         
                        <div id="kpi_sub_name-quarter" class="my-3"></div>         
                        <ul class="nav nav-tabs" id="tab-quarter" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-add-quarter" data-bs-toggle="tab" data-bs-target="#tab-quarter-content" type="button" role="tab" aria-controls="tab-quarter-content" aria-selected="true">หน่วยงาน/ผู้รับชอบ</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="detail-quarter" data-bs-toggle="tab" data-bs-target="#detail-quarter-content" type="button" role="tab" aria-controls="detail-quarter-content" aria-selected="false">รายละเอียด</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="document-quarter" data-bs-toggle="tab" data-bs-target="#document-quarter-content" type="button" role="tab" aria-controls="document-quarter-content" aria-selected="false">เอกสาร</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab-quarter-content" role="tabpanel" aria-labelledby="tab-add-quarter">
                                   <div id="sup-people-quarter" class="my-3"></div>
                                   <div id="unit-quarter" class="my-3"></div>
                                   <div id="kpi-dic-tab-quarter" class="my-3"></div>
                                   <div id="traget-tab-quarter" class="my-3"></div>
                                   <div id="condition-quarter" class="my-3"></div>
                                   <div id="date-end-quarter" class="my-3"></div>
                                    <ul class="nav nav-tabs" id="tab-list-quarter" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="co-person-tab-quarter" data-bs-toggle="tab" data-bs-target="#co-person-quarter" type="button" role="tab" aria-controls="co-person" aria-selected="false">ผู้รับผิดชอบร่วม</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="department-tab-quarter" data-bs-toggle="tab" data-bs-target="#department-quarter" type="button" role="tab" aria-controls="department" aria-selected="false">กลุ่มงานที่รับผิดชอบ</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="team-tab-quarter" data-bs-toggle="tab" data-bs-target="#team-quarter" type="button" role="tab" aria-controls="team" aria-selected="false">ทีมที่รับผิดชอบ</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="resulte-tab-quarter" data-bs-toggle="tab" data-bs-target="#resulte-quarter" type="button" role="tab" aria-controls="resulte" aria-selected="true">ผลตัวชี้วัด</button>
                                        </li>
                                    </ul>
                                        <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade" id="co-person-quarter" role="tabpanel" aria-labelledby="co-person-quarter">
                          
                                        </div>
                                        <div class="tab-pane fade" id="department-quarter" role="tabpanel" aria-labelledby="department-quarter">
                                            <div class="container my-3">
                                                    <div class="row my-3">
                                                        <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                                        <select id="select-department-quarter" class="form-select" name="level_select">
                                                                <option value="0" selected="selected">กลุ่มงานที่รับผิดชอบ</option>
                                                                <?php foreach($dataDepartment as $key => $value){  ?>
                                                                        <option value="<?php echo $value["HR_DEPARTMENT_ID"] ; ?>"><?php echo $value['HR_DEPARTMENT_NAME'] ;?> </option>
                                                                <?php } ?>
                                                        </select>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                            <button type="button" name="btn-department-add-quarter" class=" btn btn-primary btn-department-add">เพิ่ม</button>
                                                        </div>
                                                    </div>
                                                    <div class="row department my-3"></div>
                                                </div>
                                        </div>
                                        <div class="tab-pane fade" id="team-quarter" role="tabpanel" aria-labelledby="team-quarter">
                                                <div class="container my-3">
                                                    <div class="row my-3">
                                                        <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                                        <select id="select-team-quarter" class="form-select" name="level_select">
                                                                <option value="0" selected="selected">ทีมที่รับผิดชอบ</option>
                                                                <?php foreach($dataTeam as $key => $value){  ?>
                                                                        <option value="<?php echo $value["HR_TEAM_ID"] ; ?>"><?php echo $value['HR_TEAM_NAME'] ;?> </option>
                                                                <?php } ?>
                                                        </select>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                             <button type="button" name="btn-team-add-quarter"  class=" btn btn-primary btn-team-add">เพิ่ม</button>
                                                        </div>
                                                    </div>
                                                    <div class="row team my-3"></div>
                                                </div>

                                        </div>
                                        <div class="tab-pane fade show active" id="resulte-quarter" role="tabpanel" aria-labelledby="resulte-quarter">
                                                <form action="" method="post" >       
                                                    <div class="container"> 
                                                        <div class="row my-3">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                                <p class="alert alert-primary">ต้องกดค้นหาผลทุกครั้ง</p>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                                                <lable>1.เลือกสถานพยาบาล</lable>
                                                                <select id="select-hcode-quarter" class="form-select" name="level_select">
                                                                        <?php foreach($dataHcode as $key => $value){  
                                                                                if($value["hcode"] === "11161" )
                                                                                {
                                                                            ?>
                                                                                <option value="<?php echo $value["hcode"] ; ?>" selected="selected"><?php echo $value['hname'] ;?></option>
                                                                        <?php } else {?> 
                                                                            <option value="<?php echo $value["hcode"] ; ?>"><?php echo $value['hname'] ;?></option>
                                                                        <?php }}?>
                                                                </select>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                                                   <button type="button" name="search_resulte" id="search_resulte" class="btn btn-success w-100 my-4" onclick="ResulteSearchquarter()">2.ค้นหาผล</button>
                                                            </div>
                                                        </div>
                                                       <div class="row" id="show_quarter_input">

                                                       </div>
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-3">
                                                                    <button type="button" name="btn_submit_form_quarter"  id="btn_submit_form_quarter" class="btn btn-primary w-100" onclick="addreslutequarter()">3.บันทึก</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form> 
                                        </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="detail-quarter-content" role="tabpanel" aria-labelledby="detail-quarter">
                                 <div id="var-a-quarter" class="my-3"></div>
                                 <div id="var-b-quarter" class="my-3"></div>
                                 <div id="var-c-quarter" class="my-3"></div>
                                 <div id="var-d-quarter" class="my-3"></div>
                                 <div id="calculator-quarter" class="my-3"></div>
                                 <div id="traget-quarter" class="my-3"></div>
                            </div>
                            <div class="tab-pane fade" id="document-quarter-content" role="tabpanel" aria-labelledby="document-quarter">
                                    
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Send Type half -->
<div id="modal-half" class="modal modal-xl fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                   <div id="kpi_name-half"  class="my-3"></div> 
                        <div id="kpi_child_name-half" class="my-3"></div>         
                        <div id="kpi_sub_name-half" class="my-3"></div>         
                        <ul class="nav nav-tabs" id="tab-half" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-add-half" data-bs-toggle="tab" data-bs-target="#tab-half-content" type="button" role="tab" aria-controls="tab-half-content" aria-selected="true">หน่วยงาน/ผู้รับชอบ</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="detail-half" data-bs-toggle="tab" data-bs-target="#detail-half-content" type="button" role="tab" aria-controls="detail-half-content" aria-selected="false">รายละเอียด</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="document-half" data-bs-toggle="tab" data-bs-target="#document-half-content" type="button" role="tab" aria-controls="document-half-content" aria-selected="false">เอกสาร</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab-half-content" role="tabpanel" aria-labelledby="tab-add-half">
                                   <div id="sup-people-half" class="my-3"></div>
                                   <div id="unit-half" class="my-3"></div>
                                   <div id="kpi-dic-tab-half" class="my-3"></div>
                                   <div id="traget-tab-half" class="my-3"></div>
                                   <div id="condition-half" class="my-3"></div>
                                   <div id="date-end-half" class="my-3"></div>
                                    <ul class="nav nav-tabs" id="tab-list-half" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="co-person-tab-half" data-bs-toggle="tab" data-bs-target="#co-person-half" type="button" role="tab" aria-controls="co-person" aria-selected="false">ผู้รับผิดชอบร่วม</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="department-tab-half" data-bs-toggle="tab" data-bs-target="#department-half" type="button" role="tab" aria-controls="department" aria-selected="false">กลุ่มงานที่รับผิดชอบ</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="team-tab-half" data-bs-toggle="tab" data-bs-target="#team-half" type="button" role="tab" aria-controls="team" aria-selected="false">ทีมที่รับผิดชอบ</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="resulte-tab-half" data-bs-toggle="tab" data-bs-target="#resulte-half" type="button" role="tab" aria-controls="resulte" aria-selected="true">ผลตัวชี้วัด</button>
                                        </li>
                                    </ul>
                                        <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade" id="co-person-half" role="tabpanel" aria-labelledby="co-person-half">
                          
                                        </div>
                                        <div class="tab-pane fade" id="department-half" role="tabpanel" aria-labelledby="department-half">
                                            <div class="container my-3">
                                                    <div class="row my-3">
                                                        <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                                        <select id="select-department-half" class="form-select" name="level_select">
                                                                <option value="0" selected="selected">กลุ่มงานที่รับผิดชอบ</option>
                                                                <?php foreach($dataDepartment as $key => $value){  ?>
                                                                        <option value="<?php echo $value["HR_DEPARTMENT_ID"] ; ?>"><?php echo $value['HR_DEPARTMENT_NAME'] ;?> </option>
                                                                <?php } ?>
                                                        </select>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                            <button type="button" name="btn-department-add-half" class=" btn btn-primary btn-department-add">เพิ่ม</button>
                                                        </div>
                                                    </div>
                                                    <div class="row department my-3"></div>
                                                </div>
                                        </div>
                                        <div class="tab-pane fade" id="team-half" role="tabpanel" aria-labelledby="team-half">
                                                <div class="container my-3">
                                                    <div class="row my-3">
                                                        <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                                        <select id="select-team-half" class="form-select" name="level_select">
                                                                <option value="0" selected="selected">ทีมที่รับผิดชอบ</option>
                                                                <?php foreach($dataTeam as $key => $value){  ?>
                                                                        <option value="<?php echo $value["HR_TEAM_ID"] ; ?>"><?php echo $value['HR_TEAM_NAME'] ;?> </option>
                                                                <?php } ?>
                                                        </select>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                             <button type="button" name="btn-team-add-half"  class=" btn btn-primary btn-team-add">เพิ่ม</button>
                                                        </div>
                                                    </div>
                                                    <div class="row team my-3"></div>
                                                </div>

                                        </div>
                                        <div class="tab-pane fade show active" id="resulte-half" role="tabpanel" aria-labelledby="resulte-half">
                                                <form action="" method="post" >       
                                                    <div class="container"> 
                                                        <div class="row my-3">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                                <p class="alert alert-primary">ต้องกดค้นหาผลทุกครั้ง</p>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                                                <lable>1.เลือกสถานพยาบาล</lable>
                                                                <select id="select-hcode-half" class="form-select" name="level_select">
                                                                        <?php foreach($dataHcode as $key => $value){  
                                                                                if($value["hcode"] === "11161" )
                                                                                {
                                                                            ?>
                                                                                <option value="<?php echo $value["hcode"] ; ?>" selected="selected"><?php echo $value['hname'] ;?></option>
                                                                        <?php } else {?> 
                                                                            <option value="<?php echo $value["hcode"] ; ?>"><?php echo $value['hname'] ;?></option>
                                                                        <?php }}?>
                                                                </select>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                                                   <button type="button" name="search_resulte" id="search_resulte" class="btn btn-success w-100 my-4" onclick="ResulteSearchhalf()">2.ค้นหาผล</button>
                                                            </div>
                                                        </div>
                                                       <div class="row" id="show_half_input">

                                                       </div>
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-3">
                                                                    <button type="button" name="btn_submit_form_half"  id="btn_submit_form_half" class="btn btn-primary w-100" onclick="addreslutehalf()">3.บันทึก</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form> 
                                        </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="detail-half-content" role="tabpanel" aria-labelledby="detail-half">
                                 <div id="var-a-half" class="my-3"></div>
                                 <div id="var-b-half" class="my-3"></div>
                                 <div id="var-c-half" class="my-3"></div>
                                 <div id="var-d-half" class="my-3"></div>
                                 <div id="calculator-half" class="my-3"></div>
                                 <div id="traget-half" class="my-3"></div>
                            </div>
                            <div class="tab-pane fade" id="document-half-content" role="tabpanel" aria-labelledby="document-half">
                                    
                            </div>
                        </div>
            </div>
         </div>
    </div>
</div>
<!-- Modal Send Type year -->
<div id="modal-year" class="modal modal-xl fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                        <div id="kpi_name-year" class="my-3"></div> 
                        <div id="kpi_child_name-year" class="my-3"></div>         
                        <div id="kpi_sub_name-year" class="my-3"></div>         
                        <ul class="nav nav-tabs" id="tab-year" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-add-year" data-bs-toggle="tab" data-bs-target="#tab-year-content" type="button" role="tab" aria-controls="tab-year-content" aria-selected="true">หน่วยงาน/ผู้รับชอบ</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="detail-year" data-bs-toggle="tab" data-bs-target="#detail-year-content" type="button" role="tab" aria-controls="detail-year-content" aria-selected="false">รายละเอียด</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="document-year" data-bs-toggle="tab" data-bs-target="#document-year-content" type="button" role="tab" aria-controls="document-year-content" aria-selected="false">เอกสาร</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade" id="tab-year-content" role="tabpanel" aria-labelledby="tab-add-year">
                                    <div id="sup-people-year" class="my-3"></div>
                                    <div id="unit-year" class="my-3"></div>
                                    <div id="kpi-dic-tab-year" class="my-3"></div>
                                    <div id="traget-tab-year" class="my-3"></div>
                                    <div id="condition-year" class="my-3"></div>
                                    <div id="date-end-year" class="my-3"></div>
                                    <ul class="nav nav-tabs" id="tab-list-year" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="co-person-tab-year" data-bs-toggle="tab" data-bs-target="#co-person-year" type="button" role="tab" aria-controls="co-person" aria-selected="false">ผู้รับผิดชอบร่วม</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="department-tab-year" data-bs-toggle="tab" data-bs-target="#department-year" type="button" role="tab" aria-controls="department" aria-selected="false">กลุ่มงานที่รับผิดชอบ</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="team-tab-year" data-bs-toggle="tab" data-bs-target="#team-year" type="button" role="tab" aria-controls="team" aria-selected="false">ทีมที่รับผิดชอบ</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="resulte-tab-year" data-bs-toggle="tab" data-bs-target="#resulte-year" type="button" role="tab" aria-controls="resulte" aria-selected="true">ผลตัวชี้วัด</button>
                                        </li>
                                    </ul>
                                        <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="co-person-year" role="tabpanel" aria-labelledby="co-person-year">
                        
                                        </div>
                                        <div class="tab-pane fade show active" id="department-year" role="tabpanel" aria-labelledby="department-year">
                                            <div class="container my-3">
                                                    <div class="row my-3">
                                                        <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                                        <select id="select-department-year" class="form-select" name="level_select">
                                                                <option value="0" selected="selected">กลุ่มงานที่รับผิดชอบ</option>
                                                                <?php foreach($dataDepartment as $key => $value){  ?>
                                                                        <option value="<?php echo $value["HR_DEPARTMENT_ID"] ; ?>"><?php echo $value['HR_DEPARTMENT_NAME'] ;?> </option>
                                                                <?php } ?>
                                                        </select>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                            <button type="button" name="btn-department-add-year" class=" btn btn-primary btn-department-add">เพิ่ม</button>
                                                        </div>
                                                    </div>
                                                    <div class="row department my-3"></div>
                                                </div>
                                        </div>
                                        <div class="tab-pane fade" id="team-year" role="tabpanel" aria-labelledby="team-year">
                                                <div class="container my-3">
                                                    <div class="row my-3">
                                                        <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                                        <select id="select-team-year" class="form-select" name="level_select">
                                                                <option value="0" selected="selected">ทีมที่รับผิดชอบ</option>
                                                                <?php foreach($dataTeam as $key => $value){  ?>
                                                                        <option value="<?php echo $value["HR_TEAM_ID"] ; ?>"><?php echo $value['HR_TEAM_NAME'] ;?> </option>
                                                                <?php } ?>
                                                        </select>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                            <button type="button" name="btn-team-add-year"  class=" btn btn-primary btn-team-add">เพิ่ม</button>
                                                        </div>
                                                    </div>
                                                    <div class="row team my-3"></div>
                                                </div>

                                        </div>
                                        <div class="tab-pane fade" id="resulte-year" role="tabpanel" aria-labelledby="resulte-year">
                                                <form action="" method="post" >       
                                                    <div class="container"> 
                                                        <div class="row my-3">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                                <p class="alert alert-primary">ต้องกดค้นหาผลทุกครั้ง</p>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                                                <lable>1.เลือกสถานพยาบาล</lable>
                                                                <select id="select-hcode-year" class="form-select" name="level_select">
                                                                        <?php foreach($dataHcode as $key => $value){  
                                                                                if($value["hcode"] === "11161" )
                                                                                {
                                                                            ?>
                                                                                <option value="<?php echo $value["hcode"] ; ?>" selected="selected"><?php echo $value['hname'] ;?></option>
                                                                        <?php } else {?> 
                                                                            <option value="<?php echo $value["hcode"] ; ?>"><?php echo $value['hname'] ;?></option>
                                                                        <?php }}?>
                                                                </select>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                                                    <button type="button" name="search_resulte" id="search_resulte" class="btn btn-success w-100 my-4" onclick="ResulteSearchyear()">2.ค้นหาผล</button>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="show_year_input">

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-3">
                                                                    <button type="button" name="btn_submit_form_year"  id="btn_submit_form_year" class="btn btn-primary w-100" onclick="addresluteyear()">3.บันทึก</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form> 
                                        </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="detail-year-content" role="tabpanel" aria-labelledby="detail-year">
                                <div id="var-a-year" class="my-3"></div>
                                <div id="var-b-year" class="my-3"></div>
                                <div id="var-c-year" class="my-3"></div>
                                <div id="var-d-year" class="my-3"></div>
                                <div id="calculator-year" class="my-3"></div>
                                <div id="traget-year" class="my-3"></div>
                            </div>
                            <div class="tab-pane fade" id="document-year-content" role="tabpanel" aria-labelledby="document-year">
                                    
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
     let data = "";

     const dataMonth = <?= json_encode($data_month)?> ; // Global Variable
     const dataSuccess = <?= json_encode($data_success) ?> ; // Global Variable

     $(document).ready(() => {
        let table = new DataTable('#table-kpi');
        $('#table-kpi tbody').on('click', 'tr', function() {
             data = $(this).find('td:last').text();
            $.ajax({
                url: "<?= Url::to(['get-type-send']) ?>" , 
                method:"post" , 
                data: { 
                    kpi_template_id: data , 
                    "<?= Yii::$app->request->csrfParam ?>" : "<?= Yii::$app->request->csrfToken ?>"
                }
            }).done((data)=> { 
                const SendTypeData = JSON.parse(data)
                ShowModal(SendTypeData.type , SendTypeData)
            })
        });
        $(`.btn-department-add`).on('click' , () => { 
            $.ajax({ 
                url: "<?php echo Url::to(['add-department']) ; ?>" , 
                method : "post" ,
                data: { 
                    kpi_template_id: data , 
                    department: $(`#select-department-month`).val() !== "0" ? $(`#select-department-month`).val()  : $(`#select-department-quarter`).val(),
                    "<?= Yii::$app->request->csrfParam ?>" : "<?= Yii::$app->request->csrfToken ?>"
                }
            }).done((data) => { 
                  $(`.department`).empty() 
                  const SendDataType = JSON.parse(data)
                  SendDataType.data_respone.forEach((value , key) => { 
                           $(`.department`).append(` 
                                   <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 my-1">${value.HR_DEPARTMENT_NAME}</div> 
                                   <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 my-1"><button type="button" class="btn btn-danger" data-index="${value.id}" onclick="deleteData(this)">ลบ</button></div>
                                `)
                            })
             })
             $(`#select-department-quarter`).val('0')
             $(`#select-department-month`).val('0')
         })

        $(`.btn-team-add`).on('click' , () => { 
            $.ajax({ 
                url: "<?php echo Url::to(['add-teams']) ; ?>" , 
                method : "post" ,
                data: { 
                    kpi_template_id: data , 
                    teams: $(`#select-team-month`).val() !== "0" ? $(`#select-team-month`).val()  : $(`#select-team-quarter`).val()  ,
                    "<?= Yii::$app->request->csrfParam ?>" : "<?= Yii::$app->request->csrfToken ?>"
                }
            }).done((data) => { 
                  $(`.team`).empty() 
                  const SendDataType = JSON.parse(data)
                  SendDataType.data_respone.forEach((value , key) => { 
                           $(`.team`).append(` 
                                   <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 my-1">${value.HR_TEAM_NAME}</div> 
                                   <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 my-1"><button type="button" class="btn btn-danger" data-index="${value.id}" onclick="deleteTeams(this)">ลบ</button></div>
                                `)
                            })
             })
             $(`#select-team-quarter`).val('0')
             $(`#select-team-month`).val('0')
        })
     })
     const deleteData = (prop) => { 
        const dataIndex = prop.getAttribute("data-index")
        $.ajax({ 
           url: "<?= Url::to(['delete-department']) ?>" , 
           method : "post" , 
           data :{ 
                department_id : dataIndex ,
                "<?= Yii::$app->request->csrfParam ?>" : "<?= Yii::$app->request->csrfToken?>"
              }
           }).done((data) => { 
                const SendDataType = JSON.parse(data)
                $(`.department`).empty() 
                SendDataType.data_respone.forEach((value , key) => { 
                    $(`.department`).append(` 
                         <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 my-1">${value.HR_DEPARTMENT_NAME}</div> 
                         <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 my-1"><button type="button" class="btn btn-danger" data-index="${value.id}" onclick="deleteData(this)">ลบ</button></div>
                     `)
                    })
           })
     }
     const deleteTeams = (prop) => { 
        const dataIndex = prop.getAttribute("data-index")
        $.ajax({ 
           url: "<?= Url::to(['delete-teams']) ?>" , 
           method : "post" , 
           data :{ 
                team_id : dataIndex ,
                "<?= Yii::$app->request->csrfParam ?>" : "<?= Yii::$app->request->csrfToken?>"
              }
           }).done((data) => { 
                const SendDataType = JSON.parse(data)
                $(`.team`).empty() 
                SendDataType.data_respone.forEach((value , key) => { 
                    $(`.team`).append(` 
                         <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 my-1">${value.HR_TEAM_NAME}</div> 
                         <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 my-1"><button type="button" class="btn btn-danger" data-index="${value.id}" onclick="deleteTeams(this)">ลบ</button></div>
                     `)
                    })
           })
     }

     const ResulteSearchMonth = () => { 
            $.ajax({ 
                url:"<?= Url::to(["search-resulte"]) ?>" , 
                method:"post" , 
                data: { 
                    kpi_template_id: data , 
                    hcode: $(`#select-hcode-month`).val() ,
                    "<?= Yii::$app->request->csrfParam ?>" : "<?= Yii::$app->request->csrfToken ?>"
                }
            }).done((data) => { 
                const dataSearch = JSON.parse(data) 
                if(dataSearch.data_respone.length !== 0) { 
                    dataSearch.data_respone.forEach((k , v) => { 
                        if(k.target === "ผ่าน") {
                            if(k.reslute_check == 4)$(`#check_box_3_month_${v}`).prop("checked" , true)
                            else if(k.reslute_check == 3)$(`#check_box_2_month_${v}`).prop("checked" , true)
                            else if(k.reslute_check == 2)$(`#check_box_1_month_${v}`).prop("checked" , true)
                            else if(k.reslute_check == 1)$(`#check_box_0_month_${v}`).prop("checked" , true)
                        }else{
                            if($(`#input_a_${v}_month`) !== undefined) $(`#input_a_${v}_month`).val(k.value_a); 
                            if($(`#input_b_${v}_month`) !== undefined) $(`#input_b_${v}_month`).val(k.value_b);
                            if((`#input_c_${v}_month`) !== undefined) $(`#input_c_${v}_month`).val(k.value_c);
                            if($(`#input_d_${v}_month`) !== undefined ) $(`#input_d_${v}_month`).val(k.value_d);
                            if($(`#input_resulte_${v}_month`) !== undefined ) $(`#input_resulte_${v}_month`).val(k.result);
                        }          
                    })
                }else{ 
                    for(let i=0; i <= 11 ; i++){ 
                        if((`#check_box_3_month_${i}`) !== undefined )$(`#check_box_3_month_${i}`).prop("checked" , false)
                        if((`#check_box_2_month_${i}`) !== undefined)$(`#check_box_2_month_${i}`).prop("checked" , false)
                        if((`#check_box_1_month_${i}`) !== undefined)$(`#check_box_1_month_${i}`).prop("checked" , false)
                        if((`#check_box_0_month_${i}`) !== undefined)$(`#check_box_0_month_${i}`).prop("checked" , false)
                        if($(`#input_a_${i}_month`) !== undefined) $(`#input_a_${i}_month`).val("") ;   // clear data in input
                        if($(`#input_b_${i}_month`) !== undefined) $(`#input_b_${i}_month`).val("") ;    // clear data in input
                        if((`#input_c_${i}_month`) !== undefined) $(`#input_c_${i}_month`).val("");   // clear data in input
                        if($(`#input_d_${i}_month`) !== undefined ) $(`#input_d_${i}_month`).val("") ;  
                        if($(`#input_resulte_${i}_month`) !== undefined ) $(`#input_resulte_${i}_month`).val("") ;
                    }
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Not found Data",
                        showConfirmButton: false,
                        timer: 1000
                    }); 
                }

            })
        }
        
     const addreslutemonth = () => { 
        let dataArray = []
        for(let i = 0 ; i <= 11 ; i++){ 
            dataArray.push({
                month:$(`#month_${i}`).val() , 
                input_a: $(`#input_a_${i}_month`).val() !== undefined ? $(`#input_a_${i}_month`).val() : "" , 
                input_b: $(`#input_b_${i}_month`).val() !== undefined ? $(`#input_b_${i}_month`).val() : "" , 
                input_c: $(`#input_c_${i}_month`).val() !== undefined ? $(`#input_c_${i}_month`).val() : "" , 
                input_d: $(`#input_d_${i}_month`).val() !== undefined ? $(`#input_d_${i}_month`).val() : "" , 
                input_resulte: $(`#input_resulte_${i}_month`).val() !== undefined ?  $(`#input_resulte_${i}_month`).val() :"" , 
                input_checkbox_1:$(`#check_box_0_month_${i}`).val() === undefined ? "": $(`#check_box_0_month_${i}`).prop('checked') ? $(`#check_box_0_month_${i}`).val() : 0   ,
                input_checkbox_2:$(`#check_box_1_month_${i}`).val() === undefined ? "" : $(`#check_box_1_month_${i}`).prop('checked') ? $(`#check_box_1_month_${i}`).val() : 0,
                input_checkbox_3:$(`#check_box_2_month_${i}`).val() === undefined ? "" : $(`#check_box_2_month_${i}`).prop('checked') ? $(`#check_box_2_month_${i}`).val() : 0,
                input_checkbox_4:$(`#check_box_3_month_${i}`).val() === undefined ? "": $(`#check_box_3_month_${i}`).prop('checked') ? $(`#check_box_3_month_${i}`).val() : 0 ,
            })
        }
        $.ajax({ 
                url:"<?= Url::to(["add-resulte"]) ?>" , 
                method:"post" , 
                data: { 
                    kpi_template_id: data , 
                    hcode: $(`#select-hcode-month`).val() ,
                    "<?= Yii::$app->request->csrfParam ?>" : "<?= Yii::$app->request->csrfToken ?>" , 
                    dataForm: dataArray
                }
            }).done((dataReturn) => {
                const Datacheck = JSON.parse(dataReturn) 
                Datacheck.status == "200" ? Swal.fire({
                position: "center",
                icon: "success",
                title: Datacheck.massage,
                showConfirmButton: false,
                timer: 1000
                })
                : Swal.fire({
                position: "center",
                icon: "error",
                title: Datacheck.massage,
                showConfirmButton: false,
                timer: 1000
                }); 
            })  
     }
     const ResulteSearchquarter = () => { 
            $.ajax({ 
                url:"<?= Url::to(["search-resulte"]) ?>" , 
                method:"post" , 
                data: { 
                    kpi_template_id: data , 
                    hcode: $(`#select-hcode-quarter`).val() ,
                    "<?= Yii::$app->request->csrfParam ?>" : "<?= Yii::$app->request->csrfToken ?>"
                }
            }).done((data) => { 
                const dataSearch = JSON.parse(data) 
                if(dataSearch.data_respone.length !== 0) { 
                    dataSearch.data_respone.forEach((k , v) => { 
                        if(k.target === "ผ่าน") {
                            if(k.reslute_check == 4)$(`#check_box_3_quarter_${v}`).prop("checked" , true)
                            else if(k.reslute_check == 3)$(`#check_box_2_quarter_${v}`).prop("checked" , true)
                            else if(k.reslute_check == 2)$(`#check_box_1_quarter_${v}`).prop("checked" , true)
                            else if(k.reslute_check == 1)$(`#check_box_0_quarter_${v}`).prop("checked" , true)
                        }else{
                            if($(`#input_a_${v}_quarter`) !== undefined) $(`#input_a_${v}_quarter`).val(k.value_a); 
                            if($(`#input_b_${v}_quarter`) !== undefined) $(`#input_b_${v}_quarter`).val(k.value_b);
                            if((`#input_c_${v}_quarter`) !== undefined) $(`#input_c_${v}_quarter`).val(k.value_c);
                            if($(`#input_d_${v}_quarter`) !== undefined ) $(`#input_d_${v}_quarter`).val(k.value_d);
                            if($(`#input_resulte_${v}_quarter`) !== undefined ) $(`#input_resulte_${v}_quarter`).val(k.result);
                        }          
                    })
                }else{ 
                    for(let i=0; i <= 3 ; i++){ 
                        if((`#check_box_3_quarter_${i}`) !== undefined )$(`#check_box_3_quarter_${i}`).prop("checked" , false)
                        if((`#check_box_2_quarter_${i}`) !== undefined)$(`#check_box_2_quarter_${i}`).prop("checked" , false)
                        if((`#check_box_1_quarter_${i}`) !== undefined)$(`#check_box_1_quarter_${i}`).prop("checked" , false)
                        if((`#check_box_0_quarter_${i}`) !== undefined)$(`#check_box_0_quarter_${i}`).prop("checked" , false)
                        if($(`#input_a_${i}_quarter`) !== undefined) $(`#input_a_${i}_quarter`).val("") ;   // clear data in input
                        if($(`#input_b_${i}_quarter`) !== undefined) $(`#input_b_${i}_quarter`).val("") ;    // clear data in input
                        if((`#input_c_${i}_quarter`) !== undefined) $(`#input_c_${i}_quarter`).val("");   // clear data in input
                        if($(`#input_d_${i}_quarter`) !== undefined ) $(`#input_d_${i}_quarter`).val("") ;  
                        if($(`#input_resulte_${i}_quarter`) !== undefined ) $(`#input_resulte_${i}_quarter`).val("") ;
                    }
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Not found Data",
                        showConfirmButton: false,
                        timer: 1000
                    }); 
                }

            })
        }
        
     const addreslutequarter = () => { 
        let dataArray = []
        for(let i = 0 ; i <= 3 ; i++){ 
            dataArray.push({
                month:$(`#quarter_${i}`).val() , 
                input_a: $(`#input_a_${i}_quarter`).val() !== undefined ? $(`#input_a_${i}_quarter`).val() : "" , 
                input_b: $(`#input_b_${i}_quarter`).val() !== undefined ? $(`#input_b_${i}_quarter`).val() : "" , 
                input_c: $(`#input_c_${i}_quarter`).val() !== undefined ? $(`#input_c_${i}_quarter`).val() : "" , 
                input_d: $(`#input_d_${i}_quarter`).val() !== undefined ? $(`#input_d_${i}_quarter`).val() : "" , 
                input_resulte: $(`#input_resulte_${i}_quarter`).val() !== undefined ?  $(`#input_resulte_${i}_quarter`).val() :"" , 
                input_checkbox_1:$(`#check_box_0_quarter_${i}`).val() === undefined ? "": $(`#check_box_0_quarter_${i}`).prop('checked') ? $(`#check_box_0_quarter_${i}`).val() : 0   ,
                input_checkbox_2:$(`#check_box_1_quarter_${i}`).val() === undefined ? "" : $(`#check_box_1_quarter_${i}`).prop('checked') ? $(`#check_box_1_quarter_${i}`).val() : 0,
                input_checkbox_3:$(`#check_box_2_quarter_${i}`).val() === undefined ? "" : $(`#check_box_2_quarter_${i}`).prop('checked') ? $(`#check_box_2_quarter_${i}`).val() : 0,
                input_checkbox_4:$(`#check_box_3_quarter_${i}`).val() === undefined ? "": $(`#check_box_3_quarter_${i}`).prop('checked') ? $(`#check_box_3_quarter_${i}`).val() : 0 ,
            })
        }
        $.ajax({ 
                url:"<?= Url::to(["add-resulte"]) ?>" , 
                method:"post" , 
                data: { 
                    kpi_template_id: data , 
                    hcode: $(`#select-hcode-quarter`).val() ,
                    "<?= Yii::$app->request->csrfParam ?>" : "<?= Yii::$app->request->csrfToken ?>" , 
                    dataForm: dataArray
                }
            }).done((dataReturn) => {
                const Datacheck = JSON.parse(dataReturn) 
                Datacheck.status == "200" ? Swal.fire({
                position: "center",
                icon: "success",
                title: Datacheck.massage,
                showConfirmButton: false,
                timer: 1000
                })
                : Swal.fire({
                position: "center",
                icon: "error",
                title: Datacheck.massage,
                showConfirmButton: false,
                timer: 1000
                }); 
            })  
     }
     const ResulteSearchhalf = () => { 
            $.ajax({ 
                url:"<?= Url::to(["search-resulte"]) ?>" , 
                method:"post" , 
                data: { 
                    kpi_template_id: data , 
                    hcode: $(`#select-hcode-half`).val() ,
                    "<?= Yii::$app->request->csrfParam ?>" : "<?= Yii::$app->request->csrfToken ?>"
                }
            }).done((data) => { 
                const dataSearch = JSON.parse(data) 
                if(dataSearch.data_respone.length !== 0) { 
                    dataSearch.data_respone.forEach((k , v) => { 
                        if(k.target === "ผ่าน") {
                            if(k.reslute_check == 4)$(`#check_box_3_half_${v}`).prop("checked" , true)
                            else if(k.reslute_check == 3)$(`#check_box_2_half_${v}`).prop("checked" , true)
                            else if(k.reslute_check == 2)$(`#check_box_1_half_${v}`).prop("checked" , true)
                            else if(k.reslute_check == 1)$(`#check_box_0_half_${v}`).prop("checked" , true)
                        }else{
                            if($(`#input_a_${v}_half`) !== undefined) $(`#input_a_${v}_half`).val(k.value_a); 
                            if($(`#input_b_${v}_half`) !== undefined) $(`#input_b_${v}_half`).val(k.value_b);
                            if((`#input_c_${v}_half`) !== undefined) $(`#input_c_${v}_half`).val(k.value_c);
                            if($(`#input_d_${v}_half`) !== undefined ) $(`#input_d_${v}_half`).val(k.value_d);
                            if($(`#input_resulte_${v}_half`) !== undefined ) $(`#input_resulte_${v}_half`).val(k.result);
                        }          
                    })
                }else{ 
                    for(let i=0; i <= 1 ; i++){ 
                        if((`#check_box_3_half_${i}`) !== undefined )$(`#check_box_3_half_${i}`).prop("checked" , false)
                        if((`#check_box_2_half_${i}`) !== undefined)$(`#check_box_2_half_${i}`).prop("checked" , false)
                        if((`#check_box_1_half_${i}`) !== undefined)$(`#check_box_1_half_${i}`).prop("checked" , false)
                        if((`#check_box_0_half_${i}`) !== undefined)$(`#check_box_0_half_${i}`).prop("checked" , false)
                        if($(`#input_a_${i}_half`) !== undefined) $(`#input_a_${i}_half`).val("") ;   // clear data in input
                        if($(`#input_b_${i}_half`) !== undefined) $(`#input_b_${i}_half`).val("") ;    // clear data in input
                        if((`#input_c_${i}_half`) !== undefined) $(`#input_c_${i}_half`).val("");   // clear data in input
                        if($(`#input_d_${i}_half`) !== undefined ) $(`#input_d_${i}_half`).val("") ;  
                        if($(`#input_resulte_${i}_half`) !== undefined ) $(`#input_resulte_${i}_half`).val("") ;
                    }
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Not found Data",
                        showConfirmButton: false,
                        timer: 1000
                    }); 
                }

            })
        }
        
     const addreslutehalf = () => { 
        let dataArray = []
        for(let i = 0 ; i <= 1 ; i++){ 
            dataArray.push({
                month:$(`#half_${i}`).val() , 
                input_a: $(`#input_a_${i}_half`).val() !== undefined ? $(`#input_a_${i}_half`).val() : "" , 
                input_b: $(`#input_b_${i}_half`).val() !== undefined ? $(`#input_b_${i}_half`).val() : "" , 
                input_c: $(`#input_c_${i}_half`).val() !== undefined ? $(`#input_c_${i}_half`).val() : "" , 
                input_d: $(`#input_d_${i}_half`).val() !== undefined ? $(`#input_d_${i}_half`).val() : "" , 
                input_resulte: $(`#input_resulte_${i}_half`).val() !== undefined ?  $(`#input_resulte_${i}_half`).val() :"" , 
                input_checkbox_1:$(`#check_box_0_half_${i}`).val() === undefined ? "": $(`#check_box_0_half_${i}`).prop('checked') ? $(`#check_box_0_half_${i}`).val() : 0   ,
                input_checkbox_2:$(`#check_box_1_half_${i}`).val() === undefined ? "" : $(`#check_box_1_half_${i}`).prop('checked') ? $(`#check_box_1_half_${i}`).val() : 0,
                input_checkbox_3:$(`#check_box_2_half_${i}`).val() === undefined ? "" : $(`#check_box_2_half_${i}`).prop('checked') ? $(`#check_box_2_half_${i}`).val() : 0,
                input_checkbox_4:$(`#check_box_3_half_${i}`).val() === undefined ? "": $(`#check_box_3_half_${i}`).prop('checked') ? $(`#check_box_3_half_${i}`).val() : 0 ,
            })
        }
        $.ajax({ 
                url:"<?= Url::to(["add-resulte"]) ?>" , 
                method:"post" , 
                data: { 
                    kpi_template_id: data , 
                    hcode: $(`#select-hcode-half`).val() ,
                    "<?= Yii::$app->request->csrfParam ?>" : "<?= Yii::$app->request->csrfToken ?>" , 
                    dataForm: dataArray
                }
            }).done((dataReturn) => {
                const Datacheck = JSON.parse(dataReturn) 
                Datacheck.status == "200" ? Swal.fire({
                position: "center",
                icon: "success",
                title: Datacheck.massage,
                showConfirmButton: false,
                timer: 1000
                })
                : Swal.fire({
                position: "center",
                icon: "error",
                title: Datacheck.massage,
                showConfirmButton: false,
                timer: 1000
                }); 
            })  
     }
     const ResulteSearchyear = () => { 
            $.ajax({ 
                url:"<?= Url::to(["search-resulte"]) ?>" , 
                method:"post" , 
                data: { 
                    kpi_template_id: data , 
                    hcode: $(`#select-hcode-year`).val() ,
                    "<?= Yii::$app->request->csrfParam ?>" : "<?= Yii::$app->request->csrfToken ?>"
                }
            }).done((data) => { 
                const dataSearch = JSON.parse(data) 
                if(dataSearch.data_respone.length !== 0) { 
                    dataSearch.data_respone.forEach((k , v) => { 
                        if(k.target === "ผ่าน") {
                            if(k.reslute_check == 4)$(`#check_box_3_year_${v}`).prop("checked" , true)
                            else if(k.reslute_check == 3)$(`#check_box_2_year_${v}`).prop("checked" , true)
                            else if(k.reslute_check == 2)$(`#check_box_1_year_${v}`).prop("checked" , true)
                            else if(k.reslute_check == 1)$(`#check_box_0_year_${v}`).prop("checked" , true)
                        }else{
                            if($(`#input_a_${v}_year`) !== undefined) $(`#input_a_${v}_year`).val(k.value_a); 
                            if($(`#input_b_${v}_year`) !== undefined) $(`#input_b_${v}_year`).val(k.value_b);
                            if((`#input_c_${v}_year`) !== undefined) $(`#input_c_${v}_year`).val(k.value_c);
                            if($(`#input_d_${v}_year`) !== undefined ) $(`#input_d_${v}_year`).val(k.value_d);
                            if($(`#input_resulte_${v}_year`) !== undefined ) $(`#input_resulte_${v}_year`).val(k.result);
                        }          
                    })
                }else{ 
                    for(let i=0; i <= 0 ; i++){ 
                        if((`#check_box_3_year_${i}`) !== undefined )$(`#check_box_3_year_${i}`).prop("checked" , false)
                        if((`#check_box_2_year_${i}`) !== undefined)$(`#check_box_2_year_${i}`).prop("checked" , false)
                        if((`#check_box_1_year_${i}`) !== undefined)$(`#check_box_1_year_${i}`).prop("checked" , false)
                        if((`#check_box_0_year_${i}`) !== undefined)$(`#check_box_0_year_${i}`).prop("checked" , false)
                        if($(`#input_a_${i}_year`) !== undefined) $(`#input_a_${i}_year`).val("") ;   // clear data in input
                        if($(`#input_b_${i}_year`) !== undefined) $(`#input_b_${i}_year`).val("") ;    // clear data in input
                        if((`#input_c_${i}_year`) !== undefined) $(`#input_c_${i}_year`).val("");   // clear data in input
                        if($(`#input_d_${i}_year`) !== undefined ) $(`#input_d_${i}_year`).val("") ;  
                        if($(`#input_resulte_${i}_year`) !== undefined ) $(`#input_resulte_${i}_year`).val("") ;
                    }
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Not found Data",
                        showConfirmButton: false,
                        timer: 1000
                    }); 
                }

            })
        }
        
     const addresluteyear = () => { 
        let dataArray = []
        for(let i = 0 ; i <= 0 ; i++){ 
            dataArray.push({
                month:$(`#year_${i}`).val() , 
                input_a: $(`#input_a_${i}_year`).val() !== undefined ? $(`#input_a_${i}_year`).val() : "" , 
                input_b: $(`#input_b_${i}_year`).val() !== undefined ? $(`#input_b_${i}_year`).val() : "" , 
                input_c: $(`#input_c_${i}_year`).val() !== undefined ? $(`#input_c_${i}_year`).val() : "" , 
                input_d: $(`#input_d_${i}_year`).val() !== undefined ? $(`#input_d_${i}_year`).val() : "" , 
                input_resulte: $(`#input_resulte_${i}_year`).val() !== undefined ?  $(`#input_resulte_${i}_year`).val() :"" , 
                input_checkbox_1:$(`#check_box_0_year_${i}`).val() === undefined ? "": $(`#check_box_0_year_${i}`).prop('checked') ? $(`#check_box_0_year_${i}`).val() : 0   ,
                input_checkbox_2:$(`#check_box_1_year_${i}`).val() === undefined ? "" : $(`#check_box_1_year_${i}`).prop('checked') ? $(`#check_box_1_year_${i}`).val() : 0,
                input_checkbox_3:$(`#check_box_2_year_${i}`).val() === undefined ? "" : $(`#check_box_2_year_${i}`).prop('checked') ? $(`#check_box_2_year_${i}`).val() : 0,
                input_checkbox_4:$(`#check_box_3_year_${i}`).val() === undefined ? "": $(`#check_box_3_year_${i}`).prop('checked') ? $(`#check_box_3_year_${i}`).val() : 0 ,
            })
        }
        $.ajax({ 
                url:"<?= Url::to(["add-resulte"]) ?>" , 
                method:"post" , 
                data: { 
                    kpi_template_id: data , 
                    hcode: $(`#select-hcode-year`).val() ,
                    "<?= Yii::$app->request->csrfParam ?>" : "<?= Yii::$app->request->csrfToken ?>" , 
                    dataForm: dataArray
                }
            }).done((dataReturn) => {
                const Datacheck = JSON.parse(dataReturn) 
                Datacheck.status == "200" ? Swal.fire({
                position: "center",
                icon: "success",
                title: Datacheck.massage,
                showConfirmButton: false,
                timer: 1000
                })
                : Swal.fire({
                position: "center",
                icon: "error",
                title: Datacheck.massage,
                showConfirmButton: false,
                timer: 1000
                }); 
            })  
     }
     const ShowModal = (send_type , SendTypeData) => {  
          if(send_type == 1){ 
                    $(`#modal-month`).modal('show')
                    $(`#kpi_name-month`).html(`ตัวชีวัดหลัก : ${SendTypeData.detail.kpi_main.length === 0 ? "" : SendTypeData.detail.kpi_main[0].name}`)
                    $(`#kpi_child_name-month`).html(`ตัวชีวัดรอง : ${SendTypeData.detail.kpi_child.length  === 0 ? "" : SendTypeData.detail.kpi_child[0].name}` )
                    $(`#kpi_sub_name-month`).html(`ตัวชีวัดย่อย : ${SendTypeData.detail.dataSubChild.length === 0 ? "" : SendTypeData.detail.dataSubChild[0].name}`)
                    $(`#var-a-month`).html(`ตัวแปร A : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_a }`)
                    $(`#var-b-month`).html(`ตัวแปร B : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_b }`)
                    $(`#var-c-month`).html(`ตัวแปร C : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_c === null ? "" :SendTypeData.detail.kpi_tem[0].dic_c  }`)
                    $(`#var-d-month`).html(`ตัวแปร D : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_d === null ? "" 
                        :SendTypeData.detail.kpi_tem[0].dic_d }`)
                    $(`#calculator-month`).html(`วิธีการคำนวณ : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" 
                        : SendTypeData.detail.kpi_tem[0].cal }`)
                    $(`#traget-month`).html(`เป้าหมาย (ร้อยละ/ผ่านระดับ/ผ่านมาตราฐาน/จำนวน) : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" 
                        : SendTypeData.detail.kpi_tem[0].condition +" "+SendTypeData.detail.kpi_tem[0].min_traget }`)
                    $(`#traget-tab-month`).html(`เป้าหมาย (ร้อยละ/ผ่านระดับ/ผ่านมาตราฐาน/จำนวน) : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].min_traget }`)
                    $(`#kpi-dic-tab-month`).html(`คำอธิบายตัวชี้วัด/เกณฑ์อื่น ๆ  : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].tem_dic === null ? "": SendTypeData.detail.kpi_tem[0].tem_dic }`)
                    $(`#condition-month`).html(`เงื่อนไข  : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].condition }`)
                    $(`#date-end-month`).html(`วันสิ้นสุด  : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : "" }`)
                    $(`#sup-people-month`).html(`ผู้รับผิดชอบหลัก : ${ 
                        SendTypeData.detail.managerSub.length !== 0 && SendTypeData.detail.managerSub.length !== undefined ? SendTypeData.detail.managerSub[0].fname + " " + SendTypeData.detail.managerSub[0].lname  
                        : SendTypeData.detail.managerChild.length !== 0 &&  SendTypeData.detail.managerChild.length !== undefined ? SendTypeData.detail.managerChild[0].fname + " " + SendTypeData.detail.managerChild[0].lname 
                        : SendTypeData.detail.managerKPI.length !== 0 &&  SendTypeData.detail.managerKPI.length !== undefined ? SendTypeData.detail.managerKPI[0].fname + " " + SendTypeData.detail.managerKPI[0].lname : '' }`)
                    $(`#unit-month`).html(`หน่วย : ${SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].unit_a}`)
                    $(`.department`).empty()
                    $(`.team`).empty()
                    SendTypeData.detail.Department.forEach((value , key) => { 
                                 $(`.department`).append(` <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 my-1">${value.HR_DEPARTMENT_NAME}</div> 
                                 <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 my-1"><button type="button" class="btn btn-danger" data-index="${value.id}" onclick="deleteData(this)">ลบ</button></div>
                           `)
                    })     
                    SendTypeData.detail.Teams.forEach((value , key) => { 
                                 $(`.team`).append(` <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 my-1">${value.HR_TEAM_NAME}</div> 
                                 <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 my-1"><button type="button" class="btn btn-danger" data-index="${value.id}" onclick="deleteTeams(this)">ลบ</button></div>
                           `)
                    })      
                    
                    let htmlAppand = `` ; 
                    let InputOther = `` ; 
                    //showMonthInput
                    dataSuccess.forEach((i,k) => { 
                        InputOther += `<div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="check_box_${k}_" name="check_box_${k}_" value="${i.id}">
                                            <label class="form-check-label" for="check_box_${k}_">${i.name}</label>
                                        </div>`;
                    })
                    
                    $('#show_month_input').empty() ; 
                    if(SendTypeData.detail.kpi_tem[0].min_traget !== "ผ่าน") {
                        for(let i = 0 ; i <= 11 ; i++){ 
                            htmlAppand = `  
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                <h6 class="my-2"><b>${dataMonth[i].month_name}</b></h6>
                                <input type="hidden" name="month_${i}"  id="month_${i}" value="${dataMonth[i].id}" />
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_a_${i}_month">ตัวแปร A</label>
                            <input type="number" name="input_a_${i}_month" id="input_a_${i}_month" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_b_${i}_month">ตัวแปร B</label>
                            <input type="number" name="input_b_${i}_month" id="input_b_${i}_month" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_c_${i}_month">ตัวแปร C</label>
                            <input type="number" name="input_c_${i}_month" id="input_c_${i}_month" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_d_${i}_month">ตัวแปร D</label>
                            <input type="number" name="input_d_${i}_month" id="input_d_${i}_month" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_resulte_${i}_month">ผลสำเร็จ</label>
                            <input type="number" name="input_resulte_${i}_month" id="input_resulte_${i}_month" class="form-control"  />  
                            </div>
                            ` ; 
                            
                            $(`#show_month_input`).append(htmlAppand) ; 

                            //$(`#input_resulte_${i}_month`).attr("disabled" ,true).val('')   
                            $(`#input_a_${i}_month`).val("")     // clear data in input
                            $(`#input_b_${i}_month`).val("")     // clear data in input
                            $(`#input_c_${i}_month`).val("")     // clear data in input
                            $(`#input_d_${i}_month`).val("")     // clear data in input
                            if(SendTypeData.detail.kpi_tem[0].dic_a === null )$(`#input_a_${i}_month`).attr("disabled" ,true);  
                            if(SendTypeData.detail.kpi_tem[0].dic_b === null) $(`#input_b_${i}_month`).attr("disabled" ,true); 
                            if(SendTypeData.detail.kpi_tem[0].dic_c === null ) $(`#input_c_${i}_month`).attr("disabled" ,true); 
                            if(SendTypeData.detail.kpi_tem[0].dic_d === null) $(`#input_d_${i}_month`).attr("disabled" ,true);  
                            if(SendTypeData.detail.kpi_tem[0].cal !== null || SendTypeData.detail.kpi_tem[0].dic_d == '-')
                            {
                                $(`#input_a_${i}_month`).on('change' , () => { 
                                $(`#input_resulte_${i}_month`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_month`).val().toString())
                                .replace("B" , "1")
                                ).toFixed(2)) ;
                            }) 
                            $(`#input_b_${i}_month`).on('change' , () => { 
                                $(`#input_resulte_${i}_month`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_month`).val().toString())
                                .replace("B" , $(`#input_b_${i}_month`).val().toString())
                                ).toFixed(2)) ;
                            })
                            $(`#input_c_${i}_month`).on('change' , () => { 
                                $(`#input_resulte_${i}_month`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_month`).val().toString())
                                .replace("B" , $(`#input_b_${i}_month`).val().toString())
                                .replace("C" , $(`#input_b_${i}_month`).val().toString())
                                ).toFixed(2)) ;
                            })
                            $(`#input_d_${i}_month`).on('change' , () => { 
                                $(`#input_resulte_${i}_month`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_month`).val().toString())
                                .replace("B" , $(`#input_b_${i}_month`).val().toString())
                                .replace("C" , $(`#input_c_${i}_month`).val().toString())
                                .replace("D" , $(`#input_d_${i}_month`).val().toString()) 
                                ).toFixed(2)) ;
                            })
                            }  
                        }
                   }
                   else { 
                        for(let i = 0 ; i <= 11 ; i++){

                            const StringCheckBox = InputOther.replaceAll(`"check_box_0_"`,`"check_box_0_month_${i}"`)
                            .replaceAll(`"check_box_1_"`,`"check_box_1_month_${i}"`)
                            .replaceAll(`"check_box_2_"`,`"check_box_2_month_${i}"`)
                            .replaceAll(`"check_box_3_"`,`"check_box_3_month_${i}"`);

                            htmlAppand = `
                                <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <h6 class="my-2"><b>${dataMonth[i].month_name}</b></h6>
                                    <input type="hidden" name="month_${i}"  id="month_${i}" value="${dataMonth[i].id}" />
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10"> 
                                      ${ StringCheckBox }
                                </div>
                            ` ;
                            $('#show_month_input').append(htmlAppand) ; 

                            $(`#check_box_0_month_${i}`).on('change' , () => { 
                                $(`#check_box_1_month_${i}`).prop( "checked", false )
                                $(`#check_box_2_month_${i}`).prop( "checked", false )
                                $(`#check_box_3_month_${i}`).prop( "checked", false )
                            })
                            $(`#check_box_1_month_${i}`).on('change' , () => { 
                                $(`#check_box_0_month_${i}`).prop( "checked", false )
                                $(`#check_box_2_month_${i}`).prop( "checked", false )
                                $(`#check_box_3_month_${i}`).prop( "checked", false )
                            })
                            $(`#check_box_2_month_${i}`).on('change' , () => { 
                                $(`#check_box_0_month_${i}`).prop( "checked", false )
                                $(`#check_box_1_month_${i}`).prop( "checked", false )
                                $(`#check_box_3_month_${i}`).prop( "checked", false )
                            })
                            $(`#check_box_3_month_${i}`).on('change' , () => { 
                                $(`#check_box_0_month_${i}`).prop( "checked", false )
                                $(`#check_box_1_month_${i}`).prop( "checked", false )
                                $(`#check_box_2_month_${i}`).prop( "checked", false )
                            })


                        }
                   }

          }
          else if(send_type == 2 ){ 
                    $(`#modal-quarter`).modal('show')
                    $(`#kpi_name-quarter`).html(`ตัวชีวัดหลัก : ${SendTypeData.detail.kpi_main.length === 0 ? "" : SendTypeData.detail.kpi_main[0].name}`)
                    $(`#kpi_child_name-quarter`).html(`ตัวชีวัดรอง : ${SendTypeData.detail.kpi_child.length  === 0 ? "" : SendTypeData.detail.kpi_child[0].name}` )
                    $(`#kpi_sub_name-quarter`).html(`ตัวชีวัดย่อย : ${SendTypeData.detail.dataSubChild.length === 0 ? "" : SendTypeData.detail.dataSubChild[0].name}`)
                    $(`#var-a-quarter`).html(`ตัวแปร A : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_a }`)
                    $(`#var-b-quarter`).html(`ตัวแปร B : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_b }`)
                    $(`#var-c-quarter`).html(`ตัวแปร C : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_c === null ? "" :SendTypeData.detail.kpi_tem[0].dic_c  }`)
                    $(`#var-d-quarter`).html(`ตัวแปร D : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_d === null ? "" 
                        :SendTypeData.detail.kpi_tem[0].dic_d }`)
                    $(`#calculator-quarter`).html(`วิธีการคำนวณ : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" 
                        : SendTypeData.detail.kpi_tem[0].cal }`)
                    $(`#traget-quarter`).html(`เป้าหมาย (ร้อยละ/ผ่านระดับ/ผ่านมาตราฐาน/จำนวน) : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" 
                        : SendTypeData.detail.kpi_tem[0].condition +" "+SendTypeData.detail.kpi_tem[0].min_traget }`)
                    $(`#traget-tab-quarter`).html(`เป้าหมาย (ร้อยละ/ผ่านระดับ/ผ่านมาตราฐาน/จำนวน) : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].min_traget }`)
                    $(`#kpi-dic-tab-quarter`).html(`คำอธิบายตัวชี้วัด/เกณฑ์อื่น ๆ  : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].tem_dic === null ? "": SendTypeData.detail.kpi_tem[0].tem_dic }`)
                    $(`#condition-quarter`).html(`เงื่อนไข  : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].condition }`)
                    $(`#date-end-quarter`).html(`วันสิ้นสุด  : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : "" }`)
                    $(`#sup-people-quarter`).html(`ผู้รับผิดชอบหลัก : ${ 
                        SendTypeData.detail.managerSub.length !== 0 && SendTypeData.detail.managerSub.length !== undefined ? SendTypeData.detail.managerSub[0].fname + " " + SendTypeData.detail.managerSub[0].lname  
                        : SendTypeData.detail.managerChild.length !== 0 &&  SendTypeData.detail.managerChild.length !== undefined ? SendTypeData.detail.managerChild[0].fname + " " + SendTypeData.detail.managerChild[0].lname 
                        : SendTypeData.detail.managerKPI.length !== 0 && SendTypeData.detail.managerKPI.length !== undefined ? SendTypeData.detail.managerKPI[0].fname + " " + SendTypeData.detail.managerKPI[0].lname : '' }`)
                    $(`#unit-quarter`).html(`หน่วย : ${SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].unit_a}`)
                    $(`.department`).empty()
                    $(`.team`).empty()
                    SendTypeData.detail.Department.forEach((value , key) => { 
                                 $(`.department`).append(` <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 my-1">${value.HR_DEPARTMENT_NAME}</div> 
                                 <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 my-1"><button type="button" class="btn btn-danger" data-index="${value.id}" onclick="deleteData(this)">ลบ</button></div>
                           `)
                    })     
                    SendTypeData.detail.Teams.forEach((value , key) => { 
                                 $(`.team`).append(` <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 my-1">${value.HR_TEAM_NAME}</div> 
                                 <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 my-1"><button type="button" class="btn btn-danger" data-index="${value.id}" onclick="deleteTeams(this)">ลบ</button></div>
                           `)
                    })      
                    let htmlAppand = `` ; 
                    let InputOther = `` ; 
                    //showquarterInput
                    dataSuccess.forEach((i,k) => { 
                        InputOther += `<div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="check_box_${k}_" name="check_box_${k}_" value="${i.id}">
                                            <label class="form-check-label" for="check_box_${k}_">${i.name}</label>
                                        </div>`;
                    })
                    
                    $('#show_quarter_input').empty() ; 
                    if(SendTypeData.detail.kpi_tem[0].min_traget !== "ผ่าน") {
                        for(let i = 0 ; i <= 3 ; i++){ 
                            htmlAppand = `  
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                <h6 class="my-2"><b>ไตรมาสที่ ${i}</b></h6>
                                <input type="hidden" name="quarter_${i}"  id="quarter_${i}" value="${i}" />
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_a_${i}_quarter">ตัวแปร A</label>
                            <input type="number" name="input_a_${i}_quarter" id="input_a_${i}_quarter" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_b_${i}_quarter">ตัวแปร B</label>
                            <input type="number" name="input_b_${i}_quarter" id="input_b_${i}_quarter" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_c_${i}_quarter">ตัวแปร C</label>
                            <input type="number" name="input_c_${i}_quarter" id="input_c_${i}_quarter" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_d_${i}_quarter">ตัวแปร D</label>
                            <input type="number" name="input_d_${i}_quarter" id="input_d_${i}_quarter" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_resulte_${i}_quarter">ผลสำเร็จ</label>
                            <input type="number" name="input_resulte_${i}_quarter" id="input_resulte_${i}_quarter" class="form-control"  />  
                            </div>
                            ` ; 
                            
                            $(`#show_quarter_input`).append(htmlAppand) ; 
                            //$(`#input_resulte_${i}_quarter`).attr("disabled" ,true).val('')   
                            $(`#input_a_${i}_quarter`).val("")     // clear data in input
                            $(`#input_b_${i}_quarter`).val("")     // clear data in input
                            $(`#input_c_${i}_quarter`).val("")     // clear data in input
                            $(`#input_d_${i}_quarter`).val("")     // clear data in input
                            if(SendTypeData.detail.kpi_tem[0].dic_a === null )$(`#input_a_${i}_quarter`).attr("disabled" ,true);  
                            if(SendTypeData.detail.kpi_tem[0].dic_b === null) $(`#input_b_${i}_quarter`).attr("disabled" ,true); 
                            if(SendTypeData.detail.kpi_tem[0].dic_c === null) $(`#input_c_${i}_quarter`).attr("disabled" ,true); 
                            if(SendTypeData.detail.kpi_tem[0].dic_d === null) $(`#input_d_${i}_quarter`).attr("disabled" ,true);  
                            if(SendTypeData.detail.kpi_tem[0].cal !== null || SendTypeData.detail.kpi_tem[0].dic_d == '-')
                            {
                            $(`#input_a_${i}_quarter`).on('change' , () => { 
                                $(`#input_resulte_${i}_quarter`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_quarter`).val().toString())
                                .replace("B" , "1")
                                ).toFixed(2)) ;
                            }) 
                            $(`#input_b_${i}_quarter`).on('change' , () => { 
                                $(`#input_resulte_${i}_quarter`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_quarter`).val().toString())
                                .replace("B" , $(`#input_b_${i}_quarter`).val().toString())
                                ).toFixed(2)) ;
                            })
                            $(`#input_c_${i}_quarter`).on('change' , () => { 
                                $(`#input_resulte_${i}_quarter`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_quarter`).val().toString())
                                .replace("B" , $(`#input_b_${i}_quarter`).val().toString())
                                .replace("C" , $(`#input_b_${i}_quarter`).val().toString())
                                ).toFixed(2)) ;
                            })
                            $(`#input_d_${i}_quarter`).on('change' , () => { 
                                $(`#input_resulte_${i}_quarter`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_quarter`).val().toString())
                                .replace("B" , $(`#input_b_${i}_quarter`).val().toString())
                                .replace("C" , $(`#input_c_${i}_quarter`).val().toString())
                                .replace("D" , $(`#input_d_${i}_quarter`).val().toString()) 
                                ).toFixed(2)) ;
                            })
                          }
                        }
                   }
                   else { 
                        for(let i = 0 ; i <= 3 ; i++){
                            const StringCheckBox = InputOther.replaceAll(`"check_box_0_"`,`"check_box_0_quarter_${i}"`)
                            .replaceAll(`"check_box_1_"`,`"check_box_1_quarter_${i}"`)
                            .replaceAll(`"check_box_2_"`,`"check_box_2_quarter_${i}"`)
                            .replaceAll(`"check_box_3_"`,`"check_box_3_quarter_${i}"`);

                            htmlAppand = `
                                <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <h6 class="my-2"><b>${dataquarter[i].quarter_name}</b></h6>
                                    <input type="hidden" name="quarter_${i}"  id="quarter_${i}" value="${dataquarter[i].id}" />
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10"> 
                                      ${ StringCheckBox }
                                </div>
                            ` ;
                            $('#show_quarter_input').append(htmlAppand) ; 
                            if(SendTypeData.detail.kpi_tem[0].cal != null || SendTypeData.detail.kpi_tem[0].dic_d == '-')
                            {
                            $(`#check_box_0_quarter_${i}`).on('change' , () => { 
                                $(`#check_box_1_quarter_${i}`).prop( "checked", false )
                                $(`#check_box_2_quarter_${i}`).prop( "checked", false )
                                $(`#check_box_3_quarter_${i}`).prop( "checked", false )
                            })
                            $(`#check_box_1_quarter_${i}`).on('change' , () => { 
                                $(`#check_box_0_quarter_${i}`).prop( "checked", false )
                                $(`#check_box_2_quarter_${i}`).prop( "checked", false )
                                $(`#check_box_3_quarter_${i}`).prop( "checked", false )
                            })
                            $(`#check_box_2_quarter_${i}`).on('change' , () => { 
                                $(`#check_box_0_quarter_${i}`).prop( "checked", false )
                                $(`#check_box_1_quarter_${i}`).prop( "checked", false )
                                $(`#check_box_3_quarter_${i}`).prop( "checked", false )
                            })
                            $(`#check_box_3_quarter_${i}`).on('change' , () => { 
                                $(`#check_box_0_quarter_${i}`).prop( "checked", false )
                                $(`#check_box_1_quarter_${i}`).prop( "checked", false )
                                $(`#check_box_2_quarter_${i}`).prop( "checked", false )
                            })
                          }

                        }
                   }    
          }
          else if(send_type == 3 ){ 
                    $(`#modal-half`).modal('show')
                    $(`#kpi_name-half`).html(`ตัวชีวัดหลัก : ${SendTypeData.detail.kpi_main.length === 0 ? "" : SendTypeData.detail.kpi_main[0].name}`)
                    $(`#kpi_child_name-half`).html(`ตัวชีวัดรอง : ${SendTypeData.detail.kpi_child.length  === 0 ? "" : SendTypeData.detail.kpi_child[0].name}` )
                    $(`#kpi_sub_name-half`).html(`ตัวชีวัดย่อย : ${SendTypeData.detail.dataSubChild.length === 0 ? "" : SendTypeData.detail.dataSubChild[0].name}`)
                    $(`#var-a-half`).html(`ตัวแปร A : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_a }`)
                    $(`#var-b-half`).html(`ตัวแปร B : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_b }`)
                    $(`#var-c-half`).html(`ตัวแปร C : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_c === null ? "" :SendTypeData.detail.kpi_tem[0].dic_c  }`)
                    $(`#var-d-half`).html(`ตัวแปร D : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_d === null ? "" 
                        :SendTypeData.detail.kpi_tem[0].dic_d }`)
                    $(`#calculator-half`).html(`วิธีการคำนวณ : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" 
                        : SendTypeData.detail.kpi_tem[0].cal }`)
                    $(`#traget-half`).html(`เป้าหมาย (ร้อยละ/ผ่านระดับ/ผ่านมาตราฐาน/จำนวน) : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" 
                        : SendTypeData.detail.kpi_tem[0].condition +" "+SendTypeData.detail.kpi_tem[0].min_traget }`)
                    $(`#traget-tab-half`).html(`เป้าหมาย (ร้อยละ/ผ่านระดับ/ผ่านมาตราฐาน/จำนวน) : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].min_traget }`)
                    $(`#kpi-dic-tab-half`).html(`คำอธิบายตัวชี้วัด/เกณฑ์อื่น ๆ  : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].tem_dic === null ? "": SendTypeData.detail.kpi_tem[0].tem_dic }`)
                    $(`#condition-half`).html(`เงื่อนไข  : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].condition }`)
                    $(`#date-end-half`).html(`วันสิ้นสุด  : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : "" }`)
                    $(`#sup-people-half`).html(`ผู้รับผิดชอบหลัก : ${ 
                        SendTypeData.detail.managerSub.length !== 0 && SendTypeData.detail.managerSub.length !== undefined ? SendTypeData.detail.managerSub[0].fname + " " + SendTypeData.detail.managerSub[0].lname  
                        : SendTypeData.detail.managerChild.length !== 0 &&  SendTypeData.detail.managerChild.length !== undefined ? SendTypeData.detail.managerChild[0].fname + " " + SendTypeData.detail.managerChild[0].lname 
                        : SendTypeData.detail.managerKPI.length !== 0 &&  SendTypeData.detail.managerKPI.length !== undefined ? SendTypeData.detail.managerKPI[0].fname + " " + SendTypeData.detail.managerKPI[0].lname : ''}`)
                    $(`#unit-half`).html(`หน่วย : ${SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].unit_a}`)
                    $(`.department`).empty()
                    $(`.team`).empty()
                    SendTypeData.detail.Department.forEach((value , key) => { 
                                 $(`.department`).append(` <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 my-1">${value.HR_DEPARTMENT_NAME}</div> 
                                 <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 my-1"><button type="button" class="btn btn-danger" data-index="${value.id}" onclick="deleteData(this)">ลบ</button></div>
                           `)
                    })     
                    SendTypeData.detail.Teams.forEach((value , key) => { 
                                 $(`.team`).append(` <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 my-1">${value.HR_TEAM_NAME}</div> 
                                 <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 my-1"><button type="button" class="btn btn-danger" data-index="${value.id}" onclick="deleteTeams(this)">ลบ</button></div>
                           `)
                    })      
                    
                    let htmlAppand = `` ; 
                    let InputOther = `` ; 
                    //showhalfInput
                    dataSuccess.forEach((i,k) => { 
                        InputOther += `<div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="check_box_${k}_" name="check_box_${k}_" value="${i.id}">
                                            <label class="form-check-label" for="check_box_${k}_">${i.name}</label>
                                        </div>`;
                    })
                    
                    $('#show_half_input').empty() ; 
                    if(SendTypeData.detail.kpi_tem[0].min_traget !== "ผ่าน") {
                        for(let i = 0 ; i <= 1 ; i++){ 
                            htmlAppand = `  
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                <h6 class="my-2"><b>ครั้งที่ ${i+1}</b></h6>
                                <input type="hidden" name="half_${i}"  id="half_${i}" value="${i+1}" />
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_a_${i}_half">ตัวแปร A</label>
                            <input type="number" name="input_a_${i}_half" id="input_a_${i}_half" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_b_${i}_half">ตัวแปร B</label>
                            <input type="number" name="input_b_${i}_half" id="input_b_${i}_half" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_c_${i}_half">ตัวแปร C</label>
                            <input type="number" name="input_c_${i}_half" id="input_c_${i}_half" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_d_${i}_half">ตัวแปร D</label>
                            <input type="number" name="input_d_${i}_half" id="input_d_${i}_half" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_resulte_${i}_half">ผลสำเร็จ</label>
                            <input type="number" name="input_resulte_${i}_half" id="input_resulte_${i}_half" class="form-control"  />  
                            </div>
                            ` ; 
                            
                            $(`#show_half_input`).append(htmlAppand) ; 

                            //$(`#input_resulte_${i}_half`).attr("disabled" ,true).val('')   
                            $(`#input_a_${i}_half`).val("")     // clear data in input
                            $(`#input_b_${i}_half`).val("")     // clear data in input
                            $(`#input_c_${i}_half`).val("")     // clear data in input
                            $(`#input_d_${i}_half`).val("")     // clear data in input
                            if(SendTypeData.detail.kpi_tem[0].dic_a === null )$(`#input_a_${i}_half`).attr("disabled" ,true);  
                            if(SendTypeData.detail.kpi_tem[0].dic_b === null) $(`#input_b_${i}_half`).attr("disabled" ,true); 
                            if(SendTypeData.detail.kpi_tem[0].dic_c === null) $(`#input_c_${i}_half`).attr("disabled" ,true); 
                            if(SendTypeData.detail.kpi_tem[0].dic_d === null) $(`#input_d_${i}_half`).attr("disabled" ,true);  
                        if(SendTypeData.detail.kpi_tem[0].cal !== null || SendTypeData.detail.kpi_tem[0].dic_d == '-')
                            {
                            $(`#input_a_${i}_half`).on('change' , () => { 
                                $(`#input_resulte_${i}_half`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_half`).val().toString())
                                .replace("B" , "1")
                                ).toFixed(2)) ;
                            }) 
                            $(`#input_b_${i}_half`).on('change' , () => { 
                                $(`#input_resulte_${i}_half`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_half`).val().toString())
                                .replace("B" , $(`#input_b_${i}_half`).val().toString())
                                ).toFixed(2)) ;
                            })
                            $(`#input_c_${i}_half`).on('change' , () => { 
                                $(`#input_resulte_${i}_half`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_half`).val().toString())
                                .replace("B" , $(`#input_b_${i}_half`).val().toString())
                                .replace("C" , $(`#input_b_${i}_half`).val().toString())
                                ).toFixed(2)) ;
                            })
                            $(`#input_d_${i}_half`).on('change' , () => { 
                                $(`#input_resulte_${i}_half`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_half`).val().toString())
                                .replace("B" , $(`#input_b_${i}_half`).val().toString())
                                .replace("C" , $(`#input_c_${i}_half`).val().toString())
                                .replace("D" , $(`#input_d_${i}_half`).val().toString()) 
                                ).toFixed(2)) ;
                            })
                          }
                        }
                   }
                   else { 
                        for(let i = 0 ; i <= 1 ; i++){

                            const StringCheckBox = InputOther.replaceAll(`"check_box_0_"`,`"check_box_0_half_${i}"`)
                            .replaceAll(`"check_box_1_"`,`"check_box_1_half_${i}"`)
                            .replaceAll(`"check_box_2_"`,`"check_box_2_half_${i}"`)
                            .replaceAll(`"check_box_3_"`,`"check_box_3_half_${i}"`);

                            htmlAppand = `
                                <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <h6 class="my-2"><b>ครั้งที่ ${i+1}</b></h6>
                                    <input type="hidden" name="half_${i}"  id="half_${i}" value="${i+1}" />
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10"> 
                                      ${ StringCheckBox }
                                </div>
                            ` ;
                            $('#show_half_input').append(htmlAppand) ; 

                            $(`#check_box_0_half_${i}`).on('change' , () => { 
                                $(`#check_box_1_half_${i}`).prop( "checked", false )
                                $(`#check_box_2_half_${i}`).prop( "checked", false )
                                $(`#check_box_3_half_${i}`).prop( "checked", false )
                            })
                            $(`#check_box_1_half_${i}`).on('change' , () => { 
                                $(`#check_box_0_half_${i}`).prop( "checked", false )
                                $(`#check_box_2_half_${i}`).prop( "checked", false )
                                $(`#check_box_3_half_${i}`).prop( "checked", false )
                            })
                            $(`#check_box_2_half_${i}`).on('change' , () => { 
                                $(`#check_box_0_half_${i}`).prop( "checked", false )
                                $(`#check_box_1_half_${i}`).prop( "checked", false )
                                $(`#check_box_3_half_${i}`).prop( "checked", false )
                            })
                            $(`#check_box_3_half_${i}`).on('change' , () => { 
                                $(`#check_box_0_half_${i}`).prop( "checked", false )
                                $(`#check_box_1_half_${i}`).prop( "checked", false )
                                $(`#check_box_2_half_${i}`).prop( "checked", false )
                            })


                        }
                   }
          }
          else if(send_type == 4){ 
                    $(`#modal-year`).modal('show')
                    $(`#kpi_name-year`).html(`ตัวชีวัดหลัก : ${SendTypeData.detail.kpi_main.length === 0 ? "" : SendTypeData.detail.kpi_main[0].name}`)
                    $(`#kpi_child_name-year`).html(`ตัวชีวัดรอง : ${SendTypeData.detail.kpi_child.length  === 0 ? "" : SendTypeData.detail.kpi_child[0].name}` )
                    $(`#kpi_sub_name-year`).html(`ตัวชีวัดย่อย : ${SendTypeData.detail.dataSubChild.length === 0 ? "" : SendTypeData.detail.dataSubChild[0].name}`)
                    $(`#var-a-year`).html(`ตัวแปร A : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_a }`)
                    $(`#var-b-year`).html(`ตัวแปร B : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_b }`)
                    $(`#var-c-year`).html(`ตัวแปร C : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_c === null ? "" :SendTypeData.detail.kpi_tem[0].dic_c  }`)
                    $(`#var-d-year`).html(`ตัวแปร D : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].dic_d === null ? "" 
                        :SendTypeData.detail.kpi_tem[0].dic_d }`)
                    $(`#calculator-year`).html(`วิธีการคำนวณ : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" 
                        : SendTypeData.detail.kpi_tem[0].cal }`)
                    $(`#traget-year`).html(`เป้าหมาย (ร้อยละ/ผ่านระดับ/ผ่านมาตราฐาน/จำนวน) : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" 
                        : SendTypeData.detail.kpi_tem[0].condition +" "+SendTypeData.detail.kpi_tem[0].min_traget }`)
                    $(`#traget-tab-year`).html(`เป้าหมาย (ร้อยละ/ผ่านระดับ/ผ่านมาตราฐาน/จำนวน) : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].min_traget }`)
                    $(`#kpi-dic-tab-year`).html(`คำอธิบายตัวชี้วัด/เกณฑ์อื่น ๆ  : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].tem_dic === null ? "": SendTypeData.detail.kpi_tem[0].tem_dic }`)
                    $(`#condition-year`).html(`เงื่อนไข  : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].condition }`)
                    $(`#date-end-year`).html(`วันสิ้นสุด  : ${ SendTypeData.detail.kpi_tem.length === 0 ? "" : "" }`)
                    $(`#sup-people-year`).html(`ผู้รับผิดชอบหลัก : ${ 
                        SendTypeData.detail.managerSub.length !== 0 && SendTypeData.detail.managerSub.length !== undefined ? SendTypeData.detail.managerSub[0].fname + " " + SendTypeData.detail.managerSub[0].lname  
                        : SendTypeData.detail.managerChild.length !== 0 && SendTypeData.detail.managerChild.length !== undefined ? SendTypeData.detail.managerChild[0].fname + " " + SendTypeData.detail.managerChild[0].lname 
                        : SendTypeData.detail.managerKPI.length !== 0 &&  SendTypeData.detail.managerKPI.length !== undefined ? SendTypeData.detail.managerKPI[0].fname + " " + SendTypeData.detail.managerKPI[0].lname : '' }`)
                    $(`#unit-year`).html(`หน่วย : ${SendTypeData.detail.kpi_tem.length === 0 ? "" : SendTypeData.detail.kpi_tem[0].unit_a}`)
                    $(`.department`).empty()
                    $(`.team`).empty()
                    SendTypeData.detail.Department.forEach((value , key) => { 
                                 $(`.department`).append(` <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 my-1">${value.HR_DEPARTMENT_NAME}</div> 
                                 <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 my-1"><button type="button" class="btn btn-danger" data-index="${value.id}" onclick="deleteData(this)">ลบ</button></div>
                           `)
                    })     
                    SendTypeData.detail.Teams.forEach((value , key) => { 
                                 $(`.team`).append(` <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 my-1">${value.HR_TEAM_NAME}</div> 
                                 <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 my-1"><button type="button" class="btn btn-danger" data-index="${value.id}" onclick="deleteTeams(this)">ลบ</button></div>
                           `)
                    })      
                    
                    let htmlAppand = `` ; 
                    let InputOther = `` ; 
                    //showyearInput
                    dataSuccess.forEach((i,k) => { 
                        InputOther += `<div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="check_box_${k}_" name="check_box_${k}_" value="${i.id}">
                                            <label class="form-check-label" for="check_box_${k}_">${i.name}</label>
                                        </div>`;
                    })
                    
                    $('#show_year_input').empty() ; 
                    if(SendTypeData.detail.kpi_tem[0].min_traget !== "ผ่าน") {
                        for(let i = 0 ; i <= 0 ; i++){ 
                            htmlAppand = `  
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                <h6 class="my-2"><b>ครั้งที่ ${i+1}</b></h6>
                                <input type="hidden" name="year_${i}"  id="year_${i}" value="${i+1}" />
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_a_${i}_year">ตัวแปร A</label>
                            <input type="number" name="input_a_${i}_year" id="input_a_${i}_year" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_b_${i}_year">ตัวแปร B</label>
                            <input type="number" name="input_b_${i}_year" id="input_b_${i}_year" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_c_${i}_year">ตัวแปร C</label>
                            <input type="number" name="input_c_${i}_year" id="input_c_${i}_year" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_d_${i}_year">ตัวแปร D</label>
                            <input type="number" name="input_d_${i}_year" id="input_d_${i}_year" class="form-control"  />  
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <label for="input_resulte_${i}_year">ผลสำเร็จ</label>
                            <input type="number" name="input_resulte_${i}_year" id="input_resulte_${i}_year" class="form-control"  />  
                            </div>
                            ` ; 
                            
                            $(`#show_year_input`).append(htmlAppand) ; 

                            //$(`#input_resulte_${i}_year`).attr("disabled" ,true).val('')   
                            $(`#input_a_${i}_year`).val("")     // clear data in input
                            $(`#input_b_${i}_year`).val("")     // clear data in input
                            $(`#input_c_${i}_year`).val("")     // clear data in input
                            $(`#input_d_${i}_year`).val("")     // clear data in input
                            if(SendTypeData.detail.kpi_tem[0].dic_a === null )$(`#input_a_${i}_year`).attr("disabled" ,true);  
                            if(SendTypeData.detail.kpi_tem[0].dic_b === null) $(`#input_b_${i}_year`).attr("disabled" ,true); 
                            if(SendTypeData.detail.kpi_tem[0].dic_c === null) $(`#input_c_${i}_year`).attr("disabled" ,true); 
                            if(SendTypeData.detail.kpi_tem[0].dic_d === null) $(`#input_d_${i}_year`).attr("disabled" ,true);  
                            if(SendTypeData.detail.kpi_tem[0].cal !== null || SendTypeData.detail.kpi_tem[0].dic_d == '-')
                            {
                            $(`#input_a_${i}_year`).on('change' , () => { 
                                $(`#input_resulte_${i}_year`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_year`).val().toString())
                                .replace("B" , "1")
                                ).toFixed(2)) ;
                            }) 
                            $(`#input_b_${i}_year`).on('change' , () => { 
                                $(`#input_resulte_${i}_year`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_year`).val().toString())
                                .replace("B" , $(`#input_b_${i}_year`).val().toString())
                                ).toFixed(2)) ;
                            })
                            $(`#input_c_${i}_year`).on('change' , () => { 
                                $(`#input_resulte_${i}_year`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_year`).val().toString())
                                .replace("B" , $(`#input_b_${i}_year`).val().toString())
                                .replace("C" , $(`#input_b_${i}_year`).val().toString())
                                ).toFixed(2)) ;
                            })
                            $(`#input_d_${i}_year`).on('change' , () => { 
                                $(`#input_resulte_${i}_year`).val( math.evaluate(SendTypeData.detail.kpi_tem[0].cal
                                .replace("A" , $(`#input_a_${i}_year`).val().toString())
                                .replace("B" , $(`#input_b_${i}_year`).val().toString())
                                .replace("C" , $(`#input_c_${i}_year`).val().toString())
                                .replace("D" , $(`#input_d_${i}_year`).val().toString()) 
                                ).toFixed(2)) ;
                            })
                            }
                        }
                   }
                   else { 
                        for(let i = 0 ; i <= 0 ; i++){

                            const StringCheckBox = InputOther.replaceAll(`"check_box_0_"`,`"check_box_0_year_${i}"`)
                            .replaceAll(`"check_box_1_"`,`"check_box_1_year_${i}"`)
                            .replaceAll(`"check_box_2_"`,`"check_box_2_year_${i}"`)
                            .replaceAll(`"check_box_3_"`,`"check_box_3_year_${i}"`);

                            htmlAppand = `
                                <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <h6 class="my-2"><b>ครั้งที่ ${i+1}</b></h6>
                                    <input type="hidden" name="year_${i}"  id="year_${i}" value="${i+1}" />
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10"> 
                                      ${ StringCheckBox }
                                </div>
                            ` ;
                            $('#show_year_input').append(htmlAppand) ; 
                            $(`#check_box_0_year_${i}`).on('change' , () => { 
                                $(`#check_box_1_year_${i}`).prop( "checked", false )
                                $(`#check_box_2_year_${i}`).prop( "checked", false )
                                $(`#check_box_3_year_${i}`).prop( "checked", false )
                            })
                            $(`#check_box_1_year_${i}`).on('change' , () => { 
                                $(`#check_box_0_year_${i}`).prop( "checked", false )
                                $(`#check_box_2_year_${i}`).prop( "checked", false )
                                $(`#check_box_3_year_${i}`).prop( "checked", false )
                            })
                            $(`#check_box_2_year_${i}`).on('change' , () => { 
                                $(`#check_box_0_year_${i}`).prop( "checked", false )
                                $(`#check_box_1_year_${i}`).prop( "checked", false )
                                $(`#check_box_3_year_${i}`).prop( "checked", false )
                            })
                            $(`#check_box_3_year_${i}`).on('change' , () => { 
                                $(`#check_box_0_year_${i}`).prop( "checked", false )
                                $(`#check_box_1_year_${i}`).prop( "checked", false )
                                $(`#check_box_2_year_${i}`).prop( "checked", false )
                            })
                        }
                   }
          }
          else{
                    $(`#modal-month`).modal('Close')
                    $(`#modal-quarter`).modal('Close')
                    $(`#modal-half`).modal('Close')
                    $(`#modal-year`).modal('Close')
          }
     }  
</script>
