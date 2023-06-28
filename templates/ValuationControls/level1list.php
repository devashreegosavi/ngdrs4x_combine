<?php
echo $this->element("Helper/jqueryhelper");
?>
<?php
echo $this->element("Valuation/administrative_block_js");
?>
<script>
    $(document).ready(function () {

//alert('level_1_id');
        $('#level_1_id').change(function () {
            unset_options('level_1_id');
            var level_1_id = $('#level_1_id').val();
            if ($.isNumeric(level_1_id)) {
                $.postJSON('<?php echo $this->Url->build('/Valuation/get_level_1_list_by_level_1'); ?>', {level_1_id: level_1_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
                {
                    var sc = '<option value="">--select--</option>';
                    $.each(data.L1_List, function (index, val) {
                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#prop_level1_list_id option").remove();
                    $("#prop_level1_list_id").append(sc);
                    auto_key('level_1_id');
                });
            }

        });
        //---------------------------------    
        $('#datalist').DataTable();

    });</script>

<div>    

    <?= $this->Form->create($Level1List, ['id' => 'level1list']) ?>

    <div class="card">

        <div class="card-header">  <h4 class="modal-title">Location List Level 1</h4></div>  
        <div class="card-body">
            <?php echo $this->element("Valuation/administrative_block"); ?>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label><?php echo __('Level 1'); ?></label>
                        <?php
                        
                       // pr($Level1->toArray());exit;
                        echo $this->Form->select('level_1_id', $Level1_Data, ['empty' => '--select--', 'class' => 'form-control', 'id' => 'level_1_id', 'id' => 'level_1_id']);
                        ?>
                        <div  class="arrow-up level_1_id_error"></div>
                        <div id="level_1_id_error" class="form-error level_1_id_error"></div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Location Level 1 List Description</label>
                        <?php echo $this->Form->control('list_1_desc_en', ['type' => 'text', 'id' => 'list_1_desc_en', 'label' => false, 'class' => 'form-control']); ?>

                        <span id="list_1_desc_en_error" class="form-error"></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?= $this->Form->submit(__('Add'), ['class' => 'btn btn-primary btn-block btn-sm']); ?>
            </div>
        </div>	
    </div>  
    <?= $this->Form->end() ?>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <table class="table" border="1" id="datalist">
                <thead>
                    <tr>
                        <th>Level 1</th>
                        <th>Level 1 Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($result as $value) {
                        $value = $value->toArray();
                        ?>
                        <tr>
                            <td>
                                <?php echo $value['prop_level1_list_id']; ?> 
                            </td>
                            <td>
                                <?php echo $value['list_1_desc_en']; ?> 
                            </td>
                            <td>
                                <a href="<?php echo $this->Url->build('/ValuationControls/level1list/' . $value['prop_level1_list_id']); ?>/E" class="btn btn-info btn-sm">Edit</a>  
                                <a href="<?php echo $this->Url->build('/ValuationControls/level1list/' . $value['prop_level1_list_id']); ?>/D" class="btn btn-danger btn-sm">Delete</a>  
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

