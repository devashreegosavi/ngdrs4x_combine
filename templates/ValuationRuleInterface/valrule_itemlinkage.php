
<?= $this->Form->create($ItemList, ['id' => 'valrule_itemlinkage']) ?>
<?php echo $this->element("ValuationMenu/valrulemenu"); ?>

<div class="card card-info ">
    <div class="card-header">
        <h4 class="modal-title ">Valuation Rule Item Linkage</h4>
    </div>
    <div class = "card-footer" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group"> 
                        <div class="card card-success shadow-sm collapsed-card">
                            <div class="card-header">  
                                <h2 class="card-title">   
                                    <label><?php echo __('lblinputitem'); ?>
                                    </label> 
                                </h2>
                                <span class="input-group-addon input-sm"><i class="fa fa-search"></i></span> 
                                <?php echo $this->Form->input('search_rule', array('id' => 'search_rule', 'label' => false, 'placeholder' => 'Search...', 'class' => 'brn btn-search')); ?>
                            </div>
                            <div class="max-height150">
                                <?php
                                echo $this->Form->select('usage_param_id', $InputItemList, ['type' => 'select', 'multiple' => 'checkbox', 'id' => 'usage_param_id']);
                                ?>
                            </div>
                        </div>
                        <div  class="arrow-up usage_param_id_error"></div>
                        <div id="usage_param_id_error" class="form-error usage_param_id_error"></div> 
                    </div>
                </div>
            </div>

        </div>
    </div>



    <div class="form-group"><center>
            <?= $this->Form->submit(__('Submit'), ['class' => 'btn btn-info']); ?>
        </center>

    </div>



</div>