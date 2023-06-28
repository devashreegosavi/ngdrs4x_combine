<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class PartyEntryTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_trn_party_entry_new');
        $this->setPrimaryKey('id');
    }

}
