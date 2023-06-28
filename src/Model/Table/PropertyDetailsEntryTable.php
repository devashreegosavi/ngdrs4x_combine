<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class PropertyDetailsEntryTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_trn_property_details_entry');
        $this->setPrimaryKey('property_id');
    }

}
