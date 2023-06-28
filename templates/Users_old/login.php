<div class="login-form">    
    <?= $this->Form->create(NULL, ['id' => 'login']) ?>
    <div class="avatar">
        <i class="fa fa-user"></i>

    </div>
    <h4 class="modal-title">Login to Your Account</h4>
    <div class="form-group">
        <!--<input type="text" class="form-control" placeholder="Username" required="required">-->
        <?= $this->Form->control('username', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Username']) ?>
        <div  class="arrow-up username_error"></div>
        <div id="username_error" class="form-error username_error"></div>
    </div>
    <div class="form-group">
        <?= $this->Form->control('password', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Password']) ?>
        <div  class="arrow-up password_error"></div>
        <div id="password_error" class="form-error password_error"></div>
     <!--<input type="password" class="form-control" placeholder="Password" required="required">-->
    </div>
    <div class="form-group small clearfix">
        <!--<label class="form-check-label"><input type="checkbox"> Remember me</label>-->
        <a href="#" class="forgot-link">Forgot Password?</a>
    </div> 
    <!--<input type="submit" class="btn btn-primary btn-block btn-lg" value="Login">-->  
    <?= $this->Form->submit(__('Login'), ['class' => 'btn btn-primary btn-block btn-lg', 'id' => 'btn_login']); ?>
</form>			
<div class="text-center small">Don't have an account? <a href="register">Sign up</a></div>
<?= $this->Form->end() ?>
</div>

<script>
    $(document).ready(function () {
        $('#username').val('s10');
        $('#password').val('Com*mon#86');
        $('#btn_login').click();
    });
</script>