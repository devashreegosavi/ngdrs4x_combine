<!-- in /templates/Users/login.php -->
<noscript>  <meta http-equiv="refresh" content="1; URL=cterror.html" /></noscript>
<script language="JavaScript" type="text/javascript">
    $(document).ready(function () {

        $('#re_user_pass').blur(function () {
            verifypassword();
        });
    });
    function verifypassword() {
        if ($('#re_user_pass').val() !== '') {
            if ($('#re_user_pass').val() !== $('#user_pass').val()) {
                alert('Password did not match');
                $("#re_user_pass").val('');
                $('#re_user_pass').focus();
                return false;
            }
        }
    }
    
    function checkusername() {
        var username = $('#user_name').val();
        if (username != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Url->webroot; ?>checkusercitizen",
                data: {'username': username, '_csrfToken': $("input[name=_csrfToken]").val()},
                success: function (data) {
                    //alert(data);
                    if (data == 1)
                    {
                        $("#user_name").val('');
                        $('#user_name').focus();
                        alert('User name already exist.');
                        return false;
                    }
                }
            });
        }
    }

    function checkemail() {
        var email = $('#email_id').val();
        if (email != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Url->webroot; ?>checkemailcitizen",
                data: {'email': email, '_csrfToken': $("input[name=_csrfToken]").val()},
                success: function (data) {
                    if (data == 1)
                    {
                        $("#email_id").val('');
                        $('#email_id').focus();
                        alert('Email ID already exist.');
                        return false;
                    }
                }
            });
        }
    }

    function checkmobileno() {
        var mobile = $('#mobile_no').val();
        //alert(mobile);
        if (mobile != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Url->webroot; ?>checkmobilenocitizen",
                data: {'mobile': mobile, '_csrfToken': $("input[name=_csrfToken]").val()},
                success: function (data) {
                   
                    if (data == 1)
                    {
                        $("#mobile_no").val('');
                        $('#mobile_no').focus();
                        alert('Mobile no. already exist.');
                        return false;
                    }
                }
            });
        }
    }

	function after_validation_check_citizenRegistration() {
		
		var firstPa = $("#user_pass").val();
		var firstPasha512 = CryptoJS.SHA512(firstPa);
		document.getElementById("user_pass").value = firstPasha512;
		
		var secondPa = $("#re_user_pass").val();
		var secondPasha512 = CryptoJS.SHA512(secondPa);
		document.getElementById("re_user_pass").value = secondPasha512;
	
		var user = $("#user_name").val();
		var encrypted = btoa(user);
		document.getElementById("user_name").value = encrypted;
        //return false;
    }

</script>


