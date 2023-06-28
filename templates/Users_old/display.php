<table class="table" border="1">
    <tr>
        <th>User Full Name</th>
        <th>User Name</th>
    </tr>
  <?php   
foreach ($result as $value){ ?>
    <tr>
        <td>
           <?php echo $value['full_name'];?> 
        </td>
         <td>
           <?php echo $value['username'];?> 
        </td>
    </tr>
     <?php   
}
?>
</table>

