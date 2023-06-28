<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// pr($result);
?>

<div class="row">
    <div class="col-md-12">
        <div class="btn-arrow">
            <?php
            $sr_no = 'A';
            $lang = 'en';
            foreach ($result as $menu) {
                //  pr($menu);
                //  pr($this->request->getAttribute('params'));exit;

                $res = $this->request->getAttribute('params'); //for tab active of current actions from page running
                if ($menu['delete_flag'] == 'N') {

                    if ($res['action'] == $menu['action']) {
                        ?> 
                        <a href="<?php echo $menu['action']; ?>" class="btn bg-maroon btn-arrow-right"><?php echo $menu['function_desc_' . $lang]; ?></a>            
                    <?php } else { ?>              
                        <a href="<?php echo $menu['action']; ?>" class="btn btn-success btn-arrow-right"><?php echo $menu['function_desc_' . $lang]; ?></a>
                        <?php
                    }
                }
            }
            ?> 
        </div>
    </div>
</div>
<div  class="rowht">&nbsp;</div>