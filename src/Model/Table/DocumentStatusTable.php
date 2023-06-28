<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class DocumentStatusTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_trn_document_status');
        $this->setPrimaryKey('id');
    }

}
