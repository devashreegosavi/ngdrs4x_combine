
<div class="row">


    <?php if ($config['AdmBlocks']['is_div'] == 'Y') { ?>
        <div class="col-sm-3">
            <div class="form-group">
                <label><?php echo __('lbladmdivision'); ?></label>
                <?php
                echo $this->Form->select('division_id', $Division_List, ['empty' => '--select--', 'class' => 'form-select', 'id' => 'division_id']);
                ?>
                <div  class="arrow-up division_id_error"></div>
                <div id="division_id_error" class="form-error division_id_error"></div>
            </div>
        </div>
    <?php } ?>

    <?php if ($config['AdmBlocks']['is_dist'] == 'Y') { ?>
        <div class="col-sm-3">
            <div class="form-group">
                <label><?php echo __('lbladmdistrict'); ?></label>
                <?php
                echo $this->Form->select('district_id', $District_List, ['empty' => '--select--', 'class' => 'form-select', 'id' => 'district_id']);
                ?>
                <div  class="arrow-up district_id_error"></div>
                <div id="district_id_error" class="form-error district_id_error"></div>
            </div>
        </div>
    <?php } ?>
    <?php if ($config['AdmBlocks']['is_subdiv'] == 'Y') { ?>
        <div class="col-sm-3">
            <div class="form-group">
                <label><?php echo __('lbladmsubdivision'); ?></label>
                <?php
                echo $this->Form->select('subdivision_id', $Subdivision_List, ['empty' => '--select--', 'class' => 'form-select', 'id' => 'subdivision_id']);
                ?>  
                <div  class="arrow-up subdivision_id_error"></div>
                <div id="subdivision_id_error" class="form-error subdivision_id_error"></div>
            </div>
        </div>
    <?php } ?>
    <?php if ($config['AdmBlocks']['is_taluka'] == 'Y') { ?>
        <div class="col-sm-3">
            <div class="form-group">
                <label><?php echo __('lbladmtaluka'); ?></label>
                <?php
                echo $this->Form->select('taluka_id', $Taluka_List, ['empty' => '--select--', 'class' => 'form-select', 'id' => 'taluka_id']);
                ?> 
                <div  class="arrow-up taluka_id_error"></div>
                <div id="taluka_id_error" class="form-error taluka_id_error"></div>
            </div>
        </div>
    <?php } ?>
    <?php if ($config['AdmBlocks']['is_circle'] == 'Y') { ?>
        <div class="col-sm-3">
            <div class="form-group">
                <label><?php echo __('lbladmcircle'); ?></label>
                <?php
                echo $this->Form->select('circle_id', $Circle_List, ['empty' => '--select--', 'class' => 'form-select', 'id' => 'circle_id']);
                ?> 
                <div  class="arrow-up circle_id_error"></div>
                <div id="circle_id_error" class="form-error circle_id_error"></div>
            </div>
        </div>
    <?php } ?>
    <?php if ($config['AdmBlocks']['is_village'] == 'Y') { ?>
        <div class="col-sm-3">
            <div class="form-group">
                <label><?php echo __('lbladmvillage'); ?></label>
                <?php
                echo $this->Form->select('village_id', $Village_List, ['empty' => '--select--', 'class' => 'form-select', 'id' => 'village_id']);
                ?> 
                <div  class="arrow-up village_id_error"></div>
                <div id="village_id_error" class="form-error village_id_error"></div>
            </div>
        </div>
    <?php } ?>

    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo __('lbldellandtype'); ?></label>
            <?php
            echo $this->Form->select('developed_land_types_id', $Dtypes_List, ['empty' => '--select--', 'class' => 'form-select', 'id' => 'developed_land_types_id']);
            ?> 
            <div  class="arrow-up developed_land_types_id_error"></div>
            <div id="developed_land_types_id_error" class="form-error developed_land_types_id_error"></div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo __('lblcorporation'); ?></label>
            <?php
            echo $this->Form->select('corp_id', $Corp_List, ['empty' => '--select--', 'class' => 'form-select', 'id' => 'corp_id']);
            ?> 
            <div  class="arrow-up corp_id_error"></div>
            <div id="corp_id_error" class="form-error corp_id_error"></div>
        </div>
    </div>

</div>