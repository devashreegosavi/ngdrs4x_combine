<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class UserDefinedDependency1Table extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_user_def_depe1');
        $this->setPrimaryKey('user_defined_dependency1_id');
    }

}

?>