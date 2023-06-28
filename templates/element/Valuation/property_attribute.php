<div class="card-footer"> 
    <label><?php echo __('lblpropertyattribute'); ?></label> 
</div>

<div class="card-footer">   
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">

                <div class="input-group mb-3">
                    <?php
                    echo $this->Form->select('attribute_id', $PropertyAttributes, ['empty' => '--select--', 'class' => 'form-select btn-lg', 'id' => 'attribute_id', 'div' => 'false', 'label' => 'false']);
                    ?>
                    <span class="input-group-text btn btn-primary" id="btn_view_survey_number" data-bs-toggle="modal" data-bs-target="#surveyModal" style="display:none"><span class="fa fa-eye"></span> View</span>
                </div>

                <div  class="arrow-up attribute_id_error"></div>
                <div id="attribute_id_error" class="form-error attribute_id_error"></div>
            </div>
        </div>

        <div class="col-sm-9">
            <div class="form-group">

                <div class="input-group mb-3">

                    <?php echo $this->Form->control('attribute_value', ['type' => 'text', 'id' => 'attribute_value', 'class' => 'form-control', 'label' => false]); ?>
                    <?php echo $this->Form->control('attribute_value1', ['type' => 'text', 'id' => 'attribute_value1', 'class' => 'form-control', 'label' => false, 'style' => 'display:none']); ?>
                    <?php echo $this->Form->control('attribute_value2', ['type' => 'text', 'id' => 'attribute_value2', 'class' => 'form-control', 'label' => false, 'style' => 'display:none']); ?>

                    <button class="input-group-text btn btn-primary" id="add_attribute" type="button"><span class="fa fa-plus"></span><?php echo __('lblbtnAdd'); ?></button>

                </div>
            </div>
        </div>

    </div>  
    <div class="row" id="property_attribute_div">

    </div>
</div> 