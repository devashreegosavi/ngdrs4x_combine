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
       $.post('<?php
        echo $this->Url->build([
            'controller' => 'Witness',
            'action' => 'getwitnessfeilds',])
        ?>', {'_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
        {
            //alert(data);
            $("#witness_fields").html(data);
        });
        
        
    });

    function edit_witness(id,witness_id){
        //alert(id);

        $.post('<?php
        echo $this->Url->build([
            'controller' => 'Witness',
            'action' => 'getwitnessfeilds',])
        ?>', {'_csrfToken': $("input[name=_csrfToken]").val(), id : id}, function (data)
        {
            //alert(data);
            $("#witness_fields").html(data);
            $('#hfid').val(id);
            $('#witness_id').val(witness_id);
            $('#hfupdateflag').val('Y');

        });

    }
</script>
<?= $this->Form->create(NULL, ['id' => 'witness']) ?>

<input type='hidden' value='<?php echo $actiontypeval; ?>' name='actiontype' id='actiontype'/>
<input type='hidden' value='<?php echo $hfid; ?>' name='hfid' id='hfid'/>
<input type='hidden' value='<?php echo $witness_id; ?>' name='witness_id' id='witness_id'/>
<input type='hidden' value='<?php echo $hfupdateflag; ?>' name='hfupdateflag' id='hfupdateflag'/>



<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>Witness Entry</b></h3>
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
                  
                    <p style="color: red;"><b><?php echo __('lblnote'); ?>2:&nbsp;</b><?php echo __('Minimum 2 witnesses are compulsory.'); ?>   
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
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div id="witness_fields"></div>
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
                    Witness Details
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover text-nowrap"  id="datatbl">
                    <thead>
                        <tr>
                            <th>Witness Name</th>
                            <th>Witness Father/Husband Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($witness); $i++) { ?>
                        <tr>
                            <td><?php echo $witness[$i]['witness_full_name_en'];?></td>
                            <td><?php echo $witness[$i]['father_full_name_en'];?></td>
                            <td>
                            <input type="button" id="editdist" class="btn btn-info btn-xs" value="Edit" onclick="javascript: return edit_witness('<?php echo $witness[$i]['id']; ?>','<?php echo $witness[$i]['witness_id']; ?>');">
                            <!--<a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Edit</a>-->
                            <a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Delete</a>
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