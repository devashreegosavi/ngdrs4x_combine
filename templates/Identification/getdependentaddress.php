<div class="col-md-6">

<div class="card">
<?php
$flag = 1;

if(isset($trnbehavioral)){
    //pr($trnbehavioral);
}
foreach ($behavioralpatterns as $key => $Patterns) {
    //pr($Patterns);
    $values_en = '';

    foreach($trnbehavioral as $behavioral){
        //pr($behavioral);
        if($Patterns['BehavioralPatterns']['field_id'] == $behavioral['field_id']){
            $values_en = $behavioral['field_value_en'];
        }
    }

    if ($flag) {
        $flag = 0;
?>
            <div class="card-header">
                <h4 class="card-title"><?php echo $Patterns['behavioral_desc_display_en']; ?></h3>
            </div>
        <?php
        }
        ?>
        <div class="card-body">
            <div class="form-group row">
                <label for="inputEmail3" class="col-md-4 col-form-label"><?php echo $Patterns['BehavioralPatterns']['pattern_desc_en']; ?></label>
                    <div class="col-md-4">
                        <?php
                        echo $this->Form->control('id', ['type' => 'hidden','name' => 'data[property_details][pattern_id][]', 'value' => $Patterns['BehavioralPatterns']['field_id'], 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']); 
                        
                        echo $this->Form->control('value', ['name' => 'data[property_details][pattern_value_en][]','id' => 'field_en' .$Patterns['BehavioralPatterns']['field_id'], 'value' => $values_en, 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']); 
                        ?>
                    </div> 
            </div>
        </div>
<?php
}
?>
</div>
</div>