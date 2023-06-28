<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ConstructionTypeTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_construction_type');
        $this->setPrimaryKey('construction_type_id');
    }

}

?>