
<div class="container">
    <div class="col-md-12">
<h1>Form Controls</h1>


<?php echo $this->Form->create(); ?>


<?php echo $this->Form->control('published', ['type' => 'checkbox']); ?>
<?php echo   $this->Form->textarea('notes'); ?>
<?php echo $this->Form->control('published', ['type' => 'text','class'=>'form-control']); ?>
<?php 
$sizes = ['s' => 'Small', 'm' => 'Medium', 'l' => 'Large'];
echo $this->Form->select('size', $options, ['default' => 'm','class'=>'form-control']);
?>
<?php 
echo $this->Form->password('password',['class'=>'form-control']);
?>

<?php 
echo $this->Form->hidden('id',['class'=>'form-control']);
?>

<?php 
$sizes = ['s' => 'Small', 'm' => 'Medium', 'l' => 'Large'];
echo $this->Form->radio('size', $sizes, ['default' => 'm']);
?>
<?php 
echo $this->Form->file('file');
?>
<?php echo $this->Form->end(); ?>

</div>
</div>