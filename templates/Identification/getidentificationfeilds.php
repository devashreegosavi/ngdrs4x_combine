<?php
echo $this->element("Helper/jqueryhelper");
?>
<script type="text/javascript">
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    
    $(document).ready(function () {
        
         $('#datalist').dataTable({
        "iDisplayLength": 5,
                "aLengthMenu": [[5, 10, 15, 20, - 1], [5, 10, 15, 20, "All"]]
        });

        $('#district_id').change(function () {
            var district_id = $('#district_id').val();
            //alert(district_id);
            $.postJSON('gettalukadist', {district_id: district_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
            {
                var sc = '<option value="">--Select Taluka--</option>';
                $.each(data, function (index, val) {

                    sc += "<option value=" + index + ">" + val + "</option>";
                });
                $("#taluka_id option").remove();
                $("#taluka_id").append(sc);
            });
        });
        $('#taluka_id').change(function () {
            var district_id = $('#district_id').val();
            var taluka_id = $('#taluka_id').val();
            //alert(district_id);
            $.postJSON('getvillagetaluka', {district_id: district_id,taluka_id : taluka_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
            {
                var sc = '<option value="">--Select Village--</option>';
                $.each(data, function (index, val) {

                    sc += "<option value=" + index + ">" + val + "</option>";
                });
                $("#village_id option").remove();
                $("#village_id").append(sc);
            });
        });
        $('#village_id').change(function () {
            var district_id = $('#district_id').val();
            var taluka_id = $('#taluka_id').val();
            var village_id = $('#village_id').val();
            //alert(district_id);
            if(village_id!='')
            {
                $.post('<?php
                echo $this->Url->build([
                    'controller' => 'Identification',
                    'action' => 'getdependentaddress',])
                ?>', {district_id: district_id,taluka_id : taluka_id,village_id : village_id,ref_id: '5',behavioral_id : '2', '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
                {
                    //alert(data);
                    $('.identifieraddress').html(data);
                });
            }
            else{
                $('.identifieraddress').html('');
            }
        
        });

        $('#dob').datepicker({
            maxDate: '+0d',
            yearRange: '1920:2010',
            changeMonth: true,
            changeYear: true,
             format: "dd-mm-yyyy"
        });
        $("#dob").change(function ()
        {

            var dateString = $("#dob").val();
             var d1 = dateString.split("-");
           var dateString = d1[1]+'/'+d1[0]+'/'+d1[2];
            var today = new Date();
            var birthDate = new Date(dateString);
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate()))
            {
                age--;
            }
            $("#age").val(age);
        });
        
        
    });
