<?php
echo $this->Html->script("jquery-3.6.1");

echo $this->Html->css('bootstrap.min');

echo $this->Element('Validationscript/dynamicscript_new');          // Validation Script
echo $this->Element('Validationscript/server_message_display');
?>
<div class="container">
    <div class="col-md-12">
        <h1>All Form Controls</h1>


        <?php echo $this->Form->create(); ?>

        <?php echo $this->Form->control('notes', ['type' => 'textarea', 'id' => 'notes']); ?>
        <span id="notes_error"><?php //echo $errarr['contact_mname_error'];                  ?></span>
        <?php echo $this->Form->control('Checkbox', ['type' => 'checkbox', 'id' => 'Checkbox']); ?>
        <span id="Checkbox_error"><?php //echo $errarr['contact_mname_error'];                  ?></span>

        <?php //echo $this->Form->textarea('notes');  ?>
        <?php echo $this->Form->control('published', ['type' => 'text', 'id' => 'published']); ?>
        <span id="published_error"><?php //echo $errarr['contact_mname_error'];                  ?></span>
        <?php
        //  $sizes = ['s' => 'Small', 'm' => 'Medium', 'l' => 'Large'];
        echo $this->Form->select('size', $errorlistdata, ['id' => 'size',]);
        ?>
        <span id="size_error"><?php //echo $errarr['contact_mname_error'];                 ?></span>
        <?php
        //echo $this->Form->password('password');
        ?>

        <?php
        //    echo $this->Form->hidden('id');
        ?>

        <?php
        //$sizes = ['s' => 'Small', 'm' => 'Medium', 'l' => 'Large'];
        echo $this->Form->radio('size', $sizesradio, ['default' => 'm']);
        ?>
        <?php
        echo $this->Form->file('file');
        ?>
        <?php echo $this->Form->end(); ?>

    </div>
</div>