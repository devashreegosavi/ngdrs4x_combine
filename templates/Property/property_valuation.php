<?= $this->Form->create(NULL, ['id' => 'propertyValuation', 'autoComplete' => 'off']) ?>
<div class="container">
    <div class = "card card-primary   card-outline">
        <div class = "card-header">            
            <h3 class="card-title">Property Valuation</h3>
            <div class="card-tools">  
               
                
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <div class="btn btn-primary">
                            <?php echo __('Valuation As On Date'); ?>
                        </div>
                    </div>
                    <?php
                    echo $this->Form->control('valuation_as_on_date', ['type' => 'text', 'class' => 'form-control valuation_as_on_date', 'id' => 'valuation_as_on_date', 'readonly' => 'readonly', 'div' => false, 'label' => false, 'value' => date('d-m-Y')]);
                    ?>
                </div>               
            </div>
        </div>
        <?php
        echo $this->Element('Valuation/screen');
        ?>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Calculate And Save</button>
            <button type="reset" class="btn btn-info float-right">Reset</button>               
        </div>
    </div>
</div>
<?= $this->Form->end() ?>