<?= $this->Flash->render() ?>
<?= $this->Form->create(null, ['id'=>'citizenRegistration','autocomplete' => 'off']) ?>
<div class="container">
    <div class="card mt-5 mb-5" style="width: 80%; margin:auto;">
        <div class="card-header" style="text-align:center;">
            Citizen Registration
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3"><label><?php echo __('Select Type'); ?></label></div>
                <div class="col-sm-3"><?= $this->Form->select('reg_type', $registrationTypeListData, ['label' => false, 'id' => 'reg_type', 'class' => 'form-select', 'empty' => '--Select--']) ?>
				<div  class="arrow-up reg_type_error"></div>
                        <div id="reg_type_error" class="form-error reg_type_error"></div>
				</div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3"></div>
            </div>
            <div style="height:10px;"></div>
            <div class="row">
                <div class="col-sm-3"><label><?php echo __('Contact Person'); ?></label></div>
                <div class="col-sm-3"><?= $this->Form->control('contact_fname', ['label' => false, 'type' => 'text', 'id' => 'contact_fname', 'class' => 'form-control']) ?>
				<div  class="arrow-up contact_fname_error"></div>
                        <div id="contact_fname_error" class="form-error contact_fname_error"></div>
				</div>
                <div class="col-sm-3"><?= $this->Form->control('contact_mname', ['label' => false, 'type' => 'text', 'id' => 'contact_mname', 'class' => 'form-control']) ?>
				<div  class="arrow-up contact_mname_error"></div>
                        <div id="contact_mname_error" class="form-error contact_mname_error"></div>
				</div>
                <div class="col-sm-3"><?= $this->Form->control('contact_lname', ['label' => false, 'type' => 'text', 'id' => 'contact_lname', 'class' => 'form-control']) ?>
				<div  class="arrow-up contact_lname_error"></div>
                        <div id="contact_lname_error" class="form-error contact_lname_error"></div>
				</div>
            </div>
            <div style="height:10px;"></div>
            <div class="row">
                <div class="col-sm-3"><label><?php echo __('Email ID'); ?></label></div>
                <div class="col-sm-3"><?= $this->Form->control('email_id', ['label' => false, 'type' => 'email', 'id' => 'email_id', 'class' => 'form-control', 'onblur' => 'checkemail()']) ?>
				<div  class="arrow-up email_id_error"></div>
                        <div id="email_id_error" class="form-error email_id_error"></div>
				</div>
                <div class="col-sm-3"><label><?php echo __('Mobile No.'); ?></label></div>
                <div class="col-sm-3"><?= $this->Form->control('mobile_no', ['label' => false, 'type' => 'text', 'id' => 'mobile_no', 'class' => 'form-control', 'onblur' => 'checkmobileno()']) ?>
				<div  class="arrow-up mobile_no_error"></div>
                        <div id="mobile_no_error" class="form-error mobile_no_error"></div>
				</div>
            </div>
            <div style="height:10px;"></div>
            <div class="row">
                <div class="col-sm-3"><label><?php echo __('User Name'); ?></label></div>
                <div class="col-sm-3"><?= $this->Form->control('user_name', ['label' => false, 'type' => 'text', 'id' => 'user_name', 'class' => 'form-control', 'onblur' => 'checkusername()']) ?>
				<div  class="arrow-up user_name_error"></div>
                        <div id="user_name_error" class="form-error user_name_error"></div>
				</div>

            </div>
            <div style="height:10px;"></div>
            <div class="row">
                <div class="col-sm-3"><label><?php echo __('Password'); ?></label></div>
                <div class="col-sm-3"><?= $this->Form->control('user_pass', ['label' => false, 'type' => 'password', 'id' => 'user_pass', 'class' => 'form-control']) ?>
				<div  class="arrow-up user_pass_error"></div>
                        <div id="user_pass_error" class="form-error user_pass_error"></div>
				</div>
                <div class="col-sm-3"><label><?php echo __('Confirm Password'); ?></label></div>
                <div class="col-sm-3"><?= $this->Form->control('re_user_pass', ['label' => false, 'type' => 'password', 'id' => 're_user_pass', 'class' => 'form-control']) ?>
				<div  class="arrow-up re_user_pass_error"></div>
                        <div id="re_user_pass_error" class="form-error re_user_pass_error"></div>
				</div>
            </div>
            <div style="height:10px;"></div>
            <div class="row">
                <div class="col-sm-3"><label><?php echo __('Select Hint Question'); ?></label></div>
                <div class="col-sm-3"><?= $this->Form->select('hint_question', $hintQuestionListData, ['label' => false, 'id' => 'hint_question', 'class' => 'form-select', 'empty' => '--Select--']) ?>
				<div  class="arrow-up hint_question_error"></div>
                        <div id="hint_question_error" class="form-error hint_question_error"></div>
				</div>
                <div class="col-sm-3"><label><?php echo __('Hint Question Ans.'); ?></label></div>
                <div class="col-sm-3"><?= $this->Form->control('hint_answer', ['label' => false, 'type' => 'text', 'id' => 'hint_answer', 'class' => 'form-control']) ?>
				<div  class="arrow-up hint_answer_error"></div>
                        <div id="hint_answer_error" class="form-error hint_answer_error"></div>
				</div>
            </div>
        </div>
        <div class="card-footer" style="text-align:center;">
            <?= $this->Form->submit(__('Register'), ['class' => 'btn btn-success btn-sm']); ?>
        </div>

    </div>

    <?= $this->Form->end() ?>
	
</div>

