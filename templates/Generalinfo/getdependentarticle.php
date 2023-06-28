<?= $this->Form->create(NULL, ['id' => 'getdependentarticle']) ?>
<?php
$lang = $this->request->getSession()->read('Config.language');
if(!empty($result)){
?>
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><b><?php echo __('lblarticaldepfields');?></b></h3>
        </div>
        <?php
        foreach ($result as $result1) {
            //pr($result1);
            //pr($items_list);
        ?>
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo $result1['ArticleFeeItems']['fee_item_desc_'.$lang]; ?></label>
                    <?php if ($result1['ArticleFeeItems']['list_flag'] == 'Y') {
                    ?>
                    <div class="col-sm-4">
                        <?php
                        echo $this->Form->select('fieldval_' . $result1['ConfArticleFeeruleItems']['fee_param_code'], ['empty' => '---select----','options' => (($result1['ConfArticleFeeruleItems']['fee_param_code']) ? $result1['ConfArticleFeeruleItems']['fee_param_code'] : NULL), 'class' => 'form-select', 'value' => $result1['ArticleTrnFields']['articledepfield_value'], 'id' => 'fieldval_' . $result1['ConfArticleFeeruleItems']['fee_param_code']]);
                        ?>  
                       
                        <div class="arrow-up fieldval_<?php echo $result1['Distinct ConfArticleFeeruleItems']['fee_param_code']; ?>_error"></div>
                       <div id="fieldval_<?php echo $result1['Distinct ConfArticleFeeruleItems']['fee_param_code']; ?>_error" class="form-error fieldval_<?php echo $result1['Distinct ConfArticleFeeruleItems']['fee_param_code']; ?>_error"></div>
                    </div>
                    <?php 
                    } else if ($result1['ArticleFeeItems']['is_date'] == 'Y') { ?>
                    ?>
                    <div class="col-sm-4">
                        <?php
                        echo $this->Form->control('fieldval_' . $result1['Distinct ConfArticleFeeruleItems']['fee_param_code'], ['id' => 'fieldval_' . $result1['Distinct ConfArticleFeeruleItems']['fee_param_code'], 'class' => 'form-control datepicker', 'label' => false, 'autocomplete' => 'off', 'value' => $result1['ArticleTrnFields']['articledepfield_value']]);
                        ?>
                        <div class="arrow-up fieldval_<?php echo $result1['Distinct ConfArticleFeeruleItems']['fee_param_code']; ?>_error"></div>
                        <div id="fieldval_<?php echo $result1['Distinct ConfArticleFeeruleItems']['fee_param_code']; ?>_error" class="form-error fieldval_<?php echo $result1['Distinct ConfArticleFeeruleItems']['fee_param_code']; ?>_error"></div>
                    </div>
                    <?php 
                    } else {     
                    ?>
                    <div class="col-sm-4">
                        <?php
                        echo $this->Form->control('fieldval_' . $result1['Distinct ConfArticleFeeruleItems']['fee_param_code'], ['id' => 'fieldval_' . $result1['Distinct ConfArticleFeeruleItems']['fee_param_code'], 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'value' => $result1['ArticleTrnFields']['articledepfield_value']]);
                        ?>
                        <div class="arrow-up fieldval_<?php echo $result1['Distinct ConfArticleFeeruleItems']['fee_param_code']; ?>_error"></div>
                        <div id="fieldval_<?php echo $result1['Distinct ConfArticleFeeruleItems']['fee_param_code']; ?>_error" class="form-error fieldval_<?php echo $result1['Distinct ConfArticleFeeruleItems']['fee_param_code']; ?>_error"></div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<?php
}
?>

