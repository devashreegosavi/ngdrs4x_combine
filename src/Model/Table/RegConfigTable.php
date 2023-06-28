<?php

namespace App\Model\Table;
 
use Cake\ORM\Table; 

class RegConfigTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_conf_reg_bool_info');
        $this->setPrimaryKey('reginfo_id');
    }

}

?>