<?php
echo $this->element("Helper/jqueryhelper");
?>
<script type="text/javascript">
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    $(document).ready(function () {
        
         $('#datalist').dataTable({
        "iDisplayLength": 5,
                "aLengthMenu": [[5, 10, 15, 20, - 1], [5, 10, 15, 20, "All"]]
        });
        /*$("#editdist").click(function () {
            var distid = $("#distid").val();
            
            alert(distid);
        });*/


        $('#district_id').change(function () {
            var district_id = $('#district_id').val();
            //alert(district_id);
            $.postJSON('getsubdivisiondist', {district_id: district_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
            {
                var sc = '<option value="">--select--</option>';
                $.each(data, function (index, val) {

                    sc += "<option value=" + index + ">" + val + "</option>";
                });
                $("#subdivision_id option").remove();
                $("#subdivision_id").append(sc);
            });
        });

    });
    
        /// jquery with ajax working code
        function talukaedit(talukaid,distid, talukaname,subdiv_id,taluka_code,census_code_2001,census_code_2011,census_code_2021,id){
            //alert(distid);
            //alert(subdiv_id);
            $('#taluka_name_en').val(talukaname);
            $('#district_id').val(distid);
            $('#subdivision_id').val(subdiv_id);
            $('#taluka_code').val(taluka_code);
            $('#updatetaukaid').val(talukaid);
            $('#updateid').val(id);
            $('#census_code_2001').val(census_code_2001);
            $('#census_code_2011').val(census_code_2011);
            $('#census_code_2021').val(census_code_2021);
            $('#hfaction').val('U');
            $('#btnadd').val('Update');
            return false;
            /*var path="<?php //echo $this->Url->webroot ?>districtedit";
            $.ajax({
                type:"POST",
                url:path,
                data:{distid: distid},
                headers: { 'X-CSRF-Token': $('[name="_csrfToken"]').val()},
                success:function(result){
                    // on sucess whatever you want to do.
                    alert(result);
                    $("#district_fields").html(data);
                }
            });*/

  
        }
        
</script>
<?= $this->Flash->render() ?>
<?= $this->Form->create() ?>
<?php 
$isubdiv = $admconfigarr[0]->is_subdiv;
echo $this->Form->input('state_id', array('label' => false, 'id' => 'state_id', 'class' => 'form-control', 'value' => $state_id, 'type' => 'hidden', 'autocomplete'=> 'off')); ?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>Taluka Entry</b></h3>
    </div>
    <form class="form-horizontal">
        <div class="card-body">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('Please Select District'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->select('district_id', $districtlistdata, ['id' => 'district_id','empty' =>'--select--']); ?>
                    
                    <div  class="arrow-up district_id_error"></div>
                    <div id="district_id_error" class="form-error district_id_error"></div>
                </div>
                <?php 
                if($isubdiv=='Y'){
                ?>
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('Please Select Sub division'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->select('subdivision_id',$subdivisionlistdata, ['id' => 'subdivision_id','empty' =>'--select--']); ?>
                    
                    <div  class="arrow-up subdivision_id_error"></div>
                    <div id="subdivision_id_error" class="form-error subdivision_id_error"></div>
                </div>
                <?php } ?>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('Please Enter Taluka Name'); ?></label>
                <div class="col-sm-4">
                   <?= $this->Form->control('taluka_name_en', ['id'=>'taluka_name_en','required' => true,'label' => false]) ?>                    
                    <div  class="arrow-up taluka_name_en_error"></div>
                    <div id="taluka_name_en_error" class="form-error taluka_name_en_error"></div>
                </div>
                 <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('Please Enter Taluka Code'); ?></label>
                <div class="col-sm-4">
                     <?= $this->Form->control('taluka_code', ['id'=>'taluka_code','required' => true,'label' => false]) ?>
                    <div  class="arrow-up taluka_code_error"></div>
                    <div id="taluka_code_error" class="form-error taluka_code_error"></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('Please Enter Census code 2001'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->control('census_code_2001', ['id'=>'census_code_2001','required' => true,'label' => false]) ?>                
                    <div  class="arrow-up census_code_2001_error"></div>
                    <div id="census_code_2001_error" class="form-error census_code_2001_error"></div>
                </div>
                 <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('Please Enter Census code 2011'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->control('census_code_2011', ['id'=>'census_code_2011','required' => true,'label' => false]) ?>
                    <div  class="arrow-up census_code_2011_error"></div>
                    <div id="census_code_2011_error" class="form-error census_code_2011_error"></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('Please Enter Census code 2021'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->control('census_code_2021', ['id'=>'census_code_2021','required' => true,'label' => false]) ?>          
                    <div  class="arrow-up census_code_2021_error"></div>
                    <div id="census_code_2021_error" class="form-error census_code_2021_error"></div>
                </div>
                
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    
                    <?= $this->Form->submit('Add', ['id'=>'btnadd','class'=>"btn btn-success"]); ?>
                    <?php
                     echo $this->Form->control('updatetaukaid', ['type'=>'hidden','id'=> 'updatetaukaid','value' => '','label' => false]); 
                     echo $this->Form->control('updateid', ['type'=>'hidden','id'=> 'updateid','value' => '','label' => false]); 
                     echo $this->Form->control('hfaction', ['type'=>'hidden','id'=> 'hfaction','value' => '','label' => false]);
                    ?>
           
                </div>
            </div>
        </div>
   


        <div class="card-body">
            <div class="form-group row">
                <div class="col-sm-12">
                    <table class="table" border="1" id="datalist">
                        <thead>
                            <tr>
                                <th>Sr. No</th>
                                <th>State ID</th>
                                <th>District Name</th>
                                <th>Taluka Name</th>
                                <th>Taluka Code</th>
                                <th>Census Code 2001</th>
                                <th>Census Code 2011</th>
                                <th>Census Code 2021</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php   
                             $w=1;
                            foreach ($talukalistdata as $value){ 
                           // pr($value);
                            ?>
                            <tr>
                                <td>
                                    <?php  echo $w;$w++;?> 
                                </td>  
                                <td>
                                <?php  echo $value['state_id'];?> 
                                </td>
                                <td>
                                <?php echo $value['District']['district_name_en']; ?> 
                                </td>
                                <td>
                                <?php echo $value['taluka_name_en']; ?> 
                                </td>
                                <td>
                                <?php echo $value['taluka_code']; ?> 
                                </td>
                                <td>
                                <?php echo $value['census_code_2001']; ?> 
                                </td>
                                <td>
                                <?php echo $value['census_code_2011']; ?> 
                                </td>
                                <td>
                                <?php echo $value['census_code_2021']; ?> 
                                </td>
                                <?php
                                //pr($value); exit;
                                    $id=$value['id']; 
                                    $taluka_id=$value['taluka_id']; 
                                    $dist_id=$value['district_id']; 
                                    $talukaname =$value['taluka_name_en'];
                                    $subdiv_id=$value['subdivision_id'];
                                    $taluka_code=$value['taluka_code'];
                                    $census_code_2001=$value['census_code_2001'];
                                    $census_code_2011=$value['census_code_2011'];
                                    $census_code_2021=$value['census_code_2021'];
                                    //pr($subdiv_id);
                                    //$id=$value['id']; 
                                ?>           
                                <td>
                                    <input type="button" id="editdist" class="btn btn-info" value="Edit" onclick="javascript: return talukaedit('<?php echo $taluka_id; ?>','<?php echo $dist_id; ?>','<?php echo $talukaname;?>','<?php echo $subdiv_id;?>','<?php echo $taluka_code;?>','<?php echo $census_code_2001;?>','<?php echo $census_code_2011;?>','<?php echo $census_code_2021;?>','<?php echo $id;?>');">
                                    &nbsp;
                                    <a href="<?php echo $this->Url->build('/Master/talukadelete/'. $taluka_id);?>" class="btn btn-danger">Delete</a>
                                    <?php 
                                    //echo $this->Html->link('Delete', array('controller' => 'Master','action' => 'talukadelete' ,$taluka_id)); 
                                    ?>
                                </td>

                            </tr>
                            <?php   
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
 </form>
</div>
