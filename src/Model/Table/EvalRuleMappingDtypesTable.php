<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;

class EvalRuleMappingDtypesTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_evalrule_mapping_dtypes');
        $this->setPrimaryKey('mapping_dtypes_id');
    }

}

?>