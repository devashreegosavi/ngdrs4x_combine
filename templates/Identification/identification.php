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

    
</script>
<?= $this->Form->create(NULL, ['id' => 'identification']) ?>

<input type='hidden' value='<?php echo $actiontypeval; ?>' name='actiontype' id='actiontype'/>
<input type='hidden' value='<?php echo $hfid; ?>' name='hfid' id='hfid'/>
<input type='hidden' value='<?php echo $hfupdateflag; ?>' name='hfupdateflag' id='hfupdateflag'/>


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