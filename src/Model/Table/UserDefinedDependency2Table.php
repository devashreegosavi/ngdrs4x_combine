<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class UserDefinedDependency2Table extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_user_def_depe2');
        $this->setPrimaryKey('user_defined_dependency2_id');
    }

}

?>