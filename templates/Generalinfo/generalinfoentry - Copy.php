<?php
echo $this->element("Helper/jqueryhelper");
?>
<script type="text/javascript">
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    $(document).ready(function () {

        //$('[data-toggle="tooltip"]').tooltip();

        $("body").tooltip({selector: '[data-toggle=tooltip]'});

//-----------------------------------------------------------------------------------------------------------------------------------------------
        $('#exec_date,#ref_doc_date,#court_order_date,#entry_date_india,.datepicker').datepicker({
            todayBtn: "linked",
            language: "it",
            autoclose: true,
            todayHighlight: true,
            endDate: '+0d',
            format: "dd-mm-yyyy"
        });

        $('#article_id').change(function () {
            var article_id = $('#article_id').val();
            // alert(article_id);
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
<?= $this->Form->create() ?>
<div class = "card ">
    <div class = "card-header bg-info">
        <h3 class = "card-title">General Information </h3>             
    </div>
    <div class = "card-body" >
        <div class="row">
            <div class="col-md-12">
                <p style="color: red;"><b><?php echo __('lblnote'); ?>1:&nbsp;</b><?php echo __('lblengdatarequired'); ?></br>
                    <b><?php echo __('lblnote'); ?>2:&nbsp;</b><?php echo __('lblrefdocnofetchparty'); ?></br>
                    <b><?php echo __('lblnote'); ?>3:&nbsp;</b><?php echo __('lbllinkdocregno'); ?></p>
            </div>
        </div>
        <?php //echo $this->Form->input('local_language_id', array('type' => 'select', 'label' => false, 'id' => 'local_language_id', 'style' => 'cursor: not-allowed;', 'disabled', 'class' => 'form-control input-sm', 'options' => $language, 'default' => $this->Session->read('doc_lang_id'), 'value' => $lang_id)); ?>

        <div class="row">
            <div class="col-md-3">
                <label><?php echo __('lblArticle'); ?></label>
            </div>                
            <div class="col-md-3">                    
                <div class="form-group">                        
                    <?php
                    echo $this->Form->select('article_id', $articlelistdata, ['empty' => '--select--', 'class' => 'form-select', 'id' => 'article_id']);
                    ?>
                    <div  class="arrow-up article_id_error"></div>
                    <div id="article_id_error" class="form-error article_id_error"></div>
                </div>
            </div>

            <div class="col-md-3">
                <label><?php echo __('lbldocumenttitle'); ?></label>    
            </div>
            <div class="col-md-3">
                <div class="form-group">                        
                    <?php
                    echo $this->Form->select('title_id', array(), ['empty' => '--select--', 'class' => 'form-select', 'id' => 'title_id']);
                    ?>
                    <div  class="arrow-up title_id_error"></div>
                    <div id="prop_level1_title_id_error" class="form-error title_id_error"></div>
                </div>
            </div>
        </div>
        &nbsp;
        <div class="row">
            <div class="col-md-3">
                <label><?php echo __('lblnoofpages'); ?></label>
            </div>                
            <div class="col-md-3">                    
                <div class="form-group">                        
                    <?= $this->Form->control('no_of_pages', ['id' => 'no_of_pages', 'class' => 'form-control', 'required' => true, 'label' => false]) ?>
                    <div  class="arrow-up no_of_pages_error"></div>
                    <div id="no_of_pages_error" class="form-error no_of_pages_error"></div>
                </div>
            </div>
            <?php
            if ($annexureboolinfores['conf_bool_value'] = 'Y') {
                ?>
                <div class="col-md-3">
                    <label><?php echo __('lblannexure'); ?></label>
                </div>
                <div class="col-md-3">
                    <div class="form-group">                        
                        <?= $this->Form->control('no_of_pages_annexure', ['id' => 'no_of_pages_annexure', 'class' => 'form-control', 'required' => true, 'label' => false]) ?>
                        <div  class="arrow-up no_of_pages_annexure_error"></div>
                        <div id="no_of_pages_annexure_error" class="form-error no_of_pages_annexure_error"></div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        &nbsp;
        <div class="row">
            <div class="col-md-3">
                <label><?php echo __('lblexecutiontype'); ?></label>
            </div>                
            <div class="col-md-3">                    
                <div class="form-group">                        
                    <?php
                    echo $this->Form->select('doc_execution_type_id', $docexetypedata, ['empty' => '--select--', 'class' => 'form-select', 'id' => 'doc_execution_type_id']);
                    ?>
                    <div  class="arrow-up doc_execution_type_id_error"></div>
                    <div id="doc_execution_type_id_error" class="form-error doc_execution_type_id_error"></div>
                </div>
            </div>

            <div class="col-md-3">
                <label><?php echo __('lbladvtname'); ?></label>
            </div>                
            <div class="col-md-3">                    
                <div class="form-group">                        
                    <?= $this->Form->control('adv_name_en', ['id' => 'adv_name_en', 'class' => 'form-control', 'required' => true, 'label' => false]) ?>
                    <div  class="arrow-up adv_name_en_error"></div>
                    <div id="adv_name_en_error" class="form-error adv_name_en_error"></div>
                </div>
            </div>
        </div>

        <div class="row" id="court_order_div">
            <div class="col-md-3">
                <label><?php echo __('lblCourtOrderDate'); ?></label>
            </div>                
            <div class="col-md-3">                    
                <div class="form-group">                        
                    <?php echo $this->Form->input('court_order_date', array('label' => false, 'id' => 'court_order_date', 'class' => 'form-control input-sm', 'data-date-format' => "mm/dd/yyyy", 'type' => 'text')); ?>

                    <div  class="arrow-up court_order_date_error"></div>
                    <div id="court_order_date_error" class="form-error court_order_date_error"></div>
                </div>
            </div>
        </div>

        <div class="row" id="entry_date_div">
            <div class="col-md-3">
                <label><?php echo __('lblentrydateindia'); ?></label>
            </div>                
            <div class="col-md-3">                    
                <div class="form-group">                        
                    <?php echo $this->Form->input('entry_date_india', array('label' => false, 'id' => 'entry_date_india', 'class' => 'form-control input-sm', 'data-date-format' => "mm/dd/yyyy", 'type' => 'text')); ?>
                    <div  class="arrow-up entry_date_india_error"></div>
                    <div id="entry_date_india_error" class="form-error entry_date_india_error"></div>
                </div>
            </div>
        </div>
    </div>
    <div class = "card-body" >
        <div class="row">
            <div class="col-md-3">
                <label><?php echo __('lblexecutiondt'); ?></label>
            </div>                
            <div class="col-md-3">                    
                <div class="form-group">                        
                    <?php if (isset($exe_date)) { ?>
                        <?php echo $this->Form->input('exec_date', array('label' => false, 'id' => 'exec_date', 'class' => 'form-control input-sm', 'data-date-format' => "mm/dd/yyyy", 'value' => $exe_date, 'type' => 'text')); ?>
                    <?php } else { ?>
                        <?php echo $this->Form->input('exec_date', array('label' => false, 'id' => 'exec_date', 'class' => 'form-control input-sm', 'data-date-format' => "mm/dd/yyyy", 'type' => 'text')); ?>
                    <?php } ?>                        
                    <div  class="arrow-up exec_date_error"></div>
                    <div id="exec_date_error" class="form-error exec_date_error"></div>
                </div>
            </div>
        </div>
    </div>
    <div class = "card-body" >
        <div class="row">
            <div class="col-md-3">
                <label><?php echo __('Import data from previously registered Document'); ?></label>
            </div>                
            <div class="col-md-3">                    
                <div class="form-group">                        
                    <?php
                    $values = ['1' => 'No', '2' => 'Yes'];
                    echo $this->Form->radio('importdataval', $values, ['default' => '1']);
                    ?>                       
                    <div  class="arrow-up exec_date_error"></div>
                    <div id="exec_date_error" class="form-error exec_date_error"></div>
                </div>
            </div>
        </div>
    </div>
    <div class = "card-body" id="import_data_div">
        <div class="row">
            <div class="col-md-3">
                <label><?php echo __('lblrefdocno'); ?></label>
            </div>                
            <div class="col-md-3">                    
                <div class="form-group">                        
                    <?php echo $this->Form->input('ref_doc_no', array('label' => false, 'id' => 'ref_doc_no', 'class' => 'form-control input-sm', 'type' => 'text', 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'top', 'title' => 'Is required to fetch party name from old document')); ?>

                    <div  class="arrow-up ref_doc_no_error"></div>
                    <div id="ref_doc_no_error" class="form-error ref_doc_no_error"></div>
                </div>
            </div>

            <div class="col-md-3">
                <label><?php echo __('lblrefregdocdate'); ?></label>
            </div>
            <div class="col-md-3">
                <div class="form-group">                        
                    <?php echo $this->Form->input('ref_doc_date', array('label' => false, 'id' => 'ref_doc_date', 'class' => 'form-control input-sm', 'type' => 'text', 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'top', 'title' => 'Is required to fetch party name from old document')); ?>

                    <div  class="arrow-up ref_doc_date_error"></div>
                    <div id="ref_doc_date_error" class="form-error ref_doc_date_error"></div>
                </div>
            </div>
        </div>
        &nbsp;

        <div class="row">
            <div class="col-md-3">
                <label><?php echo __('lbllnkofficename'); ?></label>
            </div>                
            <div class="col-md-3">                    
                <div class="form-group">                        
                    <?php
                    echo $this->Form->select('link_office_id', $officelistdata, ['empty' => '--select--', 'class' => 'form-select', 'id' => 'link_office_id']);
                    ?>
                    <div  class="arrow-up link_office_id_error"></div>
                    <div id="link_office_id_error" class="form-error link_office_id_error"></div>
                </div>
            </div>

            <div class="col-md-3">
                <label><?php echo __('lbllnkdocno'); ?></label>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?php echo $this->Form->input('link_doc_no', array('label' => false, 'id' => 'link_doc_no', 'class' => 'form-control input-sm', 'type' => 'text', 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'top', 'title' => 'Is  previous registration number for this property')); ?>
                    <div  class="arrow-up link_doc_no_error"></div>
                    <div id="link_doc_no_error" class="form-error link_doc_no_error"></div>
                </div>
            </div>
        </div>
        &nbsp;
        <div class="row">
            <div class="col-md-3">
                <label><?php echo __('lbldocdate'); ?></label>
            </div>                
            <div class="col-md-3">                    
                <div class="form-group">                        
                    <?php echo $this->Form->input('link_doc_date', array('label' => false, 'id' => 'link_doc_date', 'class' => 'form-control input-sm', 'type' => 'text', 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'top', 'title' => 'Is  previous registration number for this property')); ?>
                    <div  class="arrow-up link_doc_date_error"></div>
                    <div id="link_doc_date_error" class="form-error link_doc_date_error"></div>
                </div>
            </div>
        </div>
    </div>

    <div class = "card-body" >
        <div class="row">
            <div class="col-md-3">
                <label><?php echo __('lbladmdistrict'); ?></label>
            </div>                
            <div class="col-md-3">                    
                <div class="form-group">                        
                    <?php
                    echo $this->Form->select('district_id', $districtlistdata, ['empty' => '--select--', 'class' => 'form-select', 'id' => 'district_id']);
                    ?>
                    <div  class="arrow-up district_id_error"></div>
                    <div id="district_id_error" class="form-error district_id_error"></div>
                </div>
            </div>
            <?php if ($tehsildisplayres['is_boolean'] == 'Y' && $tehsildisplayres['conf_bool_value'] == 'Y') { ?>
                <div class="col-md-3">
                    <label><?php echo __('lbladmtaluka'); ?></label>
                </div>
                <div class="col-md-3">
                    <div class="form-group">                        
                        <?php
                        echo $this->Form->select('taluka_id', array(), ['empty' => '--select--', 'class' => 'form-select', 'id' => 'taluka_id']);
                        ?>
                        <div  class="arrow-up taluka_id_error"></div>
                        <div id="taluka_id_error" class="form-error taluka_id_error"></div>
                    </div>
                </div>
            <?php } ?> 
        </div>
        &nbsp;

        <div class="row">
            <div class="col-md-3">
                <label><?php echo __('lblcityvillage'); ?></label>
            </div>                
            <div class="col-md-3">                    
                <div class="form-group">                        
                    <?php
                    echo $this->Form->select('village_id', array(), ['empty' => '--select--', 'class' => 'form-select', 'id' => 'village_id']);
                    ?>
                    <div  class="arrow-up village_id_error"></div>
                    <div id="village_id_error" class="form-error village_id_error"></div>
                </div>
            </div>

            <div class="col-md-3">
                <label><?php echo __('lblofficename'); ?></label>
            </div>
            <div class="col-md-3">
                <div class="form-group"> 
                    <?php
                    echo $this->Form->select('office_id', array(), ['empty' => '--select--', 'class' => 'form-select', 'id' => 'office_id']);
                    ?>         
                    <div  class="arrow-up office_id_error"></div>
                    <div id="office_id_error" class="form-error office_id_error"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-info float-right">Cancel</button>               
    </div>
</div>



<?= $this->Form->end() ?>