<script type="text/javascript">
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    $(document).ready(function () {
        //$('#datalist').DataTable();
        
        $('#datalist').dataTable({
        "iDisplayLength": 5,
                "aLengthMenu": [[5, 10, 15, 20, - 1], [5, 10, 15, 20, "All"]]
        });
        /*$("#editdist").click(function () {
            var distid = $("#distid").val();
            
            alert(distid);
        });*/
    });
    
        /// jquery with ajax working code
        function districtedit(distid, districtname,districtcode, districtcensuscode,id){
            //alert('aaaaaaaa');
            //alert(distid);
            //alert(districtname);
            $('#district_name_en').val(districtname);
            $('#district_code').val(districtcode);
            $('#census_code').val(districtcensuscode);
            $('#updatedistid').val(distid);
            $('#updateid').val(id);
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
        function districtdelete(distid, districtname){
            $('#updatedistid').val(distid);
            $('#hfaction').val('D');
            $('#btnadd').val('Delete');


           
        }

</script>
<?= $this->Flash->render() ?>
<?= $this->Form->create() ?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>District Entry</b></h3>
    </div>
    <form class="form-horizontal">
        <div class="card-body">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblenterdist'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->control('district_name_en', ['id' => 'district_name_en', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    
                    <div  class="arrow-up district_name_en_error"></div>
                    <div id="district_name_en_error" class="form-error district_name_en_error"></div>
                </div>
                 <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblenterdistcode'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->control('district_code', ['id' => 'district_code', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    
                    <div  class="arrow-up district_code_error"></div>
                    <div id="district_code_error" class="form-error district_code_error"></div>
                </div>         
            </div>
            <div class="form-group row">
               <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblenterdistcensuscode'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->control('census_code', ['id' => 'census_code', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    
                    <div  class="arrow-up census_code_error"></div>
                    <div id="census_code_error" class="form-error census_code_error"></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <?php echo $this->Form->input('state_id', array('label' => false, 'id' => 'state_id', 'class' => 'form-control', 'value' => $state_id, 'type' => 'hidden', 'autocomplete'=> 'off')); ?>
                    <?= $this->Form->submit('Add', ['id'=>'btnadd','class'=>"btn btn-success"]); ?>
                    
                    <?php echo $this->Form->input('updateid', array('label' => false, 'id' => 'updateid', 'type' => 'hidden')); ?> 
                    <?php echo $this->Form->input('updatedistid', array('label' => false, 'id' => 'updatedistid', 'type' => 'hidden')); ?> 
                    <?php echo $this->Form->input('hfaction', array('label' => false, 'id' => 'hfaction', 'type' => 'hidden')); ?>
                                
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
                                <th>District ID</th>
                                <th>District Name</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                               <?php   
                               $w=1;
                                foreach ($result as $value){ ?>
                                    <tr>
                                        <td>
                                            <?php  echo $w;$w++;?> 
                                        </td>    
                                        <td>
                                            <?php  echo $value['state_id'];?> 
                                        </td>
                                        <td>
                                            <?php  echo $value['district_id'];?> 
                                        </td>
                                        <td>
                                            <?php echo $value['district_name_en']; ?> 
                                        </td>

                                        <?php
                                            $dist_id=$value['district_id']; 
                                            $distname =$value['district_name_en'];
                                            $districtcode=$value['district_code'];
                                            $districtcensuscode= $value['census_code'];    
                                            $id=$value['id']; 
                                        ?>

                                        <td>
                                        <?php

                                            ?>
                                            <!--<a href= "#" onClick= districtedit($dist_id);>Edit</a>-->
                                            <input type="button" id="editdist" class="btn btn-info" value="Edit" onclick="javascript: return districtedit('<?php echo $dist_id; ?>','<?php echo $distname;?>','<?php echo $districtcode;?>','<?php echo $districtcensuscode;?>','<?php echo $id;?>');">
                                            &nbsp;
                                            <a href="<?php echo $this->Url->build('/Master/districtdelete/'. $dist_id);?>" class="btn btn-danger">Delete</a>
                                                <?php 
                                            
                                            //echo $this->Html->link('Delete', array('class'=>'btn btn-danger','controller' => 'Master','action' => 'districtdelete' ,$dist_id)); ?>
                                            <!--<input type="button" id="editdist" class="btn btn-primary" value="Edit">-->
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


<div id="district_fields"></div>

<?= $this->Form->end() ?>