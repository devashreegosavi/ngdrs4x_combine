
<script>
    $(document).ready(function () {

        $('#effective_date').datepicker({
//            daysOfWeekDisabled: [0,6],
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            calendarWeeks: true,
            //orientation: "top left",
            autoclose: true,
            todayHighlight: true
        });



//Filteration code for main and sub category -Usage Main Category
        $('#usage_main_catg_id').change(function () {
            var usage_main_catg_id = $('#usage_main_catg_id').val();
            if ($.isNumeric(usage_main_catg_id)) {
                $.postJSON('<?php echo $this->Url->build('/ValuationRuleInterface/getsubcatlist'); ?>', {usage_main_catg_id: usage_main_catg_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
                {
                    var sc = '<option value="">--select--</option>';
                    $.each(data, function (index, val) {
                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#usage_sub_catg_id option").remove();
                    $("#usage_sub_catg_id").append(sc);
                });
            }

        });
//----------------////Additional Rate Required[RR1]-Start\\\\\---------------
        //Hide show code for  Additional Rate Required[RR1] additional_rate_flag
        $('#additional_rate_flag').change(function () {

            if ($('#additional_rate_flag').val() === 'Y') {
                $(".additonalRate").show();
            } else {
                $(".additonalRate").hide();
            }

        });
//Filteration code for main and sub category -Additional Rate Required[RR1] on additional_rate_flag hide show dependency
        $('#add_usage_main_catg_id').change(function () {
            var add_usage_main_catg_id = $('#add_usage_main_catg_id').val();
            if ($.isNumeric(add_usage_main_catg_id)) {
                $.postJSON('<?php echo $this->Url->build('/ValuationRuleInterface/getsubcatlist'); ?>', {usage_main_catg_id: add_usage_main_catg_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
                {
                    var sc = '<option value="">--select--</option>';
                    $.each(data, function (index, val) {
                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#add_usage_sub_catg_id option").remove();
                    $("#add_usage_sub_catg_id").append(sc);
                });
            }

        });
//----------------////Additional Rate Required[RR1] -End\\\\\---------------
//----------------////Additional Rate Required 1 [RR5] -Start\\\\\---------------
//Hide show code for Additional Rate Required 1 [RR5]
        $('#additional1_rate_flag').change(function () {
            if ($('#additional1_rate_flag').val() === 'Y') {
                $(".additonal1Rate").show();
            } else {
                $(".additonal1Rate").hide();
            }
        });
//Filteration code for main and sub category -Additional Rate Required 1 [RR5]
        $('#add1_usage_main_catg_id').change(function () {
            var add1_usage_main_catg_id = $('#add1_usage_main_catg_id').val();
            if ($.isNumeric(add1_usage_main_catg_id)) {
                $.postJSON('<?php echo $this->Url->build('/ValuationRuleInterface/getsubcatlist'); ?>', {usage_main_catg_id: add1_usage_main_catg_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
                {
                    var sc = '<option value="">--select--</option>';
                    $.each(data, function (index, val) {
                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#add1_usage_sub_catg_id option").remove();
                    $("#add1_usage_sub_catg_id").append(sc);
                });
            }

        });

//----------------////Additional Rate Required 1 [RR5] -End\\\\\---------------
//----------------////Is Rate Comparison Required ? [ABE] -Start\\\\\---------------
        //Hide show code for Additional Rate Required 1 [RR5]
        $('#rate_compare_flag').change(function () {

            if ($('#rate_compare_flag').val() === 'Y') {
                $(".comparisonRate").show();
            } else {
                $(".comparisonRate").hide();
            }

        });

//Filteration code for main and sub category -Is Rate Comparison Required ? [ABE]
        $('#cmp_usage_main_catg_id').change(function () {
            var cmp_usage_main_catg_id = $('#cmp_usage_main_catg_id').val();
            if ($.isNumeric(cmp_usage_main_catg_id)) {
                $.postJSON('<?php echo $this->Url->build('/ValuationRuleInterface/getsubcatlist'); ?>', {usage_main_catg_id: cmp_usage_main_catg_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
                {
                    var sc = '<option value="">--select--</option>';
                    $.each(data, function (index, val) {
                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#cmp_usage_sub_catg_id option").remove();
                    $("#cmp_usage_sub_catg_id").append(sc);
                });
            }

        });
//----------------////Is Rate Comparison Required ? [ABE] -End\\\\\---------------
//location dependency 
        $('#location_dependency_flag').change(function () {

            if ($('#location_dependency_flag').val() === 'Y') {
                $(".location_dependency").show();
            } else {
                $(".location_dependency").hide();
            }

        });
    });
</script>
<?= $this->Form->create($EvalRule, ['id' => 'valuation_rule']) ?>
<?php echo $this->element("ValuationMenu/valrulemenu"); ?>



<div class="card card-info ">
    <div class="card-header">
        <h4 class="modal-title ">Valuation Rule Entry</h4>
    </div> 
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label><?php echo __('lblfineyer'); ?></label>
                    <?php
                    echo $this->Form->select('fin_year', $FinyearList, ['empty' => '--Select Year--', 'class' => 'form-select', 'id' => 'fin_year']);
                    ?>
                    <div  class="arrow-up fin_year_error"></div>
                    <div id="fin_year_error" class="form-error fin_year_error"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label><?php echo __('lbleffedate'); ?></label>
                    <?php echo $this->Form->control('effective_date', ['type' => 'text', 'id' => 'effective_date', 'placeholder' => 'Enter Date', 'label' => false, 'class' => 'form-control', 'value' => date('d-m-Y')]); ?>
                    <div  class="arrow-up effective_date_error"></div>
                    <div id="effective_date_error" class="form-error effective_date_error"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label><?php echo __('lblReferenceNo'); ?></label>
                    <?php echo $this->Form->control('reference_no', ['type' => 'text', 'id' => 'reference_no', 'placeholder' => 'Rule Reference Number', 'label' => false, 'class' => 'form-control']); ?>

                    <div  class="arrow-up reference_no_error"></div>
                    <div id="reference_no_error" class="form-error reference_no_error"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label><?php echo __('lblusamaincat'); ?></label>
                    <?php
                    echo $this->Form->select('usage_main_catg_id', $MainCatglist, ['empty' => '--Select Main Category--', 'class' => 'form-select', 'id' => 'usage_main_catg_id']);
                    ?>

                    <div  class="arrow-up usage_main_catg_id_error"></div>
                    <div id="usage_main_catg_id_error" class="form-error usage_main_catg_id_error"></div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label><?php echo __('lblUsagesubcategoryname'); ?></label>
                    <?php
                    echo $this->Form->select('usage_sub_catg_id', $subcatlist, ['empty' => '--Select Sub Category--', 'class' => 'form-select', 'id' => 'usage_sub_catg_id']);
                    ?>
                    <div  class="arrow-up usage_sub_catg_id_error"></div>
                    <div id="usage_sub_catg_id_error" class="form-error usage_sub_catg_id_error"></div>
                </div>
            </div>
        </div>  
    </div>
    <div class = "card-footer" >
        <div class="card-body">
            <div class="row">
                <?php
                foreach ($MainLanguagedata as $key => $langcodedata) {
                    $langcode = $langcodedata->toArray();
                    ?>
                    <div class="col-md-4">
                        <label><?php echo __('lblruledescen') . "  (" . $langcode['language_name'] . ")"; ?>
                            <span style="color: #ff0000">*</span>
                        </label>    
                        <?php echo $this->Form->input('evalrule_desc_' . $langcode['language_code'], array('label' => false, 'id' => 'evalrule_desc_' . $langcode['language_code'], 'class' => 'form-control input-sm', 'type' => 'text', 'maxlength' => '255')) ?>
                        <div  class="arrow-up <?php echo 'evalrule_desc_' . $langcode['language_code'] . '_error'; ?>"></div>
                        <div id="<?php echo 'evalrule_desc_' . $langcode['language_code'] . '_error'; ?>" class="form-error <?php echo 'evalrule_desc_' . $langcode['language_code'] . '_error'; ?>"></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class = "card-footer" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group"> 
                        <label><?php echo __('lblconstuctiontye'); ?></label>    
                        <?php
                        $contsruction_type = ['Y' => 'Yes', 'N' => 'No'];
                        echo $this->Form->select('contsruction_type_flag', $contsruction_type, ['id' => 'contsruction_type_flag', 'empty' => 'select', 'class' => 'form-select']);
                        ?>
                        <div  class="arrow-up contsruction_type_flag_error"></div>
                        <div id="contsruction_type_flag_error" class="form-error contsruction_type_flag_error"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group"> 
                        <label><?php echo __('lbldepreciation'); ?></label>    
                        <?php
                        $depreciation = ['Y' => 'Yes', 'N' => 'No'];
                        echo $this->Form->select('depreciation_flag', $depreciation, ['id' => 'depreciation_flag', 'empty' => 'select', 'class' => 'form-select']);
                        ?>
                        <div  class="arrow-up depreciation_flag_error"></div>
                        <div id="depreciation_flag_error" class="form-error depreciation_flag_error"></div>
                    </div> 
                </div>
                <div class="col-md-4">
                    <div class="form-group"> 
                        <label><?php echo __('lblroadvicinity'); ?></label>    
                        <?php
                        $road_vicinity_flag = ['Y' => 'Yes', 'N' => 'No'];
                        echo $this->Form->select('road_vicinity_flag', $road_vicinity_flag, ['id' => 'road_vicinity_flag', 'empty' => 'select', 'class' => 'form-select']);
                        ?>
                        <div  class="arrow-up road_vicinity_flag_error"></div>
                        <div id="road_vicinity_flag_error" class="form-error road_vicinity_flag_error"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group"> 
                        <label><?php echo __('lbluserdependencyflag1'); ?></label>    
                        <?php
                        $user_defined_dependency1_flag = ['Y' => 'Yes', 'N' => 'No'];
                        echo $this->Form->select('user_defined_dependency1_flag', $user_defined_dependency1_flag, ['id' => 'user_defined_dependency1_flag', 'empty' => 'select', 'class' => 'form-select']);
                        ?>
                        <div  class="arrow-up user_defined_dependency1_flag_error"></div>
                        <div id="user_defined_dependency1_flag_error" class="form-error user_defined_dependency1_flag_error"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group"> 
                        <label><?php echo __('lbluserdependencyflag2'); ?></label>    
                        <?php
                        $user_defined_dependency2_flag = ['Y' => 'Yes', 'N' => 'No'];
                        echo $this->Form->select('user_defined_dependency2_flag', $user_defined_dependency2_flag, ['id' => 'user_defined_dependency2_flag', 'empty' => 'select', 'class' => 'form-select']);
                        ?>
                        <div  class="arrow-up user_defined_dependency2_flag_error"></div>
                        <div id="user_defined_dependency2_flag_error" class="form-error user_defined_dependency2_flag_error"></div>

                    </div> 
                </div>
            </div>
        </div>
    </div>       

    <div class = "card-footer" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group"> 
                        <label><?php echo __('Location Dependency'); ?></label>    
                        <?php
                        $location_dependency_flag = ['Y' => 'Yes', 'N' => 'No'];
                        echo $this->Form->select('location_dependency_flag', $location_dependency_flag, ['id' => 'location_dependency_flag', 'empty' => 'select', 'class' => 'form-select']);
                        ?>

                        <div  class="arrow-up location_dependency_flag_error"></div>
                        <div id="location_dependency_flag_error" class="form-error location_dependency_flag_error"></div>
                    </div>
                </div>
                <div class="col-md-4 location_dependency" style="display:none">
                    <div class="form-group">

                        <div class="card card-info">
                            <div class="card-header">  
                                <h3 class="card-title">   
                                    <label><?php echo __('lbladmdistrict'); ?></label> </h3>
                            </div>
                            <div class="card-body max-height150">
                                <?php
                                echo $this->Form->select('district_id', $Districtdata, ['type' => 'select', 'multiple' => 'checkbox', 'id' => 'district_id']);
                                ?>
                            </div>
                        </div>
                        <div  class="arrow-up district_id_error"></div>
                        <div id="district_id_error" class="form-error district_id_error"></div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class = "card-footer" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group"> 
                        <label><?php echo __('lblAdditionRateRequired'); ?>[RR1]</label>    
                        <?php
                        $additional_rate_flag = ['Y' => 'Yes', 'N' => 'No'];
                        echo $this->Form->select('additional_rate_flag', $additional_rate_flag, ['id' => 'additional_rate_flag', 'empty' => 'select', 'class' => 'form-select']);
                        ?>

                        <div  class="arrow-up additional_rate_flag_error"></div>
                        <div id="additional_rate_flag_error" class="form-error additional_rate_flag_error"></div> 
                    </div>
                </div>
                <div class="col-md-4 additonalRate" style="display:none">
                    <div class="form-group">
                        <label><?php echo __('lblusamaincat'); ?></label>
                        <?php
                        echo $this->Form->select('add_usage_main_catg_id', $MainCatglist, ['empty' => '--Select Main Category--', 'class' => 'form-select', 'id' => 'add_usage_main_catg_id']);
                        ?>
                        <div  class="arrow-up add_usage_main_catg_id_error"></div>
                        <div id="add_usage_main_catg_id_error" class="form-error add_usage_main_catg_id_error"></div> 
                    </div>
                </div>
                <div class="col-md-4 additonalRate" style="display:none" >
                    <div class="form-group">
                        <label><?php echo __('lblsubcat'); ?></label>
                        <?php
                        echo $this->Form->select('add_usage_sub_catg_id', $subcatlist, ['empty' => '--Select Sub Category--', 'class' => 'form-select', 'id' => 'add_usage_sub_catg_id']);
                        ?>
                        <div  class="arrow-up add_usage_sub_catg_id_error"></div>
                        <div id="add_usage_sub_catg_id_error" class="form-error add_usage_sub_catg_id_error"></div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class = "card-footer" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group"> 
                        <label><?php echo __('lblAdditionRateRequired') . ' 1'; ?> [RR5]</label>    
                        <?php
                        $additional1_rate_flag = ['Y' => 'Yes', 'N' => 'No'];
                        echo $this->Form->select('additional1_rate_flag', $additional1_rate_flag, ['id' => 'additional1_rate_flag', 'empty' => 'select', 'class' => 'form-select']);
                        ?>
                        <div  class="arrow-up additional1_rate_flag_error"></div>
                        <div id="additional1_rate_flag_error" class="form-error additional1_rate_flag_error"></div> 
                    </div>
                </div>
                <div class="col-md-4 additonal1Rate" style="display:none">
                    <div class="form-group">
                        <label><?php echo __('lblusamaincat'); ?></label>
                        <?php
                        echo $this->Form->select('add1_usage_main_catg_id', $MainCatglist, ['empty' => '--Select Main Category--', 'class' => 'form-select', 'id' => 'add1_usage_main_catg_id']);
                        ?>
                        <div  class="arrow-up add1_usage_main_catg_id_error"></div>
                        <div id="add1_usage_main_catg_id_error" class="form-error add1_usage_main_catg_id_error"></div> 
                    </div>
                </div>
                <div class="col-md-4 additonal1Rate" style="display:none">
                    <div class="form-group">
                        <label><?php echo __('lblsubcat'); ?></label>
                        <?php
                        echo $this->Form->select('add1_usage_sub_catg_id', $subcatlist, ['empty' => '--Select Sub Category--', 'class' => 'form-select', 'id' => 'add1_usage_sub_catg_id']);
                        ?>
                        <div  class="arrow-up add1_usage_sub_catg_id_error"></div>
                        <div id="add1_usage_sub_catg_id_error" class="form-error add1_usage_sub_catg_id_error"></div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class = "card-footer" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group"> 
                        <label><?php echo __('lblRateCompareRequired'); ?> [ABE]</label>    
                        <?php
                        $rate_compare_flag = ['Y' => 'Yes', 'N' => 'No'];
                        echo $this->Form->select('rate_compare_flag', $rate_compare_flag, ['id' => 'rate_compare_flag', 'empty' => 'select', 'class' => 'form-select']);
                        ?>

                        <div  class="arrow-up rate_compare_flag_error"></div>
                        <div id="rate_compare_flag_error" class="form-error rate_compare_flag_error"></div> 
                    </div>
                </div>
                <div class="col-md-4 comparisonRate" style="display:none"">
                    <div class="form-group">
                        <label><?php echo __('lblusamaincat'); ?></label>
                        <?php
                        echo $this->Form->select('cmp_usage_main_catg_id', $MainCatglist, ['empty' => '--Select Main Category--', 'class' => 'form-select', 'id' => 'cmp_usage_main_catg_id']);
                        ?>
                        <div  class="arrow-up cmp_usage_main_catg_id_error"></div>
                        <div id="cmp_usage_main_catg_id_error" class="form-error cmp_usage_main_catg_id_error"></div> 
                    </div>
                </div>
                <div class="col-md-4 comparisonRate" style="display:none"">
                    <div class="form-group">
                        <label><?php echo __('lblsubcat'); ?></label>
                        <?php
                        echo $this->Form->select('cmp_usage_sub_catg_id', $subcatlist, ['empty' => '--Select Sub Category--', 'class' => 'form-select', 'id' => 'cmp_usage_sub_catg_id']);
                        ?>
                        <div  class="arrow-up cmp_usage_sub_catg_id_error"></div>
                        <div id="cmp_usage_sub_catg_id_error" class="form-error cmp_usage_sub_catg_id_error"></div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class = "card-footer" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group"> 
                        <div class="card card-info">
                            <div class="card-header">  
                                <h2 class="card-title">   
                                    <label><?php echo __('lblruleapplicable'); ?></label>  </h2> </div>
                            <div class="max-height150">
                                <?php
                                echo $this->Form->select('developlandtype_id', $Developmentlandtype, ['type' => 'select', 'multiple' => 'checkbox', 'id' => 'developlandtype_id']);
                                ?>
                            </div>
                        </div>
                        <div  class="arrow-up developlandtype_id_error"></div>
                        <div id="developlandtype_id_error" class="form-error developlandtype_id_error"></div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--//location dependency-->


    <div class="form-group"><center>
            <?= $this->Form->submit(__('Submit'), ['class' => 'btn btn-info']); ?>
        </center>

    </div>


</div>