<table class="table table-bordered bg-white">
    <?php
    foreach ($prop_attributes as $key => $attribute) {
        foreach ($AttributeDetails as $attribute_details) {
            if ($attribute['attribute_id'] == $attribute_details['attribute_id']) {
                ?>

                <tr>
                    <th width="10%" class="bg-info"><?php echo $attribute_details['attribute_name_' . $lang] ?> </th>
                    <td width="10%"><?php echo $attribute['attribute_value'] ?> </td>

                    <?php if(!empty($attribute_details['hissa1_en'])){?>
                    <th width="10%" class="bg-info"><?php echo $attribute_details['hissa1_' . $lang] ?> </th>
                    <?php }else{ ?>
                        <th width="10%" class="bg-white"><?php echo $attribute_details['hissa1_' . $lang] ?> </th>  
                   <?php  } ?>
                    <td width="10%"><?php echo $attribute['attribute_value1'] ?> </td>

                    <?php if(!empty($attribute_details['hissa2_en'])){?>
                    <th width="10%" class="bg-info"><?php echo $attribute_details['hissa2_' . $lang] ?> </th>
                   <?php }else{ ?>
                       <th width="10%" class="bg-white"><?php echo $attribute_details['hissa2_' . $lang] ?> </th>
                       <?php  } ?>
                    <td width="10%"><?php echo $attribute['attribute_value2'] ?> </td>
                    
                    <td width="10%"><button type="button" class="btn btn-danger" onclick="return attribute_remove('<?php echo $key; ?>', 'S');">Remove</button>
                    </td>
                </tr>


                <?php
            }
        }
    }
    ?>
</table>

