 <fieldset class="rounded-3 p-3">
        <legend class="float-none w-auto px-3" > Dependency Attributes </legend>
        
 </fieldset>
<?php
foreach ($json2array['ValuationRule'] as $rule) {
    ?>
    <fieldset class="rounded-3 p-3">
        <legend class="float-none w-auto px-3" ><?= $rule['evalrule_desc_' . $lang] ?></legend>
        <?php
        foreach ($json2array['ValuationRuleFields'] as $Fields) {
            if ($Fields['ItemLink']['evalrule_id'] == $rule['evalrule_id']) {

                if ($Fields['is_input_hidden'] == 'Y') {
                    $fieldkey = 1;
                } else if ($Fields['is_string'] == 'Y') {
                    $fieldkey = 2;
                } else if ($Fields['is_list_field_flag'] == 'Y') {
                    $fieldkey = 3;
                } else if ($Fields['area_field_flag'] == 'N') {
                    $fieldkey = 4;
                } else {
                    $fieldkey = 5;
                }
                ?>

                <div class="row">

                    <?php
                    switch ($fieldkey) {
                        case 1:
                            ?>
                            <div class="col-2">
                                <?php
                                echo $this->Form->control($Fields['usage_param_code'] . '_' . $rule['evalrule_id'], ['type' => 'hidden', 'id' => $Fields['usage_param_code'] . '_' . $rule['evalrule_id'], 'class' => 'form-control', 'label' => false]);
                                ?>
                            </div>
                            <?php
                            break;
                        case 2:
                            ?>
                            <div class="col-3">
                                <label class="valuation-label"><?= $Fields['usage_param_desc_' . $lang] ?></label>
                            </div>
                            <div class="col-6">
                                <?php
                                echo $this->Form->control($Fields['usage_param_code'] . '_' . $rule['evalrule_id'], ['type' => 'text', 'id' => $Fields['usage_param_code'] . '_' . $rule['evalrule_id'], 'class' => 'form-control', 'label' => false]);
                                ?>
                            </div>
                            <?php
                            break;
                        case 3:
                            ?>
                            <div class="col-3">
                                <label class="valuation-label"> <?= $Fields['usage_param_desc_' . $lang] ?></label>
                            </div>
                            <div class="col-2">
                                <?php
                                echo $this->Form->control($Fields['usage_param_code'] . '_' . $rule['evalrule_id'], ['type' => 'text', 'id' => $Fields['usage_param_code'] . '_' . $rule['evalrule_id'], 'class' => 'form-control', 'label' => false]);
                                ?>
                            </div>
                            <?php
                            break;
                        case 3:
                            ?>
                            <div class="col-3">
                                <label class="valuation-label"><?= $Fields['usage_param_desc_' . $lang] ?></label>
                            </div>
                            <div class="col-2">
                                <?php
                                echo $this->Form->select($Fields['usage_param_code'] . '_' . $rule['evalrule_id'], array(), ['id' => $Fields['usage_param_code'] . '_' . $rule['evalrule_id'], 'class' => 'form-select', 'label' => false]);
                                ?>
                            </div>
                            <?php
                            break;
                        case 4:
                            ?>
                            <div class="col-3">
                                <label class="valuation-label"><?= $Fields['usage_param_desc_' . $lang] ?></label>
                            </div>
                            <div class="col-2">
                                <?php
                                echo $this->Form->control($Fields['usage_param_code'] . '_' . $rule['evalrule_id'], ['type' => 'text', 'id' => $Fields['usage_param_code'] . '_' . $rule['evalrule_id'], 'class' => 'form-control', 'label' => false]);
                                ?>
                            </div>
                            <?php
                            break;
                        default:
                            ?>
                            <div class="col-3">
                                <label class="valuation-label"><?= $Fields['usage_param_desc_' . $lang] ?></label>
                            </div>
                            <div class="col-2">
                                <?php
                                echo $this->Form->control($Fields['usage_param_code'] . '_' . $rule['evalrule_id'], ['type' => 'text', 'id' => $Fields['usage_param_code'] . '_' . $rule['evalrule_id'], 'class' => 'form-control', 'label' => false]);
                                ?>
                            </div>
                            <div class="col-2">
                                <?php
                                $params['field_name'] = $Fields['usage_param_code'] . 'unit_' . $rule['evalrule_id'];
                                $params['evalrule_id'] = $rule['evalrule_id'];
                                $params['single_unit_flag'] = $Fields['single_unit_flag'];
                                $params['districtwise_unit_change_flag'] = $Fields['districtwise_unit_change_flag'];
                                $params['district_id'] = $json2array['Form_Data']['district_id'];
                                $params['unit_cat_id'] = $Fields['unit_cat_id'];
                                $params['usage_param_id'] = $Fields['usage_param_id'];

                                echo $this->cell('Valuation::UnitList', [$params]);
                                ?>
                            </div>
                            <div class="col-2">
                                <?php
                                if ($Fields['area_type_flag'] == 'Y') {
                                    echo $this->cell('Valuation::AreaTypeList', [$Fields['usage_param_code'] . 'areatype_' . $rule['evalrule_id']]);
                                }
                                ?>
                            </div>
                    <?php } ?>

                </div>

                <?php
            }
        }
        ?>
    </fieldset>
<?php } ?>