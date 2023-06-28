<?php
echo $this->element("Helper/jqueryhelper");
?>
<script type="text/javascript">
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    $(document).ready(function () {

        //$('[data-toggle="tooltip"]').tooltip();

        $("body").tooltip({selector: '[data-toggle=tooltip]'});

//-----------------------------------------------------------------------------------------------------------------------------------------------
        $('#presentation_date,#link_doc_date,#exec_date,#ref_doc_date,#court_order_date,#entry_date_india,.datepicker').datepicker({
            todayBtn: "linked",
            language: "it",
            autoclose: true,
            todayHighlight: true,
            endDate: '+0d',
            format: "dd-mm-yyyy"
        });

        $('#article_id').change(function () {
            var article_id = $('#article_id').val();
           
           //  get article title
            $.postJSON('<?php
            echo $this->Url->build([
                'controller' => 'Generalinfo',
                'action' => 'getarticledescdetailslist',])
            ?>', {article_id: article_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
            {
                //alert('in post');
                var sc = '<option value="">--select--</option>';
                $.each(data, function (index, val) {

                    sc += "<option value=" + index + ">" + val + "</option>";
                });
                $("#title_id option").remove();
                $("#title_id").append(sc);
            });
            
            // get article dependent fields
            getDependentArticle();
            
        });

        $('#district_id').change(function () {
            var dist = $("#district_id option:selected").val();
            //alert(dist); return false;
            dist_change_event(dist);
            village_change_dist_event(dist);
        });

        $('#taluka_id').change(function () {
            var district_id = $('#district_id').val();
            var taluka_id = $('#taluka_id').val();
            //get village list from
            $.postJSON('<?php
echo $this->Url->build([
    'controller' => 'Master',
    'action' => 'getvillage',])
?>', {district_id: district_id, taluka_id: taluka_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
            {

                var sc = '<option value="">--select--</option>';
                $.each(data, function (index, val) {

                    sc += "<option value=" + index + ">" + val + "</option>";
                });
                $("#village_id option").remove();
                $("#village_id").append(sc);
            });

            $.postJSON('<?php
echo $this->Url->build([
    'controller' => 'Generalinfo',
    'action' => 'getOfficeFromDist',])
?>', {district_id: district_id, taluka_id: taluka_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
            {
                //alert('in post');
                var sc = '<option value="">--select--</option>';
                $.each(data, function (index, val) {

                    sc += "<option value=" + index + ">" + val + "</option>";
                });
                $("#office_id option").remove();
                $("#office_id").append(sc);
            });
        });

        $('#village_id').change(function () {
            var village_id = $('#village_id').val();
            var taluka_id = $('#taluka_id').val();
            $.postJSON('<?php
echo $this->Url->build([
    'controller' => 'Generalinfo',
    'action' => 'getOfficeFromDist',])
?>', {taluka_id: taluka_id, village_id: village_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
            {
                //alert('in post');
                var sc = '<option value="">--select--</option>';
                $.each(data, function (index, val) {

                    sc += "<option value=" + index + ">" + val + "</option>";
                });
                $("#office_id option").remove();
                $("#office_id").append(sc);
            });
        });

        tougleCourtOrderDate($("#doc_execution_type_id").val());
        $("#doc_execution_type_id").change(function () {
            tougleCourtOrderDate($(this).val());
        });

        /* Import data div hide & Show on clicking of radio button */
        $("#import_data_div").hide();
        $("#importdataval-1").click(function () {
            $("#import_data_div").hide();
        });

        $("#importdataval-2").click(function () {
            $("#import_data_div").show();
        });

    });

    function getDependentArticle() {
        var article_id = $('#article_id').val();
        //alert(article_id);
        $.post('<?php
        echo $this->Url->build([
            'controller' => 'Generalinfo',
            'action' => 'getdependentarticle',])
        ?>', {article_id: article_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
        {
            $("#depfd").html(data);
        });
        
    }
    
    function dist_change_event(district_id) {
        $.postJSON('<?php
        echo $this->Url->build([
            'controller' => 'Master',
            'action' => 'gettalukadist',])
        ?>', {district_id: district_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
        {
            //alert('in post');
            var sc = '<option value="">--select--</option>';
            $.each(data, function (index, val) {

                sc += "<option value=" + index + ">" + val + "</option>";
            });
            $("#taluka_id option").remove();
            $("#taluka_id").append(sc);
        });
    }

    function village_change_dist_event(district_id) {
        $.postJSON('<?php
echo $this->Url->build([
    'controller' => 'Generalinfo',
    'action' => 'getOfficeFromDist',])
?>', {district_id: district_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
        {
            //alert('in post');
            var sc = '<option value="">--select--</option>';
            $.each(data, function (index, val) {

                sc += "<option value=" + index + ">" + val + "</option>";
            });
            $("#office_id option").remove();
            $("#office_id").append(sc);
        });
    }

    function tougleCourtOrderDate(doc_exe_type_id) {
        if (doc_exe_type_id == 3) {
            $("#court_order_div").show();
            $("#entry_date_div").hide();
            $("#entry_date_india").val('');
        } else if (doc_exe_type_id == 2) {
            $("#entry_date_div").show();
            $("#court_order_date").val('');
            $("#court_order_div").hide();
        } else {
            $("#court_order_date").val('');
            $("#court_order_div").hide();
            $("#entry_date_div").hide();
            $("#entry_date_india").val('');
        }
    }

