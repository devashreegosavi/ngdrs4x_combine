<?php if (isset($paymentfields) && !empty($paymentfields)) {
?>

    <?= $this->Form->create(NULL, ['id' => 'payment']) ?>
    <?php
        $upadteflag = 0;
        foreach ($paymentfields as $field) {
            //pr($field);
            if (isset($payment) && !empty($payment)) {
                $upadteflag = 1;
                //pr($payment);
                $payment1[$field['field_name']] = $payment[0][$field['field_name']];
                $payment1['payment_mode_id'] = $payment[0]['payment_mode_id'];
            }else{
                $payment1[$field['field_name']] = '';
                $payment1['payment_mode_id'] = $field['payment_mode_id'];
            }
            $lblbtnsave='Save';
        
    ?>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo $field['field_name_desc_en']; ?></label>
            <div class="col-sm-4">
            <?php
                switch ($field['field_name']) {
                    case 'account_head_code': 
                        echo $this->Form->select($field['field_name'], $accounthead, ['empty' => '--- Select ---', 'class' => 'form-select', 'id' => $field['field_name']. '_' . $field['payment_mode_id'], 'default' => $payment1[$field['field_name']]]);
                        break;
                    case 'bank_id': 
                        echo $this->Form->select($field['field_name'], $bank_master, ['empty' => '--- Select ---', 'class' => 'form-select', 'id' => $field['field_name']. '_' . $field['payment_mode_id'], 'default' => $payment1[$field['field_name']]]);
                        break;
                    case 'branch_id': 
                        echo $this->Form->select($field['field_name'], $branch_master, ['empty' => '--- Select ---', 'class' => 'form-select', 'id' => $field['field_name']. '_' . $field['payment_mode_id'], 'default' => $payment1[$field['field_name']]]);
                        break;
                    case 'cos_id': 
                        echo $this->Form->select($field['field_name'], $office, ['empty' => '--- Select ---', 'class' => 'form-select', 'id' => $field['field_name']. '_' . $field['payment_mode_id'], 'default' => $payment1[$field['field_name']]]);
                        break;
                    case 'bank_trn_id': 
                        echo $this->Form->select($field['field_name'], $bank_trn_id, ['empty' => '--- Select ---', 'class' => 'form-select', 'id' => $field['field_name']. '_' . $field['payment_mode_id'], 'default' => $payment1[$field['field_name']]]);
                        break;
                    default:
                        echo $this->Form->control($field['field_name'], ['id' => $field['field_name']. '_' . $field['payment_mode_id'], 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'value' => $payment1[$field['field_name']]]); 
                }
            ?>
            </div>
        </div>
    <?php
        }
    ?>
<?php
}
?>