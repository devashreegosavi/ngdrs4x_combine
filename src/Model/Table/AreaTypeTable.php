<?php

namespace App\Model\Table;
 
use Cake\ORM\Table; 

class AreaTypeTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_rate_built_area_type');
        $this->setPrimaryKey('rate_built_area_type_id');
    }

}

?>