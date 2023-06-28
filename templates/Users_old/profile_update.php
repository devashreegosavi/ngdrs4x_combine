
<div class="signup-form">
    <?= $this->Form->create($Users, ['id' => 'propertyValuation']) ?>
    <h2>Profile </h2>
    <!--<p class="hint-text">Create your account. It's free and only takes a minute.</p>-->
    <div class="form-group">
        <div class="row">
            <div class="col">
                <?php
                echo $this->Form->control('full_name', ['type' => 'text', 'class' => 'form-control', 'id' => 'full_name']);
                ?>
                <span id="first_name_error" class="form-error"></span>
            </div>
            <div class="col">
                <?php
                echo $this->Form->control('mobile_no', ['type' => 'text', 'class' => 'form-control', 'id' => 'mobile_no']);
                ?>
            </div>
        </div>        	
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col">
                <?php
                echo $this->Form->control('email_id', ['type' => 'text', 'class' => 'form-control', 'id' => 'email_id']);
                ?> 
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>Authentication Type</label>
                <?php
                $sizes = ['1' => 'Password', '2' => 'Password+OTP', '3' => 'Password+Biometric'];
                echo $this->Form->select('authetication_type', $sizes, ['id' => 'authetication_type', 'class' => 'form-control', 'empty' => 'select']);
                ?> 
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success btn-lg btn-block">Update Now</button>
    </div>
    <?= $this->Form->end() ?>
</div>



<table class="table" border="1">
    <tr>
        <th>User Full Name</th>
        <th>User Name</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($result as $value) { ?>
        <tr>
            <td>
                <?php echo $value['full_name']; ?> 
            </td>
            <td>
                <?php echo $value['username']; ?> 
            </td>
            <td>
                <a href="<?php echo $this->Url->build('/Users/profile_update/' . $value['user_id']); ?>/E" class="btn btn-info">Edit</a>  
                <a href="<?php echo $this->Url->build('/Users/profile_update/' . $value['user_id']); ?>/D" class="btn btn-danger">Delete</a>  

            </td>
        </tr>
        <?php
    }
    ?>
</table>

