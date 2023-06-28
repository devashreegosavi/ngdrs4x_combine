<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class DepreciationTypeTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_depreciation_type');
        $this->setPrimaryKey('deprication_type_id');
    }

}

?>