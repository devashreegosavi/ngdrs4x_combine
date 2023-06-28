
<?= $this->Form->create($ValSubrule, ['id' => 'valrule_subrule']) ?>
<?php echo $this->element("ValuationMenu/valrulemenu"); ?>
<div class="card card-info ">
    <div class="card-header">
        <h4 class="modal-title ">Valuation Subrule Entry</h4>
    </div> 
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label><?php echo __('lbloutputitem'); ?></label>
                    <?php
                    echo $this->Form->select('out_put_id', $OutputItemList, ['empty' => '--Select Year--', 'class' => 'form-select', 'id' => 'out_put_id']);
                    ?>
                    <div  class="arrow-up out_put_id_error"></div>
                    <div id="out_put_id_error" class="form-error out_put_id_error"></div>
                </div>
            </div>
        </div>


    </div>
</div>