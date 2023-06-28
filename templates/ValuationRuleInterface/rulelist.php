<script>
    $(document).ready(function () {
        $('#datalist').DataTable();
    });</script>

<div>    
    <?= $this->Form->create($ValuationRuleList, ['id' => 'rulelist']) ?>
    <?= $this->Form->end() ?>
</div>

<?php echo $this->element("ValuationMenu/valrulemenu"); ?>

<div class="card">

    <div class="card-header">  <h4 class="modal-title">Valuation Rule List</h4></div>  
    <div class="card-body">
        <div>
            <?php //echo $this->Form->button(__('lblNewRule'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>

            <a href="<?php echo $this->Url->build('/ValuationRuleInterface/valuation_rule'); ?>" class="btn btn-primary"><?php echo __('lblNewRule'); ?></a>  

        </div>
    </div>	
</div> 

<div class="row">
    <div class="col-md-12">
        <div class="card">

            <table class="table" border="1" id="datalist">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Valuation Rule</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($ValuationRuleList as $value) {

//                        //    $value = $value->toArray();
//                        pr($value);
//                        exit;
                        ?>
                        <tr>
                            <td>
                                <?php echo $value['evalrule_id']; ?> 
                            </td>
                            <td>
                                <?php echo $value['evalrule_desc_' . $lang]; ?> 
                            </td>
                            <td>
                                <a href="<?php echo $this->Url->build('/ValuationRuleInterface/rulelist/' . $value['evalrule_id']); ?>/E" class="btn btn-info btn-sm">Edit</a>  
                                <a href="<?php echo $this->Url->build('/ValuationRuleInterface/rulelist/' . $value['evalrule_id']); ?>/D" class="btn btn-danger btn-sm">Delete</a>  
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