</script>  
<?php
$this->Form->create($identifier_fields, ['id' => 'identifier_fields']);

    foreach ($identifirefields as $field) {
        //pr($field['field_id_name_en']);
            
        if (isset($identifierarr) && !empty($identifierarr)) {
            //pr($field['field_id_name_en']);
            //pr($witnessarr[0][$field['field_id_name_en']]);
            $identifier[$field['field_id_name_en']] = $identifierarr[0][$field['field_id_name_en']];
        }else{
            $identifier[$field['field_id_name_en']] = '';
        }

        //pr($field['field_id_name_en']);
?>

<div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo $field['field_name_en']; ?></label>
    <div class="col-sm-4">
        <?php
        switch ($field['field_id_name_en']) {
            case 'bank_id': echo $this->Form->select($field['field_id_name_en'], $bank_master, ['empty' => '--- Select Bank ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']]]);
            ?>
                <span id="bank_id_error" class="form-error"><?php // echo $errarr['bank_id_error'];              ?></span>
            <?php
            break;
            case 'is_executer': echo $this->Form->select($field['field_id_name_en'], $executer, ['empty' => '--- Is Executer ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']]]);
            ?>
                <span id="is_executer_error" class="form-error"><?php // echo $errarr['is_executer_error'];              ?></span>
            <?php
            break;
            case 'party_id': echo $this->Form->select($field['field_id_name_en'], $executer, ['empty' => '--- Select Party ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']]]);
            ?>
                <span id="party_id_error" class="form-error"><?php // echo $errarr['party_id_error'];              ?></span>
            <?php
            break;
            case 'salutation': echo $this->Form->select($field['field_id_name_en'], $salutation, ['empty' => '--- Select Salutation ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']] ]);
            ?>
                <span id="salutation_id_error" class="form-error"><?php // echo $errarr['salutation_id_error'];              ?></span>
            <?php
            break;
            case 'gender_id': echo $this->Form->select($field['field_id_name_en'], $gender, ['empty' => '--- Select Gender ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']]]);
            ?>
                <span id="gender_id_error" class="form-error"><?php ///echo $errarr['gender_id_error'];              ?></span>
            <?php
            break;
            case 'marital_status': echo $this->Form->select($field['field_id_name_en'], $marital_status, ['empty' => '--- Select Marital Status ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']]]);
            ?>
                <span id="marital_status_error" class="form-error"><?php ///echo $errarr['marital_status_error'];              ?></span>
            <?php
            break;
            case 'nationality': echo $this->Form->select($field['field_id_name_en'], $nationality, ['empty' => '--- Select Nationality ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']]]);
            ?>
                <span id="nationality_error" class="form-error"><?php ///echo $errarr['nationality_error'];              ?></span>
            <?php
            break;
            case 'cast_id': echo $this->Form->select($field['field_id_name_en'], $category, ['empty' => '--- Select Caste ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']]]);
            ?>
                <span id="cast_id_error" class="form-error"><?php ///echo $errarr['cast_id_error'];              ?></span>
            <?php
            break;
            case 'occupation_id':  echo $this->Form->select($field['field_id_name_en'], $occupation, ['empty' => '--- Select Occupation ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']]]);
            ?>
                <span id="occupation_id_error" class="form-error"><?php //echo $errarr['occupation_id_error'];              ?></span>
            <?php
            break;
            case 'identificationtype_id':  echo $this->Form->select($field['field_id_name_en'], $identificatontype, ['empty' => '--- Select Identification Type ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']]]);
            ?>
                <span id="identificationtype_id_error" class="form-error"><?php //echo $errarr['identificationtype_id_error'];              ?></span>
            <?php
            break;
            case 'exemption_id':  echo $this->Form->select($field['field_id_name_en'], $exemption, ['empty' => '--- Select Exemption ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']]]);
            ?>
                <span id="exemption_id_error" class="form-error"><?php //echo $errarr['exemption_id_error'];              ?></span>
            <?php
            break;
            case 'district_id':  echo $this->Form->select($field['field_id_name_en'], $districtdata, ['empty' => '--- Select District ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']]]);
            ?>
                <span id="district_id_error" class="form-error"><?php //echo $errarr['district_id_error'];              ?></span>
            <?php
            break;
            case 'taluka_id':  echo $this->Form->select($field['field_id_name_en'], $taluka, ['empty' => '--- Select Taluka ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']]]);
            ?>
                <span id="taluka_id_error" class="form-error"><?php //echo $errarr['taluka_id_error'];              ?></span>
            <?php
            break;
            case 'village_id':  echo $this->Form->select($field['field_id_name_en'], $villagelist, ['empty' => '--- Select Village ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']]]);
            ?>
                <span id="village_id_error" class="form-error"><?php //echo $errarr['village_id_error'];              ?></span>
            <?php
            break;
            case 'homevisit_flag':  echo $this->Form->select($field['field_id_name_en'], $home_visit, ['empty' => '--- Select Home Visit ---', 'class' => 'form-select', 'id' => $field['field_id_name_en'], 'default' => $identifier[$field['field_id_name_en']]]);
            ?>
                <span id="homevisit_flag_error" class="form-error"><?php //echo $errarr['homevisit_flag_error'];              ?></span>
            <?php
            break;
            default: 
                if (isset($identifierarr) && !empty($identifierarr)) {
                    if($field['field_id_name_en']=='uid_no')
                    {
                        //$textval = $this->requestAction('AppController/enc/'.$identifier[$field['field_id_name_en']]);
                        //$textval = AppController::enc($identifier[$field['field_id_name_en']]);
                        //$vara = new AppController();
                        //$textval = $vara->enc($identifier[$field['field_id_name_en']]);

                        //$textval = $this->Url->build('/App/dec/'. $identifier[$field['field_id_name_en']]);

                        /*App::import('controller','App');
                        $varobj = new AppController;
                        $textval = $varobj->enc($identifier[$field['field_id_name_en']]);*/

                        $str = $identifier[$field['field_id_name_en']];
                        $key = "";
                        $final_strv = (hex2bin(trim($str)));
                        $textval = openssl_decrypt($final_strv, 'bf-ecb', $key);

                    }
                    else
                        $textval = $identifier[$field['field_id_name_en']];
                }
                else{
                    $textval = '';
                }
                echo $this->Form->control($field['field_id_name_en'], ['id' => $field['field_id_name_en'], 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'value' => $textval ]); 
            ?>
            <div  class="arrow-up identifier_full_name_en_error"></div>
            <div id="identifier_full_name_en_error" class="form-error identifier_full_name_en_error"></div> 
            <?php
           
        }
        //echo $this->Form->select('article_id', $articlelistdata, ['empty' => '----Article----', 'class' => 'form-select', 'id' => 'article_id']);
        ?>  
        <!--<div  class="arrow-up article_id_error"></div>
        <div id="article_id_error" class="form-error article_id_error"></div>-->

    </div>
</div>


<?php   
} 
?>
<div class="box box-primary"> 
  <div class="box-body identifieraddress" ></div>
</div>

<?php
$this->Form->end(); 

?>
