<?php
echo $this->element("Helper/jqueryhelper");
?>
<script>
    $(document).ready(function () {

//alert('division_id');
        //---------------Division->District filteration
        $('#division_id').change(function () {
            var division_id = $('#division_id').val();


            $.postJSON('getdistdata', {division_id: division_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
            {
                var sc = '<option value="">--select--</option>';
                $.each(data, function (index, val) {

                    sc += "<option value=" + index + ">" + val + "</option>";
                });
                $("#district_id option").remove();
                $("#district_id").append(sc);
            });
        });
        //---------------------------------    

        //---------------District->Subdivision filteration
        $('#district_id').change(function () {
            var district_id = $('#district_id').val();
            $.postJSON('getsubdivdata', {district_id: district_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)

            {
                var sc = '<option value="">--select--</option>';
                $.each(data, function (index, val) {

                    sc += "<option value=" + index + ">" + val + "</option>";
                });
                $("#subdivision_id option").remove();
                $("#subdivision_id").append(sc);
            });
        });


    });</script>

<div>    

    <?= $this->Form->create($Level1, ['id' => 'level1']) ?>

    <div class="card">

        <div class="card-header">  <h4 class="modal-title">Level 1</h4></div>  
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Division</label>
                        <?= $this->Form->select('division_id', $divisionlistdata, ['id' => 'division_id', 'empty' => 'Select Division', 'label' => false, 'class' => 'form-control']) ?>
                        <span id="division_id_error" class="form-error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select District</label>
                        <?= $this->Form->select('district_id', array(), ['id' => 'district_id', 'empty' => 'Select District', 'label' => false, 'class' => 'form-control']) ?>
                        <span id="district_id_error" class="form-error"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Sub Division</label>
                        <?= $this->Form->select('subdivision_id', array(), ['id' => 'subdivision_id', 'empty' => 'Select Subdivision', 'label' => false, 'class' => 'form-control']) ?>
                        <span id="subdivision_id_error" class="form-error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Taluka</label>
                        <?= $this->Form->select('taluka_id', array(), ['id' => 'taluka_id', 'empty' => 'Select Taluka', 'label' => false, 'class' => 'form-control']) ?>
                        <span id="taluka_id_error" class="form-error"></span>
                    </div>
                    <br>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Circle</label>
                        <?= $this->Form->select('circle_id', array(), ['id' => 'circle_id', 'empty' => 'Select Circle', 'label' => false, 'class' => 'form-control']) ?>
                        <span id="circle_id_error" class="form-error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Village</label>
                        <?= $this->Form->select('village_id', array(), ['id' => 'village_id', 'empty' => 'Select Village', 'label' => false, 'class' => 'form-control']) ?>
                        <span id="village_id_error" class="form-error"></span>
                    </div>
                    <br>
                </div>
            </div>




            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Level 1 Description</label>
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

<table class="table" border="1">
    <tr>
        <th>Level 1</th>
        <th>Level 1 Name</th>
        <th>Actions</th>
    </tr>
    <?php
    foreach ($result as $value) {

        $value = $value->toArray();
        //   pr($value);exit;
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
</table>

