<?php
echo $this->element("Helper/jqueryhelper");
?>
<script type="text/javascript">
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    
    $(document).ready(function () {
        
         $(".back-to-top_popup1").draggable();
         $('#datalist').dataTable({
        "iDisplayLength": 5,
                "aLengthMenu": [[5, 10, 15, 20, - 1], [5, 10, 15, 20, "All"]]
        });

        $('#paymentmode_id').change(function (e) {
            var mode = $('#paymentmode_id').val();
            //var reff_no = $('#reff_no').val();
            if (mode === '')
            {
                alert("Please Select Payment Mode");
                e.preventDefault();
                retun;
            } else {
                //alert(mode);
                $.post('<?php
                    echo $this->Url->build([
                        'controller' => 'Payment',
                        'action' => 'getpaymentdetails',])
                    ?>', {'_csrfToken': $("input[name=_csrfToken]").val(), mode : mode}, function (data)
                    {
                        //alert(data);
                        $("#paydetails").html(data);
                    });

            }
        });

    });
</script>
<?= $this->Form->create(NULL, ['id' => '']) ?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>Payment Entry</b></h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-sm-4">&nbsp;</div>
                <div class="col-sm-4">&nbsp;</div>
                <div class="col-sm-4">
                    <p style="color: red;"><b><?php echo __('lblnote'); ?>1:&nbsp;</b><?php echo "Registration fee upto Rs 50,000 may be made in cash in respective Sub Registrar Office.  Non judicial physical stamp paper may be presented at respective Sub Registrar Office. No combination of online and offline mode, will be accepted."; ?>
                  
                    
                </div>      
            </div>
            <hr>
            <?php
            //202300000004
            $Selectedtoken = $this->request->getSession()->read('Selectedtoken');
            $Selectedtoken='202300000004';
            if($Selectedtoken!=''){
            ?>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbltokenno'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->control('token_no', ['id' => 'token_no','value'=> $Selectedtoken, 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'readonly' => 'readonly']) ?>
                </div>
                <div class="col-sm-4">
                    &nbsp;
                </div>
            </div>
            <?php
            }
            ?>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblselectpaymode'); ?></label>
                <div class="col-sm-4">
                    <?= $this->Form->select('paymentmode_id', $payment_mode, ['empty' => '--Select--', 'class' => 'form-select', 'id' => 'paymentmode_id']); ?>
                    
                </div>
                <div class="col-sm-4">
                    &nbsp;
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div id="paydetails"></div>
            </div>
        </div>


    </form>
</div>


<div class="back-to-top_popup1 ui-draggable ui-draggable-handle" style="width: 511px; inset: 239.578px auto auto 1007.58px;"> 

    <table class="table">
        <thead>
            <tr>
                <th colspan="3" style="color:red;background-color:white">
                    <span>How To Pay </span> 
                </th>

            </tr>
        </thead>
        <thead>
            <tr>
                <th  style="color:red;background-color:#E2FAF9">
                    <span>Account Heads</span> 
                </th>
                <th style="color:red;background-color:#E2FAF9">
                    <span>Payment Service </span> 
                </th>

                <th style="color:red;background-color:#E2FAF9">
                    <span>Link</span> 
                </th>

            </tr>
        </thead>
    </table>
</div>
