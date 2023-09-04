<?php
echo $this->element("Helper/jqueryhelper");
?>
<script type="text/javascript">

    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
     $(document).ready(function () {

        $('#datatbl').dataTable({
                "iDisplayLength": 10,
                "aLengthMenu": [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]],
                
        });
       
       //alert('aaa');
       var type = $("#identifire_type option:selected").val();

       $.post('<?php
        echo $this->Url->build([
            'controller' => 'Identification',
            'action' => 'getidentificationfeilds',])
        ?>', {'_csrfToken': $("input[name=_csrfToken]").val(), type : type}, function (data)
        {
            //alert(data);
            $("#identification_fields").html(data);
        });
        
        
    });

    function edit_identifier(id,identification_id){
        //alert(id);

        $.post('<?php
        echo $this->Url->build([
            'controller' => 'Identification',
            'action' => 'getidentificationfeilds',])
        ?>', {'_csrfToken': $("input[name=_csrfToken]").val(), id : id}, function (data)
        {
            //alert(data);
            $("#witness_fields").html(data);
            $('#hfid').val(id);
            $('#identification_id').val(identification_id);
            $('#hfupdateflag').val('Y');

            if ($('#village_id').length && $("#village_id option:selected").val() != '') {
                var village_id = $("#village_id option:selected").val();
                var district_id = $("#district_id option:selected").val();
                var taluka_id = $("#taluka_id option:selected").val();
                //alert(village_id);
                $.post('<?php
                echo $this->Url->build([
                    'controller' => 'Identification',
                    'action' => 'getdependentaddress',])
                ?>', {district_id: district_id,taluka_id : taluka_id,village_id : village_id,ref_id: '5',behavioral_id : '2', ref_val_id: id, ref_val_identification_id : identification_id , '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
                {
                    //alert(data);
                    $('.identifieraddress').html(data);
                });
            }
        });

    }
    
</script>
<?= $this->Form->create(NULL, ['id' => 'identification']) ?>

<input type='hidden' value='<?php echo $actiontypeval; ?>' name='actiontype' id='actiontype'/>
<input type='hidden' value='<?php echo $hfid; ?>' name='hfid' id='hfid'/>
<input type='hidden' value='<?php echo $hfupdateflag; ?>' name='hfupdateflag' id='hfupdateflag'/>
<input type='hidden' value='<?php echo $identification_id; ?>' name='identification_id' id='identification_id'/>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>Identification Entry</b></h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-sm-4">&nbsp;</div>
                <div class="col-sm-4">&nbsp;</div>
                <div class="col-sm-4">
                    <p style="color: red;"><b><?php echo __('lblnote'); ?>1:&nbsp;</b><?php echo __('lblengdatarequired'); ?>
                  
                    <p style="color: red;"><b><?php echo __('lblnote'); ?>2:&nbsp;</b><?php echo __('Minimum and Maximum 1 identifier is required.'); ?>   
                </div>      
            </div>
            <hr>
            <?php
            //202300000004
            $Selectedtoken = $this->request->getSession()->read('Selectedtoken');
            $Selectedtoken='202300000004';
            if($Selectedtoken!=''){
            ?>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbltokenno'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->control('token_no', ['id' => 'token_no','value'=> $Selectedtoken, 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'readonly' => 'readonly']) ?>
                </div>
                <div class="col-sm-4">
                    &nbsp;
                </div>
            </div>
            <?php
            }
            ?>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblselectidentificationtype'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->select('identifire_type', $identifieropt, ['empty' => '--Select--', 'class' => 'form-select', 'id' => 'identifire_type']); ?>
                    
                </div>
                <div class="col-sm-4">
                    &nbsp;
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div id="identification_fields"></div>
                <?php 
                //pr($bankmasterlistdata); 
                ?>
            </div>
        </div>
      
        
        <div class="card-footer center">
            <?php //echo $this->Form->input('csrftoken', array('label' => false, 'type' => 'hidden', 'value' => $this->Session->read('csrftoken'))); ?>
            <button type="submit" id="btnadd" name="btnadd" class="btn btn-info" onclick="javascript: return formadd();"><?php echo __('btnsave'); ?></button>
            <input type="button" id="btnNext" name="btnNext" class="btn btn-info" value="<?php echo __('btncancel'); ?>" onclick="javascript: return forcancel();">
        </div>   

            
    </form>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Identifier Details
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover text-nowrap"  id="datatbl">
                    <thead>
                        <tr>
                            <th>Identifier Name</th>
                            <th>Identifier Father/Husband Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($identificationrec); $i++) { ?>
                        <tr>
                            <td><?php echo $identificationrec[$i]['identification_full_name_en'];?></td>
                            <td><?php echo $identificationrec[$i]['father_full_name_en'];?></td>
                            <td>
                            <input type="button" id="editdist" class="btn btn-info btn-xs" value="Edit" onclick="javascript: return edit_identifier('<?php echo $identificationrec[$i]['id']; ?>','<?php echo $identificationrec[$i]['identification_id']; ?>');">
                            <!--<a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Edit</a>-->
                            <!--<a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Delete</a>-->

                            <a href="<?php echo $this->Url->build('/Identification/identificationdelete/'. $identificationrec[$i]['identification_id']);?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this Identifier ?')">Delete</a>

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
</div>
<?= $this->Form->end() ?>