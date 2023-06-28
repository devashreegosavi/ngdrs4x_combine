<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query; 

class EvalruleMappingTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_evalrule_mapping');
        $this->setPrimaryKey('mapping_id');
    }

}

?>