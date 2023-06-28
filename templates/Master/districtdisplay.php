<table class="table" border="1">
    <tr>
        <th>1</th>
        <th>2</th>
        <th>3</th>
    </tr>
  <?php   
foreach ($result as $value){ ?>
    <tr>
        <td>
           <?php echo $value['district_name_en'];?> 
        </td>
         <td>
           <?php echo $value['state_id'];?> 
        </td>
        <td>
          <?php
            $this->Html->link('Edit', array('controller' => 'Master','action' => 'districtedit' . $value['district_id']));
          ?>
        </td>
    </tr>
     <?php   
}
?>
</table>