</script>
<?= $this->Form->create(NULL, ['id' => 'generalinfoEntry']) ?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>General Information</b></h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal">
        <div class="card-body">
            <?php
            $Selectedtoken = $this->request->getSession()->read('Selectedtoken');
            if($Selectedtoken!=''){
            ?>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbltokenno'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->control('s_token', ['id' => 's_token','value'=> $Selectedtoken, 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                </div>
                <div class="col-sm-4">
                    &nbsp;
                </div>
            </div>
            <?php
            }
            ?>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblArticle'); ?></label>
                <div class="col-sm-4">
                    <?php
                    echo $this->Form->select('article_id', $articlelistdata, ['empty' => '----Article----', 'class' => 'form-select', 'id' => 'article_id']);
                    ?>  
                    <div  class="arrow-up article_id_error"></div>
                    <div id="article_id_error" class="form-error article_id_error"></div>
                </div>
                
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbldocumenttitle'); ?></label>
                <div class="col-sm-4">
                    <?php
                    echo $this->Form->select('title_id', array(), ['empty' => '----Document Title----', 'class' => 'form-select', 'id' => 'title_id']);
                    ?>
                    <div  class="arrow-up title_id_error"></div>
                    <div id="title_id_error" class="form-error title_id_error"></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblnoofpages'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->control('no_of_pages', ['id' => 'no_of_pages', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    <div  class="arrow-up no_of_pages_error"></div>
                    <div id="no_of_pages_error" class="form-error no_of_pages_error"></div>
                </div>
                <?php if ($annexure_config['is_boolean'] == 'Y' && $annexure_config['conf_bool_value'] == 'Y') { ?>
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblannexure'); ?></label>
                    <div class="col-sm-4">
                        <?= $this->Form->control('no_of_pages_annexure', ['id' => 'no_of_pages_annexure', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                        <div  class="arrow-up no_of_pages_annexure_error"></div>
                        <div id="no_of_pages_annexure_error" class="form-error no_of_pages_annexure_error"></div>
                    </div>
                <?php } ?>
            </div>
            
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbldelayorderno'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->control('delay_order_no', ['id' => 'delay_order_no', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    <div  class="arrow-up delay_order_no_error"></div>
                    <div id="delay_order_no_error" class="form-error delay_order_no_error"></div>
                </div>
               
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbldelayremark'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->control('delay_remark', ['id' => 'delay_remark', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    <div  class="arrow-up delay_remark_error"></div>
                    <div id="delay_remark_error" class="form-error delay_remark_error"></div>
                </div>
               
            </div>
            
            
            
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblexecutiontype'); ?></label>
                <div class="col-sm-4">
                    <?php
                    echo $this->Form->select('doc_execution_type_id', $docexetypedata, ['empty' => '----Document Execution Type----', 'class' => 'form-select', 'id' => 'doc_execution_type_id']);
                    ?>
                    <div  class="arrow-up doc_execution_type_id_error"></div>
                        <div id="doc_execution_type_id_error" class="form-error doc_execution_type_id_error"></div>
                </div>
                <?php if ($advname_config['is_boolean'] == 'Y' && $advname_config['conf_bool_value'] == 'Y') { ?>
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbladvtname'); ?></label>
                    <div class="col-sm-4">
                        <?= $this->Form->control('adv_name_en', ['id' => 'adv_name_en', 'class' => 'form-control', 'label' => false, 'autocomplete'=> 'off']) ?>
                        <div  class="arrow-up adv_name_en_error"></div>
                        <div id="adv_name_en_error" class="form-error adv_name_en_error"></div>
                    </div>
                <?php }?>
            </div>
            
            <div class="form-group row" id="court_order_div">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblCourtOrderDate'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->input('court_order_date', array('label' => false, 'id' => 'court_order_date', 'class' => 'form-control input-sm', 'data-date-format' => "mm/dd/yyyy", 'type' => 'text', 'autocomplete'=> 'off')); ?>
                    
                </div>               
            </div>
            
            <div class="form-group row" id="entry_date_div">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblentrydateindia'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->input('entry_date_india', array('label' => false, 'id' => 'entry_date_india', 'class' => 'form-control input-sm', 'data-date-format' => "mm/dd/yyyy", 'type' => 'text', 'autocomplete'=> 'off')); ?>
                </div>               
            </div>
            
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblexecutiondt'); ?></label>
                <div class="col-sm-4">
                    <?php if (isset($exe_date)) { ?>
                        <?php echo $this->Form->input('exec_date', array('label' => false, 'id' => 'exec_date', 'class' => 'form-control input-sm', 'data-date-format' => "mm/dd/yyyy", 'value' => $exe_date, 'type' => 'text', 'autocomplete'=> 'off')); ?>
                    <?php } else { ?>
                        <?php echo $this->Form->input('exec_date', array('label' => false, 'id' => 'exec_date', 'class' => 'form-control input-sm', 'data-date-format' => "mm/dd/yyyy", 'type' => 'text', 'autocomplete'=> 'off')); ?>
                    <?php } ?>     
                    <div  class="arrow-up exec_date_error"></div>
                    <div id="exec_date_error" class="form-error exec_date_error"></div>
                </div>    
                <?php 
                if ($presentationdt['is_boolean'] == 'Y' && $presentationdt['conf_bool_value'] == 'Y') { ?>
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblpresentationdate'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->input('presentation_date', array('label' => false, 'id' => 'presentation_date', 'class' => 'form-control input-sm', 'data-date-format' => "mm/dd/yyyy", 'type' => 'text', 'autocomplete'=> 'off')); ?>
                </div>  
                <?php 
                }
                ?>
            </div>   
            <div class="form-group row">
                <?php if ($old_reg_flag['is_boolean'] == 'Y' && $old_reg_flag['conf_bool_value'] == 'Y') { ?>
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblregno'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->control('sale_reg_no', ['id' => 'sale_reg_no', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'placeholder' => 'Please Enter old Registration No for Sale']) ?>
                    <div  class="arrow-up sale_reg_no_error"></div>
                    <div id="sale_reg_no_error" class="form-error sale_reg_no_error"></div>
                </div>
                <?php 
                }
                ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-primary collapsed-card">
              <div class="card-header">
                  <h3 class="card-title"><b><?php echo __('lblimportdata'); ?></b></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblrefdocno'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->input('ref_doc_no', array('label' => false, 'id' => 'ref_doc_no', 'autocomplete'=> 'off', 'class' => 'form-control input-sm', 'type' => 'text', 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'top', 'title' => 'Is required to fetch party name from old document')); ?>

                </div>
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblrefregdocdate'); ?></label>
                <div class="col-sm-4">
                   <?php echo $this->Form->input('ref_doc_date', array('label' => false, 'id' => 'ref_doc_date', 'autocomplete'=> 'off', 'class' => 'form-control input-sm', 'type' => 'text', 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'top', 'title' => 'Is required to fetch party name from old document')); ?>

                </div>
            </div>
            <div class="form-group row">
                <?php if($linkoffice_applicable['is_boolean'] == 'Y' && $linkoffice_applicable['conf_bool_value'] == 'Y') { ?>
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbllnkofficename'); ?></label>
                    <div class="col-sm-4">
                         <?php
                        echo $this->Form->select('link_office_id', $officelistdata, ['empty' => '----Link Office Name----', 'class' => 'form-select', 'id' => 'link_office_id']);
                        ?>                
                    </div>    
                <?php
                }
                ?>
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbllnkdocno'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->input('link_doc_no', array('label' => false, 'id' => 'link_doc_no', 'autocomplete'=> 'off', 'class' => 'form-control input-sm', 'type' => 'text', 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'top', 'title' => 'Is  previous registration number for this property')); ?>
                </div>
               
            </div>
            
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbldocdate'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->input('link_doc_date', array('label' => false, 'id' => 'link_doc_date', 'autocomplete'=> 'off','class' => 'form-control input-sm', 'type' => 'text', 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'top', 'title' => 'Is  previous registration number for this property')); ?>

                </div>
                <?php if($office_details_applicable['is_boolean'] == 'Y' && $office_details_applicable['conf_bool_value'] == 'Y') { ?>
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblofficedetails'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->input('office_details', array('label' => false, 'id' => 'office_details', 'autocomplete'=> 'off', 'class' => 'form-control input-sm', 'type' => 'text', 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'top')); ?>
                </div>
                <?php
                }
                ?>
            </div>
                  
            
        </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        <div class="col-md-12">
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><b>Document Submission Office Details</b></h3>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbladmdistrict'); ?></label>
                    <div class="col-sm-4">
                       <?php
                        echo $this->Form->select('district_id', $districtlistdata, ['empty' => '----District----', 'class' => 'form-select', 'id' => 'district_id']);
                        ?>
                        <div  class="arrow-up district_id_error"></div>
                        <div id="district_id_error" class="form-error district_id_error"></div>
                    </div>
                    <?php if($tehsil_config['is_boolean'] == 'Y' && $tehsil_config['conf_bool_value'] == 'Y') { ?>
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbladmtaluka'); ?></label>
                    <div class="col-sm-4">
                        <?php
                            echo $this->Form->select('taluka_id', array(), ['empty' => '----Tehsil----', 'class' => 'form-select', 'id' => 'taluka_id']);
                        ?>
                        <div  class="arrow-up taluka_id_error"></div>
                        <div id="taluka_id_error" class="form-error taluka_id_error"></div>
                    </div>
                    <?php } ?>
                </div>

                <div class="form-group row">
                    <?php if($village_config['is_boolean'] == 'Y' && $village_config['conf_bool_value'] == 'Y') { ?>
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblcityvillage'); ?></label>
                    <div class="col-sm-4">
                        <?php
                        echo $this->Form->select('village_id', array(), ['empty' => '----Village----', 'class' => 'form-select', 'id' => 'village_id']);
                        ?>
                        <div  class="arrow-up village_id_error"></div>
                        <div id="village_id_error" class="form-error village_id_error"></div>
                    </div>
                    <?php } ?>
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblofficename'); ?></label>
                    <div class="col-sm-4">
                        <?php
                            echo $this->Form->select('office_id', array(), ['empty' => '----Office----', 'class' => 'form-select', 'id' => 'office_id']);
                        ?>  
                        <div  class="arrow-up office_id_error"></div>
                        <div id="office_id_error" class="form-error office_id_error"></div>
                    </div>
                </div>
            </div>
       
        </div></div>
        
        
            <?php if($suo_motu_applicable['is_boolean'] == 'Y' && $suo_motu_applicable['conf_bool_value'] == 'Y') { ?>
                <div class="col-md-12">
                    <div class="card card-primary">

                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label"><?php echo __('lblsuomotu'); ?></label>
                                <div class="col-sm-4" class="custom-control custom-radio">
                                   <?php
                                    if(sizeof($getresult)>0)
                                    {
                                        if($getresult['suo_motu_flag'] == 'Y')
                                        {
                                            echo $this->Form->radio('suo_motu_flag',$sizesradio, ['default' => 'N', 'value' => 'Y']);
                                        }
                                        else{
                                            echo $this->Form->radio('suo_motu_flag',$sizesradio, ['default' => 'N', 'value' => 'N']);
                                        }
                                    }
                                    //echo $this->Form->input('suo_motu_flag', array('type' => 'radio', 'options' => array('Y' => '&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;', 'N' => '&nbsp;No'), 'value' => 'Y', 'legend' => false, 'div' => false, 'class' => 'select')); 
                                    //echo $this->Form->radio('size', $sizesradio, ['default' => 'm']);
                                    //echo $this->Form->select('district_id', $districtlistdata, ['empty' => '----District----', 'class' => 'form-select', 'id' => 'district_id']);
                                    ?>
                                    <!--<div  class="arrow-up district_id_error"></div>
                                    <div id="district_id_error" class="form-error district_id_error"></div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
            }
            ?>
        <div id="depfd">
        </div>  
        
        <div class="card-footer center">
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="submit" class="btn btn-danger">Cancel</button>
        </div>
        <!-- /.card-footer -->
    </form>
</div>

<?= $this->Form->end() ?>