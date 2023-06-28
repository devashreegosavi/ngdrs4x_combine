<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class PropertyFieldsTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_trn_property_dependent_fields');
        $this->setPrimaryKey('id');
    }

}
