<script type="text/javascript">
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    $(document).ready(function () {
        //$('#datalist').DataTable();
        
        $('#datalist').dataTable({
        "iDisplayLength": 5,
                "aLengthMenu": [[5, 10, 15, 20, - 1], [5, 10, 15, 20, "All"]]
        });
 
    });
</script>
<?= $this->Flash->render() ?>
<?= $this->Form->create($pdefunctionentry, ['id' => 'pdefunctionentry']); ?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>PDE Function Entry</b></h3>
    </div>
    <form class="form-horizontal">
        <div class="card-body">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblfunctionid'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->control('id', ['id' => 'id', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    
                    <div  class="arrow-up id_error"></div>
                    <div id="id_error" class="form-error id_error"></div>
                </div>
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblminorfunction'); ?></label>
                <div class="col-sm-4">
                   <?php echo $this->Form->control('function_desc', ['id' => 'function_desc', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    
                    <div  class="arrow-up function_desc_error"></div>
                    <div id="function_desc_error" class="form-error function_desc_error"></div>
                </div>         
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <?= $this->Form->submit('Add', ['id'=>'btnadd','class'=>"btn btn-success"]); ?>            
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->Form->end() ?>  
