<?php
echo $this->element("Helper/jqueryhelper");
?>
<script type="text/javascript">
     $(document).ready(function () {

        /*$.post(host + 'Citizenentry/get_witness_feilds', {csrftoken: csrftoken}, function (fields)
        {
            if (fields) {
                $("#witness_fields").html(fields);
                $(document).trigger('_page_ready');
                show_data_messages();
                show_error_messages();
            } 
       });*/
       
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
</script>
<?= $this->Form->create(NULL, ['id' => 'witness']) ?>
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
                    <?= $this->Form->control('s_token', ['id' => 's_token','value'=> $Selectedtoken, 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'readonly' => 'readonly']) ?>
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
      
        <input type='hidden' value='<?php echo $actiontypeval; ?>' name='actiontype' id='actiontype'/>
        <input type='hidden' value='<?php echo $hfid; ?>' name='hfid' id='hfid'/>
        <input type='hidden' value='<?php echo $hfupdateflag; ?>' name='hfupdateflag' id='hfupdateflag'/>

        <div class="card-footer center">
            <?php //echo $this->Form->input('csrftoken', array('label' => false, 'type' => 'hidden', 'value' => $this->Session->read('csrftoken'))); ?>
            <button type="submit" id="btnadd" name="btnadd" class="btn btn-info" onclick="javascript: return formadd();"><?php echo __('btnsave'); ?></button>
            <input type="button" id="btnNext" name="btnNext" class="btn btn-info" value="<?php echo __('btncancel'); ?>" onclick="javascript: return forcancel();">
        </div>   

    </form>
</div>


<?= $this->Form->end() ?>