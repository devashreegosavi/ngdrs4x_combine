<?php
echo $this->element("Helper/jqueryhelper");
?>
<script type="text/javascript">
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
    </form>
</div>
<?= $this->Form->end() ?>