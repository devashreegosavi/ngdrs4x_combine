<?php
echo $this->element("Helper/jqueryhelper");
?>
<?php
echo $this->element("Valuation/administrative_block_js");
?>
<script>
    $(document).ready(function () {
        $('#datalist').DataTable();
    });</script>

<div>    
    <?= $this->Form->create($Level1, ['id' => 'level1']) ?>
    <div class="card">
        <div class="card-header">  <h4 class="modal-title">Location Level 1</h4></div>  
        <div class="card-body">
            <?php echo $this->element("Valuation/administrative_block"); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Location Level 1 Description</label>
                        <?php echo $this->Form->control('level_1_desc_' . $lang, ['type' => 'text', 'id' => 'level_1_desc_' . $lang, 'label' => false, 'class' => 'form-control']); ?>

                        <span id="level_1_desc_en_error" class="form-error"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Enter Latitude</label>
                        <?php echo $this->Form->control('latitude', ['type' => 'text', 'id' => 'latitude', 'label' => false, 'class' => 'form-control']); ?>

                        <span id="latitude_error" class="form-error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Enter Longitude</label>
                        <?php echo $this->Form->control('longitude', ['type' => 'text', 'id' => 'longitude', 'label' => false, 'class' => 'form-control']); ?>
                        <span id="longitude_error" class="form-error"></span>
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
                                <?php echo $value['level_1_id']; ?> 
                            </td>
                            <td>
                                <?php echo $value['level_1_desc_en']; ?> 
                            </td>
                            <td>
                                <a href="<?php echo $this->Url->build('/ValuationControls/level1/' . $value['level_1_id']); ?>/E" class="btn btn-info btn-sm">Edit</a>  
                                <a href="<?php echo $this->Url->build('/ValuationControls/level1/' . $value['level_1_id']); ?>/D" class="btn btn-danger btn-sm">Delete</a>  
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


