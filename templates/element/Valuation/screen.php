<div class = "card-body" >
    <div class=" col-md-12" >
        <?php
        echo $this->Element('Valuation/administrative_block');
        ?> 
    </div>  
</div>
<?php
echo $this->Element('Valuation/property_attribute');
?>
<div class = "card-footer" >
    <div class=" col-md-12" >  
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label><?php echo __('lbllocationlevel1'); ?></label>
                    <?php
                    echo $this->Form->select('level_1_id', $Level1_Data, ['empty' => '--select--', 'class' => 'form-select', 'id' => 'level_1_id']);
                    ?>
                    <div  class="arrow-up level_1_id_error"></div>
                    <div id="level_1_id_error" class="form-error level_1_id_error"></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label><?php echo __('lbllocationlevellist1'); ?></label>
                    <?php
                    echo $this->Form->select('prop_level1_list_id', $Level1List, ['empty' => '--select--', 'class' => 'form-select', 'id' => 'prop_level1_list_id']);
                    ?>
                    <div  class="arrow-up prop_level1_list_id_error"></div>
                    <div id="prop_level1_list_id_error" class="form-error prop_level1_list_id_error"></div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>&nbsp;&nbsp;</label>
                    <button type="button" class="form-control btn btn-primary"  id="rr_rate_view"><span class="fa fa-eye"></span> View Rate</button>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-footer bg-white">
    <div class="row">  
        <div class="col-md-4">

            <?php foreach ($UsageMain as $key => $main) { ?>
                <div class="card card-info collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title"> <?php echo $main; ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body" style="display: none;">


                        <ul class="nav flex-column">
                            <?php
                            foreach ($UsageSub as $sub) {
                                $sub = $sub->toArray();
                                if ($key == $sub['UsageCategory']['usage_main_catg_id']) {
                                    ?>
                                    <li class="nav-item">
                                        <div href="" class="nav-link" onclick="usage_filter('<?= $sub['UsageCategory']['usage_main_catg_id'] ?>', '<?= $sub['usage_sub_catg_id'] ?>');">
                                            <?php echo $sub['usage_sub_catg_desc_' . $lang]; ?>
                                        </div>                                        
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>

                    </div>
                </div>
            <?php } ?>

        </div>
        <div class="col-md-8">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?php echo __('lblpropertyusage'); ?></h3>
                    <div class="card-tools">
                        <div class="input-group">
                            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" id="search_rule">                            
                        </div>
                    </div>

                </div>

                <div class="card-body max-height250" style="display: block;" id="usage_rule_list">

                    <ul class="todo-list-small">
                        <?php foreach ($EvalRule as $key=>$rule) {
                            ?>
                            <li><input type="checkbox" class="usage_cat_id" value="<?= $key ?>">
                                <label for="usage_cat_id<?= $key ?>"><?= $rule ?></label>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

            </div>

        </div>
    </div>
    
    <div class="row" id="valuation_rule_fields">  
    
    </div>
</div>




<?php
echo $this->Element('Valuation/modal');
?>
<?php
echo $this->Element('Valuation/administrative_block_js');
?>
<?php
echo $this->Element('Valuation/screen_js');
?>

