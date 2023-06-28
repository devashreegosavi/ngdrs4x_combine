<?php $this->start('css') ?>
<style>
    .gradient-custom-2 {
        /* fallback for old browsers */
        background: #fccb90;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
    }

    @media (min-width: 768px) {
        /* .gradient-form {
                height: 100vh !important;
        } */
    }

    @media (min-width: 769px) {
        .gradient-custom-2 {
            border-top-right-radius: .3rem;
            border-bottom-right-radius: .3rem;
        }
    }

    .btn-block {
        display: block;
        width: 100%;
    }

    .ngrds-logo {

        background: -webkit-linear-gradient(0deg, #28183f, #368384);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;

    }
</style>

<?php $this->end() ?>



<?php 
//pr($this->request->getParam);
///echo $this->invokeAction('Users/menu'); 
//echo 'HI';
//exit;
?>
<!-- Login page start -->
<section class="h-100 gradient-form " style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black animate__animated animate__bounceInRight">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-4 mx-md-4">
                                <div class="text-center">
                                        <!-- <i class="bi bi-people-fill"></i> -->
                                    <h1 class="ngrds-logo">NGDRS</h1>
                                    <!-- <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/lotus.webp" style="width: 185px;" alt="logo"> -->
                                    <h4 class="mt-1 mb-4 pb-1">Winds of Change: IT Solution</h4>
                                </div>
                                <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'organizationLogin'], 'id' => 'login']); ?>
                                <div class="form-floating mb-4">
                                    <?= $this->Form->control('username', ['label' => false, 'type' => 'text', 'class' => 'form-control', 'id' => 'username', 'templates' => ['inputContainer' => '{{content}}']]); ?>
                                    <label class="form-label" for="username">Username</label>
                                    <!--<div  class="arrow-up username_error"></div>-->
                                    <div id="username_error" class="form-error username_error"></div>
                                </div>

                                <div class="form-floating mb-4">
                                    <?= $this->Form->control('password', ['label' => false, 'type' => 'password', 'class' => 'form-control', 'id' => 'password', 'templates' => ['inputContainer' => '{{content}}'], 'value' => '']); ?>
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="text-center pt-1 mb-3 pb-1">
                                    <?php echo $this->Form->submit('Log in', ['class' => 'btn text-white py-3 btn-lg btn-block fa-lg gradient-custom-2 mb-3']) ?>
                                    <?= $this->html->link('Forgot password?', '#', ['class' => 'text-muted']); ?>
                                </div>
                                <div class="d-flex align-items-center justify-content-center ">
                                    <p class="mb-0 me-2">Don't have an account?</p> 
                                    <?= $this->html->link('Create new', ['controller' => 'Users', 'action' => 'citizenLogin'], ['class' => 'btn btn-outline-danger']); ?>
                                </div>
                                <?= $this->Form->end(); ?>

                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                            <div class="text-white text-center px-3 py-4 p-md-3 mx-md-4">
                                <h1><i class="fa fa-university fa-2x" aria-hidden="true"></i></h1>
                                <h4 class="mb-4 text-uppercase">Organization Login</h4>
                                <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Login page end -->


<script>
    $(document).ready(function () {
        $('#username').val('s10');
        $('#password').val('Com*mon#86');
        $('#btn_login').click();
    });
</script